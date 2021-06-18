<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PurchaseOrderItem;
use App\Supplier;
use App\AgreementHeader;
use App\PurchaseRequest;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\View; 
use Illuminate\Support\MessageBag; 
use Carbon\Carbon; 
use Validator; 
use Input; 
use Session; 
use Redirect; 
use App\PurchaseOrder;
use App\Branch;
use Auth;
use App\PurchaseRequestItem;

class PurchaseOrderController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// Retrieve all the purchase order
        $purchaseOrder = PurchaseOrder::all();
		
		// Load the view and pass the retrieved Purchase Order to the view for further processing
		return View::make('purchaseOrder.index')->with('purchaseOrder', $purchaseOrder);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
			return View::make('purchaseOrder.create');
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
		$rules = array ('poNo' => 'required|numeric',
						'requestID' => 'required|numeric',
						'supplierID' => 'required|numeric',
						'type' => 'required',
						'status' => 'required',
						'createdDate' => 'required',
						'account' => 'required|numeric',
						'shipmentAddress' => 'required',);
		
		$message = ['poNo.required' => 'Please input the purchase order number',
					'poNo.numeric' => 'Please input the purchase order number in correct format',
					'requestID.required' => 'Please input the request ID',
					'requestID.numeric' => 'Please input the request ID in correct format',
					'supplierID.required' => 'Please input the supplier id',
					'supplierID.numeric' => 'Please input the supplier id in correct format',
					'type.required' => 'Please input the type',
					'status.required' => 'Please input the status in correct format',
					'createdDate.required' => 'Please input the created date in correct format',
					'account.required' => 'Please input the account',
					'account.numeric' => 'Please input the account in correct format',
					'shipmentAddress.required' => 'Please input the shipment address',];
					
		$validator = Validator::make($input, $rules, $message);
		
		if($validator->fails()) 
		{
			return Redirect::to('purchaseOrder/create')->withErrors($validator);
		} 
		else if (!foreignKeyExists($request))
		{
			return Redirect::to('purchaseOrder/create')->withErrors('The Purchase Order is not found in Pu Table !');
		}
		else 
		{
			$purchaseOrder = new PurchaseOrder;
			$purchaseOrder->requestID = $request->requestID;
			$purchaseOrder->agreementID = $request->agreementID;
			$purchaseOrder->revision = $request->revision;
			$purchaseOrder->releaseNo = $request->releaseNo;
			$purchaseOrder->supplierID = $request->supplierID;
			$purchaseOrder->type = $request->type;
			$purchaseOrder->status = $request->status;
			$purchaseOrder->quotationNo = $request->quotationNo;
			$purchaseOrder->createdDate = $request->createdDate;
			$purchaseOrder->account = $request->account;
			$purchaseOrder->shipmentAddress = $request->shipmentAddress;
			$purchaseOrder->save();
			return back()->with('Apply purchaseOrder Information','Apply Purchase Order Information Sucessfully!');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($poNo)
    {
		$purchaseOrder = PurchaseOrder::find($poNo);
		
		$purchaseOrderItem=PurchaseOrderItem::where('poNo',$poNo)->get();
		
		return View::make('purchaseOrder.show')->with('purchaseOrder',$purchaseOrder)
												->with('purchaseOrderItem',$purchaseOrderItem);
		
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $purchaseOrder = PurchaseOrder::all();
        // Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('purchaseOrder.edit')->with('purchaseOrder', $purchaseOrder);     
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $input = $request->all();
		$rules = array ('poNo' => 'required',);
		
		$messages = ['poNo.required' => 'Please input the purchase order number',];
  
        $validator = Validator::make($input, $rules, $messages);                 
        if ($validator->fails()) 
		{             
            return Redirect::to('purchaseOrder/editStatus')->withErrors($validator);        
        }
        else 
		{
			$poNo = $request->input('poNo', []);
			$status = $request->input('status', []);
			
			for ($item=0; $item < count($poNo); $item++) {
				if (($poNo[$item] != '') || ($poNo[$item] != null)) {
					$purchaseOrder = PurchaseOrder::where('poNo', $poNo[$item])->first();
					if($purchaseOrder->status==='Completed' ){
			            		 return back()->withErrors('You cannot change completed Purchase Order');  
			    	       }
			    	    
                        $purchaseOrder->status = $status[$item];
        				 //$purchaseOrder->save();   
	   
            			return back()->with('success',$poNo[$item] );  
                    }
                }
			
			
   //         $purchaseOrder = PurchaseOrder::where('poNo',$request->poNo)->first();       
            
   //         if($purchaseOrder->status==='Completed' ){
   //         	 return back()->withErrors('You cannot change completed Purchase Order');  
   //         }
			// $purchaseOrder->status = $request->status;
   //         $purchaseOrder->save();         
   //         return back()->with('success','Successfully updated purchase order Information!');     
        }         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($poNo)
    {
		$purchaseOrder = PurchaseOrder::find($poNo);          
		$purchaseOrder->delete();
		return redirect('purchaseOrder')->with('success','Purchase order deleted successfully');
    }
    
    /*************************************
     ********  Extend Function ***********
     *************************************/
    
    public function foreignKeyExists($request) 
	{
		return PurchaseRequest::where('requestID', $request->requestID)->where('branchID', $request->branchID)->exists() ||
				AgreementHeader::where('agreementID', $request->agreementID)->where('revision', $request->revision)->exists() ||
				Supplier::find($request->supplierID)->exists();
	}
	
	
	public function getAgreementHeader($agreementID, $revision)
	{
		/** REMINDER: get single value ( $value->price )**/
		
		return AgreementHeader::where('agreementID', $agreementID)->where('revision', $revision)->first();
	}
	
	public function getSupplier($supplierID)
	{
		/** REMINDER: get single value ( $value->name )**/
		
		return Item::where('supplierID',$supplierID)->first();
	}
	
	public function getPurchaseRequest($requestID, $branchID)
	{
		/** REMINDER: get single value ( $value->name )**/
		
		return PurchaseRequest::where('requestID', $requestID)->where('branchID', $branchID)->first();
	}
	
	public function getPurchaseOrderItems($poNo)
	{
		/** REMINDER: get single value ( $value->name )**/
		
		return PurchaseOrderItem::where('poNo', $poNo)->get();
	}
	
	public function editStatus(){
		
		$purchaseOrder=PurchaseOrder::all();
		
		return View::make('purchaseOrder.editStatus')->with('purchaseOrder', $purchaseOrder);
		
	}
	
	public function createSPO($requestID){
		
		
		$purchaseRequest=PurchaseRequest::where('requestID',$requestID)->first();
		
		$purchaseOrder=self::getPONumber();
		
		$purchaseRequestItem = PurchaseRequestItem::where('requestID',$requestID)->get();
		
		$SupplierIDAndName=Supplier::pluck('name','supplierID')->toArray();
		
		
		return View::make('purchaseOrder.createSPO')->with('purchaseRequest',$purchaseRequest)
													->with('purchaseOrder',$purchaseOrder)
													->with('purchaseRequestItem',$purchaseRequestItem)
													->with('SupplierIDAndName',$SupplierIDAndName);
	}
	
	
	public static function getPONumber(){
		
		$poNo=PurchaseOrder::select('poNo')->orderBy('poNo','desc')->first();
		
		if($poNo==''||$poNo== null){
			$poNo=0;
		}else{
			$poNo=PurchaseOrder::select('poNo')->orderBy('poNo','desc')->first()->poNo;
		}
		return $poNo;
	}
	
	public static function updateStatus($poNo)
	{
		$purchaseOrder = PurchaseOrder::where('poNo',$poNo)->first();
		
		if($purchaseOrder->status == 'Completed'){
			return back()->withErrors('This Purchase Order is completed already.');
		}
		else if($purchaseOrder->status == 'Pending for Delivery'){
			return back()->withErrors('This purchase order is not yet delivered.');
		} else {
			$purchaseOrder = PurchaseOrder::where('poNo',$poNo)->update(['status'=>'Completed']);
			return back()->with('success','Successfully');
		}
	}

	public function createSPOWithDetail(Request $request){
		
		$input = $request->all();
		$rules = array (
						'requestID' => 'required|numeric',
						'supplierID' => 'required|numeric',
						'account' => 'required|numeric',);
		
		$message = [
					'requestID.required' => 'Please input the request ID',
					'requestID.numeric' => 'Please input the request ID in correct format',
					'supplierID.required' => 'Please input the supplier id',
					'supplierID.numeric' => 'Please input the supplier id in correct format',
					'account.required' => 'Please input the account',
					'account.numeric' => 'Please input the account in correct format',];
			
		$validator = Validator::make($input, $rules, $message);
	
		if($validator->fails()) 
		{
			return back()->withErrors($validator);
		} 
		else 
		{
			$purchaseOrder = new PurchaseOrder;
			$purchaseOrder->requestID = $request->requestID;
			$purchaseOrder->agreementID = null; //nullable
			$purchaseOrder->revision = null; //nullable
			$purchaseOrder->releaseNo = null; //nullable
			$purchaseOrder->supplierID = $request->supplierID;
			$purchaseOrder->type ='Standard Purchase Order';
			$purchaseOrder->status = 'Pending for Delivery';
			$purchaseOrder->quotationNo = $request->quotationNo; //nullable
			$purchaseOrder->createdDate = Carbon::now();
			$purchaseOrder->account = $request->account;
			$purchaseOrder->shipmentAddress = BranchController::getBranchName(PurchaseRequest::where("requestID", $request->requestID)->first()->branchID)->address;
			$purchaseOrder->save();
			
			$poNo = PurchaseOrder::orderBy("poNo", "desc")->first()->poNo;
			$itemID = $request->input('itemID', []);
            $quantity = $request->input('quantity', []);
            $price = $request->input('price', []);
            
            for ($item=0; $item < count($itemID); $item++) {
                $purchaseOrderItem = new PurchaseOrderItem ;
                if ($itemID[$item] != '') {
                    $purchaseOrderItem->poNo = $poNo;
                    $purchaseOrderItem->itemID= $itemID[$item];
                    $purchaseOrderItem->quantity = $quantity[$item];
                    $purchaseOrderItem->amount = $quantity[$item] * $price[$item] ;
                	$purchaseOrderItem->balance = $quantity[$item];
					$purchaseOrderItem->save();

					$purchaseRequestItem = PurchaseRequestItem::where('requestID',$request->requestID)
																->where('itemID',$itemID[$item])
																->first();
														
  									
					$updateBalance = $purchaseRequestItem->balance-$purchaseOrderItem->quantity ;	
						
					if($purchaseRequestItem->balance < $purchaseOrderItem->quantity){
						return back()->withErrors("Exceed");
					}
     
					$purchaseRequestItem = PurchaseRequestItem::where('requestID',$request->requestID)
																->where('itemID',$itemID[$item])
																->update(['balance'=>$updateBalance]);
                }
            }
            
            $purchaseRequestItem=PurchaseRequestItem::where('requestID', $request->requestID)->get();
            $checking = true;
			foreach($purchaseRequestItem as $key =>$value){
				if($value->balance != 0){
					$checking = false;
					return back()->with('success','But the PR still have balance');
				}
			}
			if($checking == false){
					return back()->with('success','But the PR still have balance');
			}else{
				$purchaseRequest = PurchaseRequest::where('requestID', $request->requestID)->update(['status' => 'Pending for Delivery']);
				return back()->with('success','The purchase request is mapped successfully');
			}
		}
	
	}
}
