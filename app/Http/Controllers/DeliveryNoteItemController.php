<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DeliveryNoteItem;
use App\DeliveryNote;
use App\Item;

class DeliveryNoteItemController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// Retrieve all the purchase order
        $deliveryNoteItem = DeliveryNoteItem::all();
		
		// Load the view and pass the retrieved Purchase Order to the view for further processing
		return View::make('deliveryNoteItem.index')->with('deliveryNoteItem', $deliveryNoteItem);
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
		$rules = array ('dnNo' => 'required|numeric',
						'itemID' => 'required|numeric',
						'quantity' => 'required|numeric',);
		
		$message = ['dnNo.required' => 'Please input the delivery note number',
					'dnNo.numeric' => 'Please input the delivery note number in correct format',
					'itemID.required' => 'Please input the item id',
					'itemID.numeric' => 'Please input the item id in correct format',
					'quantity.required' => 'Please input the quantity',
					'quantity.numeric' => 'Please input the quantity in correct format',];
					
		$validator = Validator::make($input, $rules, $message);
		
		if($validator->fails()) 
		{
			return Redirect::to('deliveryNoteItem/create')->withErrors($validator);
		} 
		else if (!foreignKeyExists($request))
		{
			return Redirect::to('deliveryNoteItem/create')->withErrors('The delivery note item is not found in other Table !');
		}
		else 
		{
			$deliveryNoteItem = new DeliveryNoteItem;
			$deliveryNoteItem->dnNo = $request->dnNo;
			$deliveryNoteItem->itemID = $request->itemID;
			$deliveryNoteItem->quantity = $request->quantity;
			$deliveryNoteItem->save();
			return back()->with('Apply Delivery Note Item Information','Apply Delivery Note Item Information Sucessfully!');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($dnNo, $itemID)
    {
        // Retrieve the deliveryNoteItem       
        $deliveryNoteItem = DeliveryNoteItem::where('dnNo', $dnNo)->where('itemID', $itemID);                  
        
		// Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('DeliveryNoteItem.show')->with('DeliveryNoteItem', $deliveryNoteItem); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($dnNo, $itemID)
    {
        // Retrieve the deliveryNoteItem        
        $deliveryNoteItem = DeliveryNoteItem::where('dnNo', $dnNo)->where('itemID', $itemID);
		
        // Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('deliveryNoteItem.edit')->with('deliveryNoteItem', $deliveryNoteItem);     
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
		$rules = array ('dnNo' => 'required|numeric',
						'itemID' => 'required|numeric',
						'quantity' => 'required|numeric',);
		
		$message = ['dnNo.required' => 'Please input the delivery note number',
					'dnNo.numeric' => 'Please input the delivery note number in correct format',
					'itemID.required' => 'Please input the item id',
					'itemID.numeric' => 'Please input the item id in correct format',
					'quantity.required' => 'Please input the quantity',
					'quantity.numeric' => 'Please input the quantity in correct format',];
  
        $validator = Validator::make($input, $rules, $messages);                 
        if ($validator->fails()) 
		{             
            return Redirect::to('deliveryNoteItem/create')->withErrors($validator);        
        } 
		else if (!foreignKeyExists($request))
		{
			return Redirect::to('deliveryNoteItem/create')->withErrors('The composite key (agreementID, revision, itemID) is not found in DeliveryNoteItemCategory Table!');
		}
		else 
		{       
            $deliveryNoteItem = DeliveryNoteItem::where('dnNo', $request->dnNo)->where('itemID', $request->itemID);
			$deliveryNoteItem->quantity = $request->quantity;
            $deliveryNoteItem->save();         
            return back()->with('success','Successfully updated delivery note Item Information!');     
        }         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($dnNo, $itemID)
    {
		$deliveryNoteItem = DeliveryNoteItem::where('dnNo', $dnNo)->where('itemID', $itemID);      
		$deliveryNoteItem->delete();
		return redirect('deliveryNoteItem')->with('success','Successfully deleted delivery note item!');
    }
    
    /*************************************
     ********  Extend Function ***********
     *************************************/
    
    public function foreignKeyExists($request) 
	{
		return DeliveryNote::where('dnNo', $request->dnNo)->exists() || Item::where('itemID', $request->itemID)->exists();
	}
	
	public function getDeliveryNote($dnNo)
	{
		return DeliveryNote::where('diNo', $dnNos)->first();
	}
	
	public function getItem($itemID)
	{
		return Item::where('itemID', $itemID)->first();
	}
}
