<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\AgreementLine;
use App\AgreementHeader;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\View; 
use Illuminate\Support\MessageBag; 
use Carbon\Carbon; 
use Validator; 
use Input; 
use Session; 
use Redirect; 

class AgreementLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// Retrieve all the branch agreementLine
        $agreementLine = AgreementLine::all();
		
		// Load the view and pass the retrieved agreementLine agreementLine to the view for further processing
		return View::make('agreementLine.index')->with('agreementLine', $agreementLine);
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
    	$unit = Item::pluck('unitOfMeasurement')->toArray();
    	$itemName = Item::orderBy('name', 'asc')->pluck('name','itemID')->toArray();
    	foreach($itemName as $key => $value) {
    		$value = $value." --- ".$unit[$count] ;
    		$newArray[$key] = $value;
    		$count++;
    	}
		$latestAgreementIDAndRevision=AgreementHeader::orderBy('agreementID', 'desc')->first();
    	
		return View::make('agreementLine.create')->with('itemName',$newArray)
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
						'itemID' => 'required|numeric',
						'price' => 'required|numeric',);
		
		$message = ['agreementID.required' => 'Please input the agreement id',
					'agreementID.numeric' => 'Please input the agreement id in correct format',
					'revision.required' => 'Please input the revision',
					'revision.numeric' => 'Please input the revision in correct format',
					'itemID.required' => 'Please input the item id',
					'itemID.numeric' => 'Please input the item id in correct format',
					'price.required' => 'Please input the price',
					'price.numeric' => 'Please input the price in correct format',];
					
		$validator = Validator::make($input, $rules, $message);
		
		if($validator->fails()) 
		{
			return Redirect::to('agreementLine/create')->withErrors($validator);
		} 
		else if (validateInput($request))
		{
			return Redirect::to('agreementLine/create')->withErrors('The Agreement ID does not exist in AgreementLine Table !');
		}
		else 
		{
			$agreementLine = new AgreementLine;
			$agreementLine->agreementID = $request->agreementLineID;
			$agreementLine->revision = $request->revision;
			$agreementLine->itemID = $request->itemID;
			$agreementLine->promisedQuantity = $request->promisedQuantity;
			$agreementLine->minimumOrderQuantity = $request->minimumOrderQuantity;
			$agreementLine->price = $request->price;
			$agreementLine->reference = $request->reference;
			$agreementLine->save();
			return back()->with('Apply agreementLine Information','Store the AgreementLine Information Sucessfully!');
		}
		
        $agreementID = $request->input('agreementID', []);
        $revision = $request->input('revision', []);
        $itemID = $request->input('itemID', []);
        $promisedQuantity = $request->input('promisedQuantity', []);
        $minimumOrderQuantity = $request->input('minimumOrderQuantity', []);
        $price = $request->input('price', []);
        $reference= $request->input('reference', []);
        
        for ($item=0; $item < count($descs); $item++) {
            $agreementLine = new AgreementLine;
            if ($agreementID[$item] != '') {
        		$agreementLine->agreementID = $agreementID[$item];
        		$agreementLine->revision = $revision[$item];
        		$agreementLine->itemID = $itemID[$item];
        		$agreementLine->promisedQuantity = $promisedQuantity[$item];
        		$agreementLine->minimumOrderQuantity = $minimumOrderQuantity[$item];
        		$agreementLine->price = $price[$item];
        		$agreementLine->reference = $reference[$item];
                
                $agreementLine->save($agreementLine);
        	}
        }
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($agreementID, $revision, $itemID)
    {
        // Retrieve the agreementLine       
        $agreementLine = AgreementLine::where('agreementID', $agreementID)->where('revision', $revision)->where('itemID', $itemID);                  
        
		// Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('AgreementLine.show')->with('AgreementLine', $agreementLine); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($agreementID, $revision, $itemID)
    {
        // Retrieve the agreementLine        
        $agreementLine = AgreementLine::where('agreementID', $agreementID)->where('revision', $revision)->where('itemID', $itemID); 
		
        // Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('agreementLine.edit')->with('agreementLine', $agreementLine);     
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
						'itemID' => 'required|numeric',
						'agreementLineID' => 'required|numeric',
						'price' => 'required|numeric',);
		
		$message = ['agreementID.required' => 'Please input the agreement id',
					'agreementID.numeric' => 'Please input the agreement id in correct format',
					'revision.required' => 'Please input the revision',
					'revision.numeric' => 'Please input the revision in correct format',
					'itemID.required' => 'Please input the item id',
					'itemID.numeric' => 'Please input the item id in correct format',
					'price.required' => 'Please input the price',
					'price.numeric' => 'Please input the price in correct format',];
  
        $validator = Validator::make($input, $rules, $messages);                 
        if ($validator->fails())
		{             
            return Redirect::to('agreementLine/create')->withErrors($validator);        
        } 
		else if (validateInput($request->categoryID))
		{
			return Redirect::to('agreementLine/create')->withErrors('The agreement id does not exist in AgreementLine Table!');
		}
		else 
		{       
            $agreementLine = AgreementLine::where('agreementID', $request->agreementID)->where('revision', $request->revision)->where('itemID', $request->itemID);          
			$agreementLine->promisedQuantity = $request->promisedQuantity;
			$agreementLine->balance = $request->balance;
			$agreementLine->minimumOrderQuantity = $request->minimumOrderQuantity;
			$agreementLine->price = $request->price;
			$agreementLine->reference = $request->reference;
            $agreementLine->save();
            return back()->with('success','Updated Agreement Line Information Successfully');
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
		$agreementLine = AgreementLine::where('agreementID', $agreementID)->where('revision', $revision)->where('itemID', $itemID);          
		
		$agreementLine->delete();
		return redirect('agreementLine')->with('success','Deleted Agreement Line Successfully');
    }
    
    /*************************************
     ********  Extend Function ***********
     *************************************/
    
	public function validateInput($request) 
	{
		return	!AgreementHeader::where('agreementID', $request->agreementID)->where('revision', $request->revision)->exists() and
				!Item::find($request->itemID)->exists() and
				AgreementLine::where('agreementID', $request->agreementID)->where('revision', $request->revision)->where('itemID', $request->itemID)->exists();
	}
	
	public function agreementPriceBreak($agreementID, $revision, $itemID)
	{
		return AgreementLine::find(array($agreementID, $revision, $itemID))->agreeementPriceBreak;
	}
}