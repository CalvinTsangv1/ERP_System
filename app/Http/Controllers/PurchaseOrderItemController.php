<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PurchaseOrderItem;
use App\Supplier;
use App\AgreementHeader;
use App\PurchaseRequest;

class PurchaseOrderItemController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// Retrieve all the branch purchaseOrderItem
        $purchaseOrderItem = PurchaseOrderItem::all();
		
		// Load the view and pass the retrieved purchaseOrderItem purchaseOrderItem to the view for further processing
		return View::make('purchaseOrderItem.index')->with('purchaseOrderItem', $purchaseOrderItem);
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
		$rules = array ('poNo' => 'required|numeric',
						'itemID' => 'required|numeric',
						'quantity' => 'required|numeric',
						'amount' => 'required|numeric',
						'balance' => 'required|numeric',);
		
		$message = ['poNo.required' => 'Please input the purchase order number',
					'poNo.numeric' => 'Please input the purchase order number in correct format',
					'itemID.required' => 'Please input the item id',
					'itemID.numeric' => 'Please input the item id in correct format',
					'quantity.required' => 'Please input the quantity',
					'quantity.numeric' => 'Please input the quantity in correct format',
					'amount.required' => 'Please input the amount',
					'amount.numeric' => 'Please input the amount in correct format',
					'balance.required' => 'Please input the balance',
					'balance.numeric' => 'Please input the balance in correct format',];
					
		$validator = Validator::make($input, $rules, $message);
		
		if($validator->fails()) 
		{
			return Redirect::to('purchaseOrderItem/create')->withErrors($validator);
		} 
		else if (foreignKeyNoExists($request))
		{
			return Redirect::to('purchaseOrderItem/create')->withErrors('The Purchase Order item is not found in AgreementLine Table !');
		}
		else 
		{
			$purchaseOrderItem = new PurchaseOrderItem;
			$purchaseOrderItem->poNo = $request->poNo;
			$purchaseOrderItem->itemID = $request->itemID;
			$purchaseOrderItem->quantity = $request->quantity;
			$purchaseOrderItem->amount = $request->amount;
			$purchaseOrderItem->balance = $request->balance;
			$purchaseOrderItem->save();
			return back()->with('Apply purchase order Item Information','Apply purchase order item Information Sucessfully!');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($poNo, $itemID)
    {
        // Retrieve the purchaseOrderItem       
        $purchaseOrderItem = PurchaseOrderItem::where('poNo', $poNo)->where('itemID', $itemID);                  
        
		// Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('PurchaseOrderItem.show')->with('PurchaseOrderItem', $purchaseOrderItem); 
    }
	
	public function showPurchaseOrder($poNo)
	{
		// Retrieve the purchaseOrderItem       
        $purchaseOrderItem = PurchaseOrder::find($poNo);                  
        
		// Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('PurchaseOrderItem.showPurchaseOrder')->with('PurchaseOrderItem', $purchaseOrderItem); 
	}
	
	public function showItem($itemID)
	{
		// Retrieve the purchaseOrderItem       
        $purchaseOrderItem = Item::find($itemID);                  
        
		// Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('PurchaseOrderItem.showPurchaseOrder')->with('PurchaseOrderItem', $purchaseOrderItem); 
	}
	
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($agreementID, $revision, $itemID, $priceBreak)
    {
        // Retrieve the purchaseOrderItem        
        $purchaseOrderItem = PurchaseOrderItem::where('agreementID', $agreementID)->where('revision', $revision)->where('itemID', $itemID)->where('priceBreak', $priceBreak); 
		
        // Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('purchaseOrderItem.edit')->with('purchaseOrderItem', $purchaseOrderItem);     
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
		$rules = array ('poNo' => 'required|numeric',
						'itemID' => 'required|numeric',
						'quantity' => 'required|numeric',
						'amount' => 'required|numeric',
						'balance' => 'required|numeric',);
		
		$message = ['poNo.required' => 'Please input the purchase order number',
					'poNo.numeric' => 'Please input the purchase order number in correct format',
					'itemID.required' => 'Please input the item id',
					'itemID.numeric' => 'Please input the item id in correct format',
					'quantity.required' => 'Please input the quantity',
					'quantity.numeric' => 'Please input the quantity in correct format',
					'amount.required' => 'Please input the amount',
					'amount.numeric' => 'Please input the amount in correct format',
					'balance.required' => 'Please input the balance',
					'balance.numeric' => 'Please input the balance in correct format',];
  
        $validator = Validator::make($input, $rules, $messages);                 
        if ($validator->fails()) 
		{             
            return Redirect::to('purchaseOrderItem/create')->withErrors($validator);        
        } 
		else if (foreignKeyNoExists($request))
		{
			return Redirect::to('purchaseOrderItem/create')->withErrors('The composite key (agreementID, revision, itemID) is not found in PurchaseOrderItemCategory Table!');
		}
		else 
		{       
            $purchaseOrderItem = PurchaseOrderItem::where('agreementID', $request->agreementID)->where('revision', $request->revision)->where('itemID', $request->itemID)->where('priceBreak', $request->priceBreak);          
			$purchaseOrderItem->discount = $request->discount;
            $purchaseOrderItem->save();         
            return back()->with('success','Successfully updated agreement price break Information!');     
        }         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($agreementID, $revision, $itemID)
    {
		$purchaseOrderItem = PurchaseOrderItem::where('agreementID', $agreementID)->where('revision', $revision)->where('itemID', $itemID)->where('priceBreak', $price);          
		$purchaseOrderItem->delete();
		return redirect('purchaseOrderItem')->with('success','Successfully deleted agreement line!');
    }
    
    /*************************************
     ********  Extend Function ***********
     *************************************/
    
    public function foreignKeyNoExists($request) 
	{
		return !PurchaseOrder::find($request->poNo)->exists() || !Item::find($request->itemID)->exists();
	}
	
	
	public function getPurchaseOrder($poNo)
	{
		/** REMINDER: get single value ( $value->price )**/
		
		return PurchaseOrder::find($poNo)->first();
	}
	
	public function getItem($itemID)
	{
		/** REMINDER: get single value ( $value->name )**/
		
		return Item::find($itemID)->first();
	}
	
	
	public function createSPO(){
		
		
		return View::make('purchaseOrder.createSPO');
	}
}
