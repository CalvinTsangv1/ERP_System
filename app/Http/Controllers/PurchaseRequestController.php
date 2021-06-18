<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PurchaseRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;
use Carbon\Carbon;
use Validator;
use Input;
use Session;
use Redirect;
use App\Item;
use App\PurchaseRequestItem;
use App\PurchaseOrder;
use App\DispatchInstruction;
use App\Branch;
use Auth;

class PurchaseRequestController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// Retrieve all the purchase order
        $purchaseRequest = PurchaseRequest::where('branchID',Auth::user()->branchID)->get();
		
		// Load the view and pass the retrieved Purchase Order to the view for further processing
		return View::make('purchaseRequest.index')->with('purchaseRequest', $purchaseRequest);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {	
    	$newArray = [];
		$count = 0;
		$virtualID = Item::pluck('virtualItemID')->toArray();  //orderBy("virtualItemID")->  <<deleted!
    	$unit = Item::orderBy("virtualItemID")->pluck('unitOfMeasurement')->toArray();
    	$virtualItemID = Item::pluck('name','virtualItemID')->toArray();
    	foreach($virtualItemID as $key => $value) {
    		$value = $virtualID[$count]." : ".$value." --- ".$unit[$count] ;
    		$newArray[$key] = $value;
    		$count++;
    	}
    	$latestRequestID = PurchaseRequest::orderby('requestID','desc')->first()->requestID;
		return View::make('purchaseRequest.create')->with('latestRequestID',$latestRequestID)->with('virtualItemID',$newArray);
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
		$rules = array ('requestID' => 'required|numeric',
						'branchID' => 'required|numeric',
						'createdDate' => 'required',
						'expectedDeliveryDate' => 'required',
						'status' => 'required',);
		
		$message = ['requestID.required' => 'Please input the request ID',
					'requestID.numeric' => 'Please input the request ID in correct format',
					'branchID.required' => 'Please input the branch id',
					'branchID.numeric' => 'Please input the branch id in correct format',
					'createdDate.required' => 'Please input the created date',
					'expectedDeliveryDate.required' => 'Please input the expected delivery date',
					'status.required' => 'Please input the status',];
					
		$validator = Validator::make($input, $rules, $message);
		
		if($validator->fails()) 
		{
			return Redirect::to('purchaseRequest/create')->withErrors($validator);
		} 
		else if (!foreignKeyExists($request))
		{
			return Redirect::to('purchaseRequest/create')->withErrors('The Purchase Request does not exist in Purchase Request Table!');
		}
		else 
		{
			$purchaseRequest = new PurchaseRequest;
			$purchaseRequest->branchID = $request->branchID;
			$purchaseRequest->createdDate = $request->createdDate;
			$purchaseRequest->expectedDeliveryDate = $request->expectedDeliveryDate;
			$purchaseRequest->status = $request->status;
			if($request->remarks == null) {
				$purchaseRequest->remarks = "";
			}else {
				$purchaseRequest->remarks = $request->remarks;
			}
			$purchaseRequest->save();
			return back()->with('Apply purchaseRequest Information', 'Apply Purchase Request Information Sucessfully!');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // Retrieve the purchaseRequest
        
        // Load the view and pass the retrieved Purchase Order to the view for further processing
		 return $purchaseRequest = self::createNewPRAndStorewithdetails($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($requestID)
    {
        // Retrieve the purchaseRequest        
        $purchaseRequest = PurchaseRequest::find($requestID); 
        $newArray = [];
		$count = 0;
    	$unit = Item::pluck('unitOfMeasurement')->toArray();
    	$virtualID = Item::pluck('virtualItemID')->toArray(); //orderBy("virtualItemID")->
        $virtualItemID = Item::pluck('name','virtualItemID')->toArray();
		foreach($virtualItemID as $key => $value) {
    		$value = $virtualID[$count]." : ".$value." --- ".$unit[$count] ;
    		$newArray[$key] = $value;
    		$count++;
    	}
        // Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('purchaseRequest.edit')->with('purchaseRequest', $purchaseRequest)->with('virtualItemID', $newArray);     
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
		$rules = array ('requestID' => 'required|numeric',
						'branchID' => 'required|numeric',
						'createdDate' => 'required',
						'expectedDeliveryDate' => 'required',
						
						);
		
		$messages = ['requestID.required' => 'Please input the request ID',
					 'requestID.numeric' => 'Please input the request ID in correct format',
					 'branchID.required' => 'Please input the branch id',
					 'branchID.numeric' => 'Please input the branch id in correct format',
					 'createdDate.required' => 'Please input the created date',
					 'expectedDeliveryDate.required' => 'Please input the expected delivery date',
					 
					];
  
        $validator = Validator::make($input, $rules, $messages);
        
        if ($validator->fails()) 
		{             
            return back()->withErrors($validator);        
        } 
	
		else 
		{
			$purchaseRequest = PurchaseRequest::find($request->requestID);
			$purchaseRequest->branchID = $request->branchID;
			$purchaseRequest->createdDate = $request->createdDate;
			$purchaseRequest->expectedDeliveryDate = $request->expectedDeliveryDate;
			$purchaseRequest->status = 'Pending for Mapping';
			$purchaseRequest->remarks = $request->remarks;
			$purchaseRequest->save();
			
			$virtualItemID = $request->input('virtualItemID', []);
            $itemList = [];
            for ($item = 0; $item < count($virtualItemID); $item++) {
            	$itemList[$item] = self::getItemIDFromVirtualID($virtualItemID[$item]);
            }
    		
    		//return $itemList;
            $requiredQuantity = $request->input('requiredQuantity', []);
            for ($item=0; $item < count($virtualItemID); $item++) {
            	PurchaseRequestItem::where('requestID', $request->requestID)->where('itemID', self::getItemIDFromVirtualID($virtualItemID[$item]))->delete();
            	$purchaseRequestItem = new PurchaseRequestItem;
            	if ($virtualItemID[$item] != '') {
            		$purchaseRequestItem->requestID = $request->requestID;
            		$purchaseRequestItem->itemID = self::getItemIDFromVirtualID($virtualItemID[$item]);
            		$purchaseRequestItem->quantity = $requiredQuantity[$item];
            		$purchaseRequestItem->balance = $requiredQuantity[$item];
            		$purchaseRequestItem->save();
            	}
            }
            
            return Redirect::to('purchaseRequest')->with('success','Successfully updated the purchase request Information!');
		}
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($requestID)
    {
    	if(PurchaseOrder::where('requestID', $requestID)->exists() || DispatchInstruction::where('requestID', $requestID)->exists())
		{
			return back()->withErrors( "Failed to delete which the purchase request is already mapped");
		}else {
			PurchaseRequestItem::where('requestID', $requestID)->delete();
			PurchaseRequest::find($requestID)->delete();
			return redirect('purchaseRequest')->with('success','Successfully deleted the purchase request!');
		}
	
    }
    
    /*************************************
     ********  Extend Function ***********
     *************************************/
    
    public function foreignKeyExists($request) 
	{
		return PurchaseRequest::where('branchID', $request->branchID)->exists();
	}
	
	public function getDispatchInstructions($requestID)
	{
		return PurchaseRequest::find($requestID)->dispatchInstructions;
	}
	
	public function getPurchaseOrders($requestID)
	{
		return PurchaseRequest::find($requestID)->purchaseOrders;
	}
	
	public function getPurchaseRequestItems($requestID)
	{
		return PurchaseRequest::find($requestID)->purchaseRequestItems;
	}
	
	public function getBranch($branchID)
	{
		return PurchaseRequest::find($branchID)->branch;
	}
	
	public function createNewPRAndStorewithdetails(Request $request){
		// Get the submitted input
		$input = $request->all();
        
        // Create validation rules, please refer to https://laravel.com/docs/7.x/validation#available-validationrules for more details
        $rules = array('requestID' => 'required|numeric',
					   'branchID' => 'required|numeric',
					   'expectedDeliveryDate' => 'required',
					   'status' => 'required',
					  );
					  
		// Create customized validation messages
		$messages = ['requestID.required' => 'Please input the request ID',
           			 'requestID.numeric' => 'Please input the request ID in correct format',
           			 'branchID.required' => 'Please input the branch id',
           			 'branchID.numeric' => 'Please input the branch id in correct format',
           			 'expectedDeliveryDate.required' => 'Please input the expected delivery date',
           			 'status.required' => 'Please input the status',
           			];
        
		$validator = Validator::make($input, $rules, $messages);
        // Perform insert order action when validation pass or return to the index page if validation fails
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
        	// Create a Order instance and configure the values before insert action
        	$purchaseRequest = new PurchaseRequest;
        	$purchaseRequest->requestID = $request->requestID;
        	$purchaseRequest->branchID = $request->branchID;
        	$purchaseRequest->expectedDeliveryDate = $request->expectedDeliveryDate;
        	$purchaseRequest->status = $request->status;
        	$purchaseRequest->createddate = Carbon::now()->format('Y-m-d');
        	if($request->remarks == null) {
        		$purchaseRequest->remarks = "";
        	}else {
        		$purchaseRequest->remarks = $request->remarks;
        	}
        	$purchaseRequest->save();
            
            // Insert order item detail based on the inserted order
            $virtualItemID = $request->input('virtualItemID', []);
            $requiredQuantity = $request->input('requiredQuantity', []);
            
            for ($item = 0; $item < count($virtualItemID); $item++) {
            	$purchaseRequestItem = new PurchaseRequestItem;
            	if ($virtualItemID[$item] != '') {
            		$purchaseRequestItem->requestID = $request->requestID;
            		$purchaseRequestItem->itemID = self::getItemIDFromVirtualID($virtualItemID[$item]);
            		$purchaseRequestItem->quantity = $requiredQuantity[$item];
            		$purchaseRequestItem->balance = $requiredQuantity[$item];
            		$purchaseRequestItem->save();
            	}
            }
        }
        // Redirect
        return redirect('purchaseRequest')->with('success', 'Successfully create a purchase request with details!');
    }
    
    public function getItemIDFromVirtualID($virtualItemID)
    {
    	return $itemID=Item::where('virtualItemID', $virtualItemID)->first()->itemID;
	}
	
	public function test($requestID)
	{
		return PurchaseRequest::where('requestID', $requestID)->first()->branchID;
	}
	
    public function showDetails($requestID)
    {
    	// Retrieve the purchaseRequest
        $purchaseRequestItem = PurchaseRequestItem::where('requestID', $requestID)->get();
        $column = PurchaseRequest::where('requestID', $requestID)->first();
        $name = Branch::where('branchID', $column->branchID)->first()->name;
        $columnName = ["requestID" => $column->requestID, "branchID" => $column->branchID,
        			   "createdDate" => $column->createdDate, "expectedDeliveryDate" => $column->expectedDeliveryDate,
        			   "status" => $column->status, "remarks" => $column->remarks, "branchName" => $name];
        
        // Load the view and pass the retrieved Purchase Order to the view for further processing
        return View::make('purchaseRequest.showDetails')->with('purchaseRequestItem', $purchaseRequestItem)->with('colmunName', $columnName);
    }
	
	public static function getPendingAndFailedRequest()
	{
		return $pendingRequest = PurchaseRequest::whereIn('status', ['Pending for Mapping', 'Failed'])->get();
	}
	
	public static function getPendingRequest()
	{
		foreach (PurchaseRequest::where('status', 'Pending for Mapping')->get() as $key => $value)
		{
			$checkBalance = true;
			foreach(PurchaseRequestItem::where("requestID", $value->requestID)->pluck("balance") as $balance)
			{
				if ($balance > 0) {
					$checkBalance = false;
				}
			}
			if ($checkBalance) {
				PurchaseRequest::where("requestID", $value->requestID)->update(["status" => "Pending for Delivery"]);
			}
		}
		return PurchaseRequest::where('status', 'Pending for Mapping')->get();
	}
	
	public static function getRequest($requestID)
	{
		return $pendingRequest = PurchaseRequest::where('requestID', $requestID)->first();
	}
	
	public static function getRecentItem()
	{
		$itemList = [];
		foreach(PurchaseRequestItem::select('itemID')->groupBy('itemID')->orderBy('itemID', 'desc')->pluck('itemID') as $value) {
			array_push($itemList, Item::where('itemID', $value)->first());
		}
		return $itemList;
	}
	
	public static function searchTable()
	{
		return $item=Item::all();
	}
}
