<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PurchaseRequestItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;
use Carbon\Carbon;
use Validator;
use Input;
use Session;
use Redirect;
use App\PurchaseRequest;
use App\Item;

class PurchaseRequestItemController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  //  public function index()
  //  {
		// // Retrieve all the purchase order
  //      $purchaseRequestItem = PurchaseRequestItem::all();
		
		// // Load the view and pass the retrieved Purchase Order to the view for further processing
		// return View::make('purchaseRequestItem.index')->with('purchaseRequestItem', $purchaseRequestItem);
  //  }
	
    public function index($requestID,$branchID)
    {
		// Retrieve all the purchase order
        $purchaseRequestItem = PurchaseRequestItem::where('requestID',$requestID)
        												->where('branchID',$branchID)
        												->get();
		
		// Load the view and pass the retrieved Purchase Order to the view for further processing
		return View::make('purchaseRequestItem.index')->with('purchaseRequestItem', $purchaseRequestItem);
    }
    
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		//
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
						'itemID' => 'required|numeric',
						'quantity' => 'required|numeric',
						'balance' => 'required|numeric',);
		
		$message = ['itemID.required' => 'Please input the item id',
					'itemID.numeric' => 'Please input the item id in correct format',
					'quantity.required' => 'Please input the quantity',
					'quantity.numeric' => 'Please input the quantity',
					'balance.required' => 'Please input the balance in correct format',
					'balance.numeric' => 'Please input the balance',];
					
		$validator = Validator::make($input, $rules, $message);
		
		if($validator->fails()) 
		{
			return Redirect::to('purchaseRequestItem/create')->withErrors($validator);
		} 
		else if (!$this->foreignKeyExists($request))
		{
			return Redirect::to('purchaseRequestItem/create')->withErrors('The Purchase Request Item does not exist in other tables!');
		}
		else 
		{
			$purchaseRequestItem = new PurchaseRequestItem;
			$purchaseRequestItem->itemID = $request->itemID;
			$purchaseRequestItem->quantity = $request->quantity;
			$purchaseRequestItem->balance = $request->balance;
			$purchaseRequestItem->remarks = $request->remarks;
			$purchaseRequestItem->save();
			return back()->with('Apply Purchase Request Item Information','Apply Purchase Request Item Information Sucessfully!');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($requestID, $itemID)
    {
        // Retrieve the purchaseRequestItem       
        $purchaseRequestItem = PurchaseRequestItem::where('requestID', $requestID)->where('itemID', $itemID);                  
        
		// Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('PurchaseRequestItem.show')->with('PurchaseRequestItem', $purchaseRequestItem); 
    }
	
	public function showByRequestID($requestID)
	{
        // Retrieve the purchaseRequestItem       
        $purchaseRequestItem = PurchaseRequestItem::where('requestID', $requestID);                  
        
		// Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('PurchaseRequestItem.showByRequestID')->with('PurchaseRequestItem', $purchaseRequestItem); 		
	}

	public function showByBranchID($branchID)
	{
        // Retrieve the purchaseRequestItem       
        $purchaseRequestItem = PurchaseRequestItem::where('branchID', $branchID);                  
        
		// Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('PurchaseRequestItem.showByBranchID')->with('PurchaseRequestItem', $purchaseRequestItem); 		
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($requestID, $itemID)
    {
        // Retrieve the purchaseRequestItem        
         
        $purchaseRequestItem = PurchaseRequestItem::where('requestID', $requestID)->where('itemID', $itemID)->first();
 
        // Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('purchaseRequestItem.edit')->with('purchaseRequestItem', $purchaseRequestItem);     
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
		$rules = array (
						'requestID' => 'required|numeric',
						'itemID' => 'required|numeric',
						'quantity' => 'required|numeric',
						'balance' => 'required|numeric',);
		
		$message = [
					'requestID.required' => 'Please input the quantity',
					'itemID.required' => 'Please input the quantity',
					'requestID.numeric' => 'Please input the quantity',
					'itemID.numeric' => 'Please input the quantity',
					'quantity.required' => 'Please input the quantity',
					'quantity.numeric' => 'Please input the quantity',
					'balance.required' => 'Please input the balance in correct format',
					'balance.numeric' => 'Please input the balance',];
  
        $validator = Validator::make($input, $rules, $messages);                 
        if ($validator->fails()) 
		{             
            return Redirect::to('purchaseRequestItem/create')->withErrors($validator);        
        } 
		else 
		{       
            $purchaseRequestItem = PurchaseRequestItem::where('request',$request->requestID)
            											->where('itemID',$request->itemID)
            											->update(['quantity'=>$request->quantity,'balance'=>$request->balance]);          
            											
            return back()->with('success','Successfully updated purchase request item Information!');     
        }         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($requestID,$itemID)
    {
		$purchaseRequestItem = PurchaseRequestItem::where('requestID',$requestID)->where('itemID',$itemID)->delete();          
		
		return back()->with('success','Successfully');
    }
    
    /*************************************
     ********  Extend Function ***********
     *************************************/

	public function foreignKeyExists($request)
	{
		return PurchaseRequest::where('requestID', $request->requestID)->exists() && Item::where('itemID', $request->itemID)->exists();
	}

}
