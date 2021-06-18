<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DeliveryInstruction;
use App\DeliveryNote;
use App\DispatchInstruction;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\View; 
use Illuminate\Support\MessageBag; 
use Carbon\Carbon; 
use Validator; 
use Input; 
use Session; 
use Redirect; 


class DeliveryNoteController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// Retrieve all the purchase order
        $deliveryNote = DeliveryNote::all();
		
		// Load the view and pass the retrieved Purchase Order to the view for further processing
		return View::make('deliveryNote.index')->with('deliveryNote', $deliveryNote);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($diNo)
    {
    	
    	 $dispatchInstruction = DispatchInstruction::where('diNo',$diNo)->first();
    	 
    	 $deliveryNoteNumber=self::getLastDeliveryNoteNumber();
    	 
			return View::make('deliveryNote.create')->with('dispatchInstruction',$dispatchInstruction)
													->with('deliveryNoteNumber',$deliveryNoteNumber);
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
						'diNo' => 'required|numeric',
						);
		
		$message = ['dnNo.required' => 'Please input the delivery note number',
					'dnNo.numeric' => 'Please input the delivery note number in correct format',
					'diNo.required' => 'Please input the dispatch instruction number',
					'diNo.numeric' => 'Please input the dispatch instruction in correct format',
					];
					
		$validator = Validator::make($input, $rules, $message);
		
		if($validator->fails()) 
		{
			return Redirect::to('deliveryNote/create')->withErrors($validator);
		} else if(DeliveryNote::where('dnNo',$request->dnNo)->exists()){
			return Redirect::to('deliveryNote/')->withErrors('Fail to Created');
		}else if(DeliveryNote::where('diNo',$request->diNo)->exists()){
			return Redirect::to('deliveryNote/')->withErrors('Fail to Created');
		}

		else 
		{
			$deliveryNote = new DeliveryNote;
			$deliveryNote->dnNo = $request->dnNo;
			$deliveryNote->diNo = $request->diNo;
			$deliveryNote->createdDate = \Carbon\Carbon::now()->format('Y-m-d');
			$deliveryNote->status ='Pending for Delivery';
			$deliveryNote->save();
			return  Redirect::to('deliveryNote/')->with('success','Apply Delivery Note Information Sucessfully!');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // Retrieve the deliveryNote       
        $dispatchInstruction = DispatchInstruction::where('status','Incomplete')->get();                  
        
		// Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('deliveryNote.show')->with('dispatchInstruction', $dispatchInstruction); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($dnNo)
    {
        // Retrieve the deliveryNote        
        $deliveryNote = DeliveryNote::find($dnNo); 
		
        // Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('deliveryNote.edit')->with('deliveryNote', $dnNo);     
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
						'diNo' => 'required|numeric',
						'createdDate' => 'required',
						'status' => 'required',);
		
		$message = ['dnNo.required' => 'Please input the delivery note number',
					'dnNo.numeric' => 'Please input the delivery note number in correct format',
					'diNo.required' => 'Please input the dispatch Instruction number',
					'diNo.numeric' => 'Please input the dispatch Instruction number in correct format',
					'createdDate.required' => 'Please input the created date',
					'status.required' => 'Please input the status',];
  
        $validator = Validator::make($input, $rules, $messages);                 
        if ($validator->fails()) 
		{             
            return Redirect::to('deliveryNote/create')->withErrors($validator);        
        } 
		else if (!foreignKeyExists($request))
		{
			return Redirect::to('deliveryNote/create')->withErrors('The composite key (agreementID, revision, itemID) is not found in DeliveryNoteCategory Table!');
		}
		else 
		{       
            $deliveryNote = DeliveryNote::find($request->dnNo);          
			$deliveryNote->diNo = $request->diNo;
			$deliveryNote->createdDate = $request->createdDate;
			$deliveryNote->status = $request->status;
            $deliveryNote->save();         
            return back()->with('success','Successfully updated delivery note Information!');     
        }         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($dnNo)
    {
		$deliveryNote = DeliveryNote::find($dnNo);          
		$deliveryNote->delete();
		return redirect('deliveryNote')->with('success','Successfully deleted delivery note!');
    }
    
    /*************************************
     ********  Extend Function ***********
     *************************************/
    
    public function foreignKeyExists($request) 
	{
		return DeliveryNote::where('diNo', $request->diNo)->exists();
	}
	
	public function getDispatchInstruction($diNo)
	{
		return DeliveryNote::where('diNo', $diNo)->first();
	}
	
	public function getDeliveryNoteItem($dnNo)
	{
		return DeliveryNote::find($dnNo)->deliveryNoteItems;
	}
	public static function getLastDeliveryNoteNumber()
	{
		
		if(DeliveryNote::select('dnNo')->orderBy('dnNo', 'desc')->exists()){
			return DeliveryNote::select('dnNo')->orderBy('dnNo', 'desc')->first()->dnNo;
		}else{
			return 0;
		}
	}
}
