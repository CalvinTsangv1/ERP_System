<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DispatchInstructiontemController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// Retrieve all the purchase order
        $dispatchInstructionItem = DispatchInstructionItem::all();
		
		// Load the view and pass the retrieved Purchase Order to the view for further processing
		return View::make('dispatchInstructionItem.index')->with('dispatchInstructionItem', $dispatchInstructionItem);
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
		$rules = array ('diNo' => 'required|numeric',
						'itemID' => 'required|numeric',
						'quantity' => 'required|numeric',
						'balance' => 'required|numeric',);
		
		$message = ['diNo.required' => 'Please input the delivery instruction number',
					'diNo.numeric' => 'Please input the delivery instruction number in correct format',
					'itemID.required' => 'Please input the item id',
					'itemID.numeric' => 'Please input the item id in correct format',
					'quantity.required' => 'Please input the quantity',
					'quantity.numeric' => 'Please input the quantity in correct format',
					'balance.required' => 'Please input the balance',
					'balance.numeric' => 'Please input the balance in correct format',];
					
		$validator = Validator::make($input, $rules, $message);
		
		if($validator->fails()) 
		{
			return Redirect::to('dispatchInstructionItem/create')->withErrors($validator);
		} 
		else if (!foreignKeyExists($request))
		{
			return Redirect::to('dispatchInstructionItem/create')->withErrors('The Purchase Order is not found in Pu Table !');
		}
		else 
		{
			$dispatchInstructionItem = new DispatchInstructionItem;
			$dispatchInstructionItem->diNo = $request->diNo;
			$dispatchInstructionItem->itemID = $request->itemID;
			$dispatchInstructionItem->quantity = $request->quantity;
			$dispatchInstructionItem->balance = $request->balance;
			$dispatchInstructionItem->save();
			return back()->with('Apply dispatchInstructionItem Information','Apply Dispatch Instruction Item Information Sucessfully!');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($diNo, $itemID)
    {
        // Retrieve the dispatchInstructionItem       
        $dispatchInstructionItem = DispatchInstructionItem::where('diNo', $diNo)->where('itemID', $itemID);                  
        
		// Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('DispatchInstructionItem.show')->with('DispatchInstructionItem', $dispatchInstructionItem); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($diNo, $itemID)
    {
        // Retrieve the dispatchInstructionItem        
        $dispatchInstructionItem = DispatchInstructionItem::where('diNo', $diNo)->where('itemID', $itemID); 
		
        // Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('dispatchInstructionItem.edit')->with('dispatchInstructionItem', $dispatchInstructionItem);     
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
		$rules = array ('diNo' => 'required|numeric',
						'itemID' => 'required|numeric',
						'quantity' => 'required|numeric',
						'balance' => 'required|numeric',);
		
		$message = ['diNo.required' => 'Please input the delivery instruction number',
					'diNo.numeric' => 'Please input the delivery instruction number in correct format',
					'itemID.required' => 'Please input the item id',
					'itemID.numeric' => 'Please input the item id in correct format',
					'quantity.required' => 'Please input the quantity',
					'quantity.numeric' => 'Please input the quantity in correct format',
					'balance.required' => 'Please input the balance',
					'balance.numeric' => 'Please input the balance in correct format',];
  
        $validator = Validator::make($input, $rules, $messages);                 
        if ($validator->fails()) 
		{             
            return Redirect::to('dispatchInstructionItem/create')->withErrors($validator);        
        } 
		else if (!foreignKeyExists($request))
		{
			return Redirect::to('dispatchInstructionItem/create')->withErrors('The composite key (agreementID, revision, itemID) is not found in DispatchInstructionItemCategory Table!');
		}
		else 
		{       
            $dispatchInstructionItem = DispatchInstructionItem::where('diNo', $request->diNo)->where('itemID', $request->itemID);          
			$dispatchInstructionItem->quantity = $request->quantity;
			$dispatchInstructionItem->balance = $request->balance;
            $dispatchInstructionItem->save();         
            return back()->with('success','Successfully updated dispatch instruction item Information!');     
        }         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($diNo, $itemID)
    {
		$dispatchInstructionItem = DispatchInstructionItem::where('diNo', $request->diNo)->where('itemID', $request->itemID);                
		$dispatchInstructionItem->delete();
		return redirect('dispatchInstructionItem')->with('success','Successfully deleted dispatch Instruction item!');
    }
    
    /*************************************
     ********  Extend Function ***********
     *************************************/
    
    public function foreignKeyExists($request) 
	{
		return DispatchInstruction::where('diNo', $request->diNo)->exists() || Item::where('itemID', $request->itemID)->exists();
	}
	
	public function getDispatchInstruction($diNo)
	{
		return DispatchInstruction::where('diNo', $diNo)->first();
	}
	
	public function getItem($diNo)
	{
		return Item::where('itemID', $itemID)->first();
	}
	
}
