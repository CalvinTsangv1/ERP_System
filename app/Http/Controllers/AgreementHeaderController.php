<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;
use Carbon\Carbon;
use Validator;
use Input;
use Session;
use Redirect;
use Illuminate\Http\Request;
use App\AgreementHeader;
use Illuminate\Database\Eloquent\Builder;
use App\AgreementLine;
use App\Supplier;
use App\Item;
use App\PurchaseOrder;
use App\AgreementPriceBreak;

class AgreementHeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// Retrieve all the branch agreementHeader
        $agreementHeader = AgreementHeader::all();
        
		
		// Load the view and pass the retrieved agreementHeader agreementHeader to the view for further processing
		return View::make('agreementHeader.index')->with('agreementHeader', $agreementHeader);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$checkAgreementID = AgreementHeader::orderBy('agreementID', 'desc')->first();
    	$supplier = Supplier::pluck('name', 'supplierID')->toArray();
		$agreementType = AgreementHeader::pluck('type', 'type')->toArray();
		$newArray = [];
		$count = 0;
		$virtualID = Item::pluck('virtualItemID')->toArray();  //orderBy("virtualItemID")->  <<deleted!
    	$unit = Item::pluck('unitOfMeasurement')->toArray();
		$itemName = Item::pluck('name', 'itemID')->toArray();  //orderBy('name', 'asc')->
		foreach($itemName as $key => $value) {
    		$value = $virtualID[$count]." : ".$value." --- ".$unit[$count] ;
    		$newArray[$key] = $value;
    		$count++;
    	}
		$latestAgreementIDAndRevision = AgreementHeader::orderBy('agreementID', 'desc')->first();
    	
		return View::make('agreementHeader.create')->with('checkAgreementID',$checkAgreementID)
												   ->with('supplier',$supplier)
												   ->with('agreementType',$agreementType)
												   ->with('itemName',$newArray)
												   ->with('latestAgreementIDAndRevision',$latestAgreementIDAndRevision);
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
		$rules = array ('agreementID' => 'required|numeric',
						'revision' => 'required|numeric',
						'supplierID' => 'required|numeric',
						'type' => 'required',
						'createdDate' => 'required|date',
						'effectiveDate' => 'required|date',
						'expiryDate' => 'required|date',
						'currency' => 'required',
						'termsAndCondition' => 'required',
						'deliveryAddress' => 'required',);
		
		$messages = ['agreementID.required' => 'Please input the agreement id',
					 'agreementID.numeric' => 'Please input the agreement id in correct format',
					 'revision.required' => 'Please input the revision no.',
					 'revision.numeric' => 'Please input the revision no. in correct format',
					 'supplierID.required' => 'Please input the supplier id',
					 'supplierID.numeric' => 'Please input the supplier id in correct format',
					 'type.required' => 'Please input the agreement type',
					 'createdDate.required' => 'Please input the created date',
					 'createdDate.date' => 'Please input the created date in correct date format',
					 'effectiveDate.required' => 'Please input the effective date',
					 'effectiveDate.date' => 'Please input the effective date in correct date format',
					 'expiryDate.required' => 'Please input the expiry date',
					 'expiryDate.date' => 'Please input the expiry date in correct date format',
					 'currency.required' => 'Please input the currency',
					 'termsAndCondition.required' => 'Please input the terms and condition',
					 'deliveryAddress.required' => 'Please input the delivery address'];
					
		$validator = Validator::make($input, $rules, $messages);
		
		if($validator->fails()) 
		{
			return Redirect::to('agreementHeader/create')->withErrors($validator);
		} 
		else 
		{
			$agreementHeader = new AgreementHeader;
			$agreementHeader->agreementID = $request->agreementID;
			$agreementHeader->revision = $request->revision;
			$agreementHeader->supplierID = $request->supplierID;
			$agreementHeader->type = $request->type;
			$agreementHeader->createdDate = $request->createdDate;
			$agreementHeader->effectiveDate = $request->effectiveDate;
			$agreementHeader->expiryDate = $request->expiryDate;
			if ((($request->effectiveDate <= date("Y-m-d")) && (date("Y-m-d") <= $request->expiryDate))){
				$temp = "Active";
			} else if ($request->expiryDate <= date("Y-m-d")){
				$temp = "Expired";
			} else if ($request->effectiveDate >= date("Y-m-d")){
				$temp = "Inactive";
			}
			$agreementHeader->status = $temp;
			$agreementHeader->amountAgreed = $request->amountAgreed;
			$agreementHeader->currency = $request->currency;
			$agreementHeader->termsAndCondition = $request->termsAndCondition;
			$agreementHeader->tentativeSchedule = $request->tentativeSchedule;
			$agreementHeader->deliveryAddress = $request->deliveryAddress;			
			$agreementHeader->save();
			return Redirect::to('agreementLine/create')->with('success','Apply agreementHeader Information Sucessfully'."\n".'Please input the agreement line');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($agreementID, $revision)
    {
        // Retrieve the agreementHeader       
		$agreementHeader = AgreementHeader::where('agreementID', $agreementID)->where('revision', $revision)->first();
		$agreementLine = AgreementLine::where('agreementID', $agreementID)->where('revision', $revision)->get();
	     
		  
		// Load the view and pass the retrieved order detail to the view for further processing        
    	return View::make('agreementHeader.show')->with(compact('agreementHeader', $agreementHeader))
    											 ->with(compact('agreementLine', $agreementLine));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($agreementID, $revision)
    {
    	// Retrieve the agreementHeader        
        $agreementHeader = AgreementHeader::where('agreementID', $agreementID)->where('revision', $revision)->first();
    	$supplier = Supplier::pluck('name', 'supplierID')->toArray();
		$agreementType = AgreementHeader::pluck('type', 'type')->toArray();
		$newArray = [];
		$count = 0;
		$virtualID = Item::pluck('virtualItemID')->toArray();  //orderBy("virtualItemID")->  <<deleted!
    	$unit = Item::pluck('unitOfMeasurement')->toArray();
		$itemName = Item::pluck('name','itemID')->toArray(); //orderBy('name', 'asc')->
		foreach($itemName as $key => $value) {
    		$value = $virtualID[$count]." : ".$value." --- ".$unit[$count] ;
    		$newArray[$key] = $value;
    		$count++;
    	}
        // Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('agreementHeader.edit')->with('agreementHeader', $agreementHeader)
    											 ->with('supplier', $supplier)
												 ->with('agreementType', $agreementType)
												 ->with('itemName', $newArray);
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
		$rules = array ('agreementID' => 'required|numeric',
						'revision' => 'required|numeric',
						'supplierID' => 'required|numeric',
						'type' => 'required',
						'createdDate' => 'required|date',
						'effectiveDate' => 'required|date',
						'expiryDate' => 'required|date',
						'status' => 'required',
						'currency' => 'required',
						'termsAndCondition' => 'required',
						'deliveryAddress' => 'required',);
		
		$messages = ['agreementID.required' => 'Please input the agreement id',
					 'agreementID.numeric' => 'Please input the agreement id in correct format',
					 'revision.required' => 'Please input the revision',
					 'revision.numeric' => 'Please input the revision in correct format',
					 'supplierID.required' => 'Please input the supplier id',
					 'supplierID.numeric' => 'Please input the supplier id in correct format',
					 'type.required' => 'Please input the type',
					 'createdDate.required' => 'Please input the created date',
					 'createdDate.date' => 'Please input the created date in correct date format',
					 'effectiveDate.date' => 'Please input the effective date in correct date format',
					 'effectiveDate.required' => 'Please input the effective date',
					 'expiryDate.date' => 'Please input the expiry date in correct date format',
					 'expiryDate.required' => 'Please input the expiry date',
					 'status.required' => 'Please input the status',
					 'currency.required' => 'Please input the currency',
					 'termsAndCondition.required' => 'Please input the terms and condition',
					 'deliveryAddress.required' => 'Please input the delivery address'];
  
        $validator = Validator::make($input, $rules, $messages);                 
        if ($validator->fails()) 
		{             
            return Redirect::to('agreementHeader')->withErrors($validator);        
        } 
		else
		{       
			$agreementHeader = AgreementHeader::where('agreementID', $request->agreementID)->where('revision', $request->revision)->first();
			$agreementHeaderRevision = AgreementHeader::where('agreementID', $request->agreementID)->orderBy('revision', 'desc')->first();
			
			if($agreementHeader->status === 'Disabled'){
				return back()->withErrors('Cannot update the disabled agreement');
			}else if($agreementHeader->revision !== $agreementHeaderRevision->revision){
				return back()->withErrors('Cannot update the susperseded agreement');
			}
			
			DB::table('agreement_header')->where('agreementID', $request->agreementID)->where('revision', $request->revision)->update(['status'=>'Superseded']);
			
			$newAgreementHeader= new AgreementHeader;
   			$newAgreementHeader->agreementID = $request->agreementID;
			$newAgreementHeader->revision = ($request->revision+1);
			$newAgreementHeader->supplierID = $request->supplierID;
			$newAgreementHeader->type = $request->type;
			$newAgreementHeader->createdDate = $request->createdDate;
			$newAgreementHeader->effectiveDate = $request->effectiveDate;
			$newAgreementHeader->expiryDate = $request->expiryDate;
			if ((($request->effectiveDate <= date("Y-m-d")) && (date("Y-m-d") <= $request->expiryDate))){
				$temp = "Active";
			} else if ($request->expiryDate <= date("Y-m-d")){
				$temp = "Expired";
			} else if ($request->effectiveDate >= date("Y-m-d")){
				$temp = "Inactive";
			}
			$newAgreementHeader->status = $temp;
			$newAgreementHeader->amountAgreed = $request->amountAgreed;
			$newAgreementHeader->currency = $request->currency;
			$newAgreementHeader->termsAndCondition = $request->termsAndCondition;
			$newAgreementHeader->tentativeSchedule = $request->tentativeSchedule;
			$newAgreementHeader->deliveryAddress = $request->deliveryAddress;
			$newAgreementHeader->save();   
			
			$itemID = $request->input('itemID', []);
            $promisedQuantity = $request->input('promisedQuantity', []);
		    $minimumOrderQuantity = $request->input('minimumOrderQuantity', []);
            $price = $request->input('price', []);
			$reference = $request->input('reference', []);
            
            for($item=0; $item < count($itemID); $item++) {
            	if(	($itemID[$item] != '') && ($promisedQuantity[$item] != '') && ($minimumOrderQuantity[$item] != '') && ($price[$item] != '')) {
					$agreementLine = new AgreementLine;
					$agreementLine->agreementID = $request->agreementID;
                    $agreementLine->revision = ($request->revision+1);
                    $agreementLine->itemID = $itemID[$item];
                    $agreementLine->promisedQuantity = $promisedQuantity[$item];
                    $agreementLine->minimumOrderQuantity = $minimumOrderQuantity[$item];
                    $agreementLine->balance = $promisedQuantity[$item];
                    $agreementLine->price = $price[$item];
                    $agreementLine->reference = $reference[$item];
                    $agreementLine->save();
            	}
            	
            	$agreementPriceBreak = new AgreementPriceBreak;
            	
            	$agreementPriceBreak->agreementID=$agreementLine->agreementID;
    		   	$agreementPriceBreak->revision=$agreementLine->revision;
    		   	$agreementPriceBreak->itemID=$agreementLine->itemID;
    		   	$agreementPriceBreak->priceBreak=0;	
    		   	$agreementPriceBreak->discount=1;
            	$agreementPriceBreak->save();
            }
            return redirect('agreementHeader')->with('success','Agreement updated successfully');
        }         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($agreementID, $revision)
    {
    	// Purchase Order (agreementID, revision)-> agreement Price Break (agreementID, revision) ->
    	// agreement line (agreementID, revision)-> agreement header (agreement, revision)
    	PurchaseOrder::where('agreementID', $agreementID)->where('revision', $revision)->delete();
    	AgreementPriceBreak::where('agreementID', $agreementID)->where('revision', $revision)->delete();
    	AgreementLine::where('agreementID', $agreementID)->where('revision', $revision)->delete();
		$agreementHeader = AgreementHeader::where('agreementID', $agreementID)->where('revision', $revision)->delete();          

		return redirect('agreementHeader')->with('success','Agreement deleted successfully');
    }
    
    /*************************************
     ********  Extend Function ***********
     *************************************/
    
    public function foreignKeyExists($request) 
	{
		return AgreementHeader::where('supplierID', $request->supplierID)->exists();
	}
	
	public function getAgreementPriceBreaks($agreementID, $revision)
	{
		return AgreementPriceBreak::where('agreementID', $agreementID)->where('revision', $revision)->get();
	}
	
	/*** Get supplier's Information **/
	public function getSupplier($supplier) 
	{
		return Supplier::where('supplierID')->first();
	}
	
	/*** Get pruchase orders or null information ***/
	public function getPurchaseOrders($agreementID)
	{
		return PurchaseOrder::where('agreementID')->get();
	}
	
	public function getBranchItemByItemID($id) {
		if(BranchItem::where('itemID', $id)->get() == null) {
			return redirect('branchItem')->withError('No Item in BranchItem table');
		}else {
			$result = BranchItem::where('itemID', $id)->get();
			return $result;
		}
	}
	
	public function storeWithDetails(Request $request)
    {
        $input = $request->all();
		$rules = array ('agreementID' => 'required|numeric',
						'revision' => 'required|numeric',
						'supplierID' => 'required|numeric',
						'type' => 'required',
						'createdDate' => 'required|date',
						'effectiveDate' => 'required|date',
						'expiryDate' => 'required|date',
						'currency' => 'required',
						'termsAndCondition' => 'required',
						'deliveryAddress' => 'required',);
		
		$messages = ['agreementID.required' => 'Please input the agreement id',
					 'agreementID.numeric' => 'Please input the agreement id in correct format',
					 'revision.required' => 'Please input the revision',
					 'revision.numeric' => 'Please input the revision in correct format',
					 'supplierID.required' => 'Please input the supplier id',
					 'supplierID.numeric' => 'Please input the supplier id in correct format',
					 'type.required' => 'Please input the type',
					 'createdDate.required' => 'Please input the created date',
					 'createdDate.date' => 'Please input the created date in correct date format',
					 'effectiveDate.date' => 'Please input the effective date in correct date format',
					 'effectiveDate.required' => 'Please input the effective date',
					 'expiryDate.date' => 'Please input the expiry date in correct date format',
					 'expiryDate.required' => 'Please input the expiry date',
					 'currency.required' => 'Please input the currency',
					 'termsAndCondition.required' => 'Please input the terms and condition',
					 'deliveryAddress.required' => 'Please input the delivery address'];
					
		$validator = Validator::make($input, $rules, $messages);
		
		if($validator->fails()) 
		{
			return back()->withErrors($validator);
		} 
		else 
		{
			$agreementHeader = new AgreementHeader;
			$agreementHeader->agreementID = $request->agreementID;
			$agreementHeader->revision = $request->revision;
			$agreementHeader->supplierID = $request->supplierID;
			$agreementHeader->type = $request->type;
			$agreementHeader->createdDate = $request->createdDate;
			$agreementHeader->effectiveDate = $request->effectiveDate;
			$agreementHeader->expiryDate = $request->expiryDate;
			if ((($request->effectiveDate <= date("Y-m-d")) && (date("Y-m-d") <= $request->expiryDate))){
				$temp = "Active";
			} else if ($request->expiryDate <= date("Y-m-d")){
				$temp = "Expired";
			} else if ($request->effectiveDate >= date("Y-m-d")){
				$temp = "Inactive";
			}
			$agreementHeader->status = $temp;
			$agreementHeader->amountAgreed = $request->amountAgreed;
			$agreementHeader->currency = $request->currency;
			$agreementHeader->termsAndCondition = $request->termsAndCondition;
			$agreementHeader->tentativeSchedule = $request->tentativeSchedule;
			$agreementHeader->deliveryAddress = $request->deliveryAddress;			
			$agreementHeader->save();
			
			$itemID = $request->input('itemID', []);
            $promisedQuantity = $request->input('promisedQuantity', []);
			$minimumOrderQuantity = $request->input('minimumOrderQuantity', []);
            $price = $request->input('price', []);
            $reference = $request->input('reference', []);
            
			for($item=0; $item < count($itemID); $item++) {
				if(($itemID[$item] != '') && ($promisedQuantity[$item] != '') && ($minimumOrderQuantity[$item] != '') && ($price[$item] != '')) {
					$agreementLine = new AgreementLine;
                	$agreementLine->agreementID = $request->agreementID;
                    $agreementLine->revision = $request->revision;
                    $agreementLine->itemID = $itemID[$item];
                    $agreementLine->promisedQuantity = $promisedQuantity[$item];
                    $agreementLine->minimumOrderQuantity = $minimumOrderQuantity[$item];
                    $agreementLine->balance = $promisedQuantity[$item];
                    $agreementLine->price = $price[$item];
                    $agreementLine->reference = $reference[$item];
                    $agreementLine->save();
                    
                    if ($itemID[$item] != '') {
                    	$agreementPriceBreak = new AgreementPriceBreak;
                    	$agreementPriceBreak->agreementID = $request->agreementID;
                    	$agreementPriceBreak->revision = $request->revision;
                    	$agreementPriceBreak->itemID = $itemID[$item];
                    	$agreementPriceBreak->priceBreak = 0;
                    	$agreementPriceBreak->discount = 1;
                    	$agreementPriceBreak->save();
                    }
            	}
			}
		}
		return Redirect::to('agreementHeader')->with('success','Agreement created successfully');
    }

	public function disable($agreementID, $revision){
		
		$agreementHeader = AgreementHeader::where('agreementID', $agreementID)->where('revision', $revision)->first(); 
		 
		if( $agreementHeader->status === 'Active'){
			$agreementHeader->status='Disabled';
			$agreementHeader = AgreementHeader::where('agreementID', $agreementID)->where('revision', $revision)->update(['status' => 'Disabled']);
			return back()->with('success','Disabled the Agreement Successfully');
		}
		return back()->withErrors('Cannot disable the agreement');
	}	
}
