<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;
use Carbon\Carbon;
use Validator;
use Input;
use Session;
use Redirect;
use Illuminate\Http\Request;
use App\PurchaseRequest;
use App\PurchaseRequestItem;
use App\PurchaseOrder;
use App\PurchaseOrderItem;
use App\AgreementHeader;
use App\AgreementLine;
use App\AgreementPriceBreak;
use App\DispatchInstruction;
use App\DispatchInstructionItem;
use App\BranchItem;
use App\Branch;

class AutomationPurchaseRequestMappingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $staffID;
    private $postTitle;
    private $branchID;
    private $expectedDeliveryDate;
    private $ItemArray;
    private static $autoClass = "";
     
    public function readConfiguration($fileName)
	{
		$xmlObject = simplexml_load_string(file_get_contents(app_path($fileName)));
		
		$this->staffID = $xmlObject->staff;
		$this->postTitle = $xmlObject->postTitle;
		$this->branchID = $xmlObject->branch;
		$this->expectedDeliveryDate = $xmlObject->expectedDeliveryDate;
		
		for($x=0; $x < count($xmlObject->Item); $x++)
		{
			$id = $xmlObject->Item[$x]->attributes();
			if(is_array($this->ItemArray))
			{
				array_push($this->ItemArray,array('id' => $id,
												  'quantity' => $xmlObject->Item[$x]->quantity, 
												  'balance' => $xmlObject->Item[$x]->balance));
			}
			else
			{
				$this->ItemArray = array(array('id' => $id, 
											   'quantity' => $xmlObject->Item[$x]->quantity, 
											   'balance' => $xmlObject->Item[$x]->balance));
			}
		}	
	}
	
	public function getConfigurationValues()
	{
		echo $this->staffID;
		echo $this->postTitle;
		echo $this->branchID;
		echo $this->ItemArray;
	}
	
	public static function buttonClick()
	{
		$auto = new AutomationPurchaseRequestMappingController;
		if($auto->autoExecutePurchaseRequest())
		{
			return redirect('mapPurchaseRequest/auto')->with("Success", "Mapped All Purchase Requests Successfully");
		}else {
			return Redirect::to("mapPurchaseRequest/auto")->withErrors("Purchase Requests Maaping Unsuccessful and Stop Processing");
		}
	}
	
	public function autoExecutePurchaseRequest()
	{
		foreach(PurchaseRequest::where('status', 'Pending for Mapping')->get() as $key => $tempPurchaseRequest)
		{
			foreach(PurchaseRequestItem::where('requestID', $tempPurchaseRequest->requestID)->where('balance', '>', 0)->get() as $key => $tempPurchaseRequestItem)
			{
				$currentQuantity = $this->processBlanketPurchaseAgreement((int)$tempPurchaseRequestItem->balance,
																		  $tempPurchaseRequestItem->itemID, 
																		  $tempPurchaseRequest->requestID,
																		  $tempPurchaseRequest->branchID);
				if($currentQuantity != 0) 
				{
					//Blanket Purchase Agreement Failed, Check Warehouse
					$currentQuantity = $this->processWarehouse(	$tempPurchaseRequest->branchID,
																$tempPurchaseRequest->requestID, 
																$tempPurchaseRequestItem->itemID,
																$currentQuantity);
					if($currentQuantity != 0)
					{
						$currentQuantity = $this->processPlannedPurchaseAgreement($tempPurchaseRequest->itemID,
																				  $tempPurchaseRequest->requestID,
																				  $currentQuantity);
						if($currentQuantity != 0) {
							$purchaseRequest = PurchaseRequest::where('requestID', $tempPurchaseRequest->requestID)->update(["status" => "Failed"]);
						}else {
							break;
						}
					}
				}
			}
		}
		return true;
	}
	
	
	// if input balance = output balance, normal case, if input balance < output balance, as minimum quantity	
	public function processBlanketPurchaseAgreement($balance, $itemID, $requestID, $branchID)
	{
		//echo "Balance:".$balance." , itemID:".$itemID." , requestID:".$requestID." , branchID:".$branchID;
		$agreementList = [];
		(int)$currentBalance = $balance;
		
		foreach(AgreementLine::where('itemID',$itemID)->orderBy('price','asc')->orderBy('balance','desc')->get()->pluck('agreementID') as $value)
		{
			$agreementHeader = AgreementHeader::where("agreementID", $value)->where("status","Active")->where("type","Blanket Purchase Agreement")->orderBy('expiryDate','asc')->orderBy('createdDate','asc')->first();
			if($agreementHeader != null) {
				if($agreementHeader->expiryDate > Carbon::today())
				{
					$agreement = AgreementLine::where('agreementID', $value)->where('revision', $agreementHeader->revision)->where('itemID', $itemID)->first();
					if($agreement != null) {
					if($agreement->balance >= $currentBalance && $currentBalance >= $agreement->minimumOrderQuantity) 
					{
			
						$discount = (float)AgreementPriceBreak::where('agreementID', $value)->where('revision', $agreementHeader->revision)->where('itemID', $itemID)->where('priceBreak','<=',$currentBalance)->orderBy('priceBreak','desc')->first()->discount;
						if($discount != null) {
							$amount = $currentBalance * (int)$agreement->price * $discount;
						}else {
							$amount = $currentBalance * (int)$agreement->price;
						}
						$this->updateAgreementLine($agreement, (int)($agreement->balance - $currentBalance));
						$this->updatePurchaseOrder($requestID, $agreement, $agreementHeader, $branchID);
						$this->updatePurchaseOrderItem($itemID, $currentBalance, $amount, $currentBalance);
						$this->updatePurchaseRequest($requestID);
						$this->updatePurchaseRequestItem($requestID, $itemID, 0);
						
						return 0;
					}
					else 
					{
						// currentBalance > Agreement->balance
						$currentBalance = $currentBalance - $agreement->balance;
						$discount = (float)AgreementPriceBreak::where('agreementID', $value)->where('revision', $agreementHeader->revision)->where('itemID', $itemID)->where('priceBreak','<=',$agreement->balance)->orderBy('priceBreak','desc')->first()->discount;
						$amount = (int)$agreement->balance * $agreement->price * $discount;
						$this->updateAgreementLine($agreement,0);
						$this->updatePurchaseOrder($requestID, $agreement, $agreementHeader, $branchID);
						$this->updatePurchaseOrderItem($itemID, $agreement->balance, $amount, $agreement->balance);
						$this->updatePurchaseRequestItem($requestID, $itemID, $currentBalance);
					}
					}
				}
			}
		}
		return $currentBalance;
	}

	
	// If warehouse fulfill the quantity of item, mapped to Dispatch Instruction, and return true
	
	public function processWarehouse($branchID, $requestID, $itemID, $quantity) {
		//echo "Called Warehouse";
		(int)$currentQuantity = $quantity;
		$warehouse = Branch::where("name","Warehouse")->pluck("branchID")[0];
		$branchItem = BranchItem::where("branchID", $warehouse)->where("itemID", $itemID)->first();
		if($branchItem == null) {
			return $currentQuantity;
		}
		
		//Branch Storage can handle the quantity of order.
		if($branchItem->quantity >= $currentQuantity) {
			$currentQuantity = $branchItem->quantity - $currentQuantity;
			BranchItem::where("branchID", $warehouse)->where("itemID", $itemID)->update(["quantity"=>$currentQuantity]);

			
			$this->updateDispatchInstruction($requestID, $itemID, $quantity, 0);
			$this->updatePurchaseRequest($requestID);
			$this->updatePurchaseRequestItem($requestID, $itemID, 0);
			
			return 0;
		}
		
		//Branch Storage cannot handle the quantity of order.
		$currentQuantity = $currentQuantity - $branchItem->quantity;
		
		BranchItem::where("branchID", $warehouse)->where("itemID", $itemID)->update(["quantity"=>0]);
			
		$this->updateDispatchInstruction($requestID, $itemID, $branchItem->quantity , 0);
		return $currentQuantity; 
	}
	
	public function processPlannedPurchaseAgreement($itemID, $requestID, $quantity) {
		(int)$currentQuantity = $quantity;
		foreach(AgreementLine::where("itemID",$itemID)->get()->pluck("agreementID") as $value)
		{	
			$agreementHeader = AgreementHeader::where("agreementID", $value)->where("type", "Planned Purchase Agreement")->where("status","Active")->whereBetween("createdDate", [Carbon::now()->subDays(3),Carbon::now()])->first();
			if($agreementHeader != null) {
				$agreement = AgreementLine::where('agreementID', $value)->where('revision', $agreementHeader->revision)->where('itemID', $itemID)->first();
				if($agreement->balance >= $currentQuantity) {
					$amount = $currentQuantity * $agreement->price * $discount;
					$this->updateAgreementLine($agreement, (int)($agreement->balance - $currentQuantity));
					$this->updatePurchaseOrder($requestID, $agreement, $agreementHeader, $branchID);
					$this->updatePurchaseOrderItem($itemID, $currentQuantity, $amount, $currentQuantity);
					$this->updatePurchaseRequest($requestID);
					$this->updatePurchaseRequestItem($requestID, $itemID, 0);
					return 0;
				}else {
					
					$currentQuantity = $currentQuantity -$agreement->balance;
					$amount = (int)$agreement->balance * (int)$agreement->price * $discount;
					$this->updateAgreementLine($agreement, 0);
					$this->updatePurchaseOrder($requestID, $agreement, $agreementHeader, $branchID);
					$this->updatePurchaseOrderItem($itemID, $currentQuantity, $amount, $currentQuantity);
					$this->updatePurchaseRequestItem($requestID, $itemID, $currentQuantity);
					return $currentQuantity;
				}		
			}
		
		}
		return $currentQuantity;
	}
	
	public function updateDispatchInstruction($requestID, $itemID, $quantity, $balance) 
	{
		$dispatchInstruction = new DispatchInstruction;
		$dispatchInstruction->requestID = $requestID;
		$dispatchInstruction->createdDate = Carbon::now();
		$dispatchInstruction->status = "Incomplete";
		$dispatchInstruction->save();
			
		$dispatchInstructionItem = new DispatchInstructionItem;
		$dispatchInstructionItem->diNo = DispatchInstruction::orderBy('diNo','desc')->first()->diNo;
		$dispatchInstructionItem->itemID = $itemID;
		$dispatchInstructionItem->quantity = $quantity;
		$dispatchInstructionItem->balance = $balance;
		$dispatchInstructionItem->save();
	}
	
	public function updatePurchaseRequest($requestID) {
		$checkingBalance = true;
		foreach(PurchaseRequestItem::where("requestID")->pluck('balance') as $value)
		{
			if($value > 0) {
				$checkingBalance = false;
			}
		}
		if($checkingBalance) {
			$purchaseRequest = PurchaseRequest::where('requestID',$requestID)->update(["status"=>"Pending for Delivery"]);
		}
	}
	
	public function updatePurchaseRequestItem($requestID, $itemID, $balance) {
		
		$purchaseRequestItem = PurchaseRequestItem::where("requestID", $requestID)->where("itemID", $itemID)->update(['balance'=>$balance]);
	}
	
	public function updateAgreementLine($agreement, $balance) 
	{
		$agreementLine = AgreementLine::where("agreementID", $agreement->agreementID)->where("revision", $agreement->revision)->where("itemID", $agreement->itemID)->update(['balance'=>$balance]);
	}
	
	//return new Purchase Order Number
	
	public function updatePurchaseOrder($requestID, $agreementLine, $agreementHeader, $branchID)
	{
		$purchaseOrder = new PurchaseOrder;
		$purchaseOrder->requestID = $requestID;
		$purchaseOrder->agreementID = $agreementLine->agreementID;
		$purchaseOrder->revision = $agreementLine->revision;
		$purchaseOrder->releaseNo = (int)PurchaseOrder::where("agreementID", $agreementLine->agreementID)->count() + 1;
		$purchaseOrder->supplierID = $agreementHeader->supplierID;
        switch($agreementHeader->type) {
            case "Blanket Purchase Agreement":
                $purchaseOrder->type = "Blanket Purchase Release";
                break;
            case "Planned Purchase Agreement":
                $purchaseOrder->type = "Planned Purchase Release";
                break;
            case "Contract Purchase Agreement":
                $purchaseOrder->type = "Standard Purchase Release";
                break;
        }
		$purchaseOrder->status = 'Pending for Delivery';
		$purchaseOrder->quotationNo = 1;
		$purchaseOrder->createdDate = Carbon::now()->format("Y-m-d");
		$purchaseOrder->account = 1;
		$purchaseOrder->shipmentAddress = Branch::where('branchID', $branchID)->first()->address;
		$purchaseOrder->save();
	}
	
	public function updatePurchaseOrderItem($itemID, $quantity, $amount, $balance)
	{
		$poNo = PurchaseOrder::orderBy('poNo','desc')->first()->poNo;
		$purchaseOrderItem = new PurchaseOrderItem;
		$purchaseOrderItem->poNo = $poNo;
		$purchaseOrderItem->itemID = $itemID;
		$purchaseOrderItem->quantity = $quantity;
		$purchaseOrderItem->amount = $amount;
		$purchaseOrderItem->balance = $balance;
		$purchaseOrderItem->save();
	}

	
    public function index()
    {
		// Retrieve all the supplier
        $supplier = Supplier::all();
		
		// Load the view and pass the retrieved supplier to the view for further processing
		return View::make('supplier.index')->with('supplier', $supplier);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return View::make('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$input = $request->all();
		$rules = array ('name' => 'required',
						'contactPerson' => 'required',
						'telephone' => 'required|numeric',
						'address' => 'required',);
		
		$messages = ['name.required' => 'Please input the supplier name',
					'contactPerson.required' => 'Please input the supplier contact Person',
					'telephone.required' => 'Please input the telephone number',
					'telephone.numeric' => 'Please input the telephone number in correct format',
					'address.required' => 'Please input the address in correct format',];
					
		$validator = Validator::make($input, $rules, $messages);
		
		if($validator->fails()) {
			return Redirect::to('supplier/create')->withErrors($validator);
		}else {
			$supplier = new Supplier;
			$supplier->name = $request->name;
			$supplier->contactPerson = $request->contactPerson;
			$supplier->telephone = $request->telephone;
			$supplier->address = $request->address;
			$supplier->save();
			return redirect('supplier')->with('success','Apply Supplier Information Sucessfully!');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         // Retrieve the Supplier       
         $supplier = Supplier::find($id);                  
         // Load the view and pass the retrieved order detail to the view for further processing        
         return View::make('supplier.show')->with('supplier', $supplier); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Retrieve the order detail         
        $supplier = Supplier::find($id);                  
        // Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('supplier.edit')->with('supplier', $supplier);         
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();                  
		$rules = array ('name' => 'required',
						'contactPerson' => 'required',
						'telephone' => 'required|numeric',
						'address' => 'required',);
		
		$messages = ['name.required' => 'Please input the supplier name',
					'contactPerson.required' => 'Please input the supplier contact Person',
					'telephone.required' => 'Please input the telephone number',
					'telephone.numeric' => 'Please input the telephone number in correct format',
					'address.required' => 'Please input the address in correct format',];
  
        $validator = Validator::make($input, $rules, $messages); 
        
        if ($validator->fails()) {             
            return Redirect::to('supplier/edit')->withErrors($validator);        
        } else {       
            $supplier = Supplier::find($id);    
            
			$supplier->name = $request->name;
			$supplier->contactPerson = $request->contactPerson;
			$supplier->telephone = $request->telephone;
			$supplier->address = $request->address;
			
            $supplier->save();         
            
            return Redirect::to('supplier')->with('success','Successfully updated Supplier Information!');     
        }         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
		$supplier->delete();
		return redirect('supplier')->with('success','Successfully deleted Supplier!');
    }
	
	public function test($id) {
		$supplier = new Supplier;
			$supplier->name = 'Test Data';
			$supplier->contactPerson = 'Test Person';
			$supplier->telephone = '29998888';
			$supplier->address = 'Test Address';
			$supplier->save();
	}
	
	public static function getSupplierName($id){
	    return Supplier::where('supplierID',$id)->first();
	}
}
