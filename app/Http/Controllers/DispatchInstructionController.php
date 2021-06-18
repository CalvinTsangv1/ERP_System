<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PurchaseRequest;
use App\DispatchInstruction;
use App\DispatchInstructionItem;
use App\PurchaseOrder;
use App\PurchaseOrderItem;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\View; 
use Illuminate\Support\MessageBag; 
use Carbon\Carbon; 
use Validator; 
use Input; 
use Session; 
use Redirect; 

class DispatchInstructionController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// Retrieve all the purchase order
        $dispatchInstruction = DispatchInstruction::all();
		
		// Load the view and pass the retrieved Purchase Order to the view for further processing
		return View::make('dispatchInstruction.index')->with('dispatchInstruction', $dispatchInstruction);
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
						'createdDate' => 'required',
						'status' => 'required',);
		
		$message = ['requestID.required' => 'Please input the request id',
					'requestID.numeric' => 'Please input the request id in correct format',
					'createdDate.required' => 'Please input the created date',
					'status.required' => 'Please input the status in correct format',];
					
		$validator = Validator::make($input, $rules, $message);
		
		if($validator->fails()) 
		{
			return Redirect::to('dispatchInstruction/create')->withErrors($validator);
		} 
		else if (!foreignKeyExists($request))
		{
			return Redirect::to('dispatchInstruction/create')->withErrors('The Purchase Order is not found in Pu Table !');
		}
		else 
		{
			$dispatchInstruction = new DispatchInstruction;
			$dispatchInstruction->requestID = $request->branchID;
			$dispatchInstruction->createdDate = $request->createdDate;
			$dispatchInstruction->status = $request->status;
			$dispatchInstruction->save();
			return back()->with('Apply dispatchInstruction Information','Apply Dispatch Instruction Information Sucessfully!');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($diNo)
    {
        // Retrieve the dispatchInstruction       
        $dispatchInstruction = DispatchInstructionItem::where('diNo',$diNo)->first();                  
        
		// Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('dispatchInstruction.showDetails')->with('DispatchInstruction', $dispatchInstruction); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($diNo)
    {
        // Retrieve the dispatchInstruction        
        $dispatchInstruction = DispatchInstruction::find($diNo); 
		
        // Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('dispatchInstruction.edit')->with('dispatchInstruction', $dispatchInstruction);     
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
						'requestID' => 'required|numeric',
						'createdDate' => 'required',
						'status' => 'required',);
		
		$message = ['diNo.required' => 'Please input the dispatch Instruction Number',
					'diNo.numeric' => 'Please input the dispatch Instruction Number in correct format',
					'requestID.required' => 'Please input the request id',
					'requestID.numeric' => 'Please input the request id in correct format',
					'createdDate.required' => 'Please input the created date',
					'status.required' => 'Please input the status in correct format',];
  
        $validator = Validator::make($input, $rules, $messages);                 
        if ($validator->fails()) 
		{             
            return Redirect::to('dispatchInstruction/create')->withErrors($validator);        
        } 
		else if (!foreignKeyExists($request))
		{
			return Redirect::to('dispatchInstruction/create')->withErrors('The composite key (agreementID, revision, itemID) is not found in DispatchInstructionCategory Table!');
		}
		else 
		{       
            $dispatchInstruction = DispatchInstruction::find($request->diNo);          
			$dispatchInstruction->requestID = $request->requestID;
			$dispatchInstruction->createdDate = $request->createdDate;
			$dispatchInstruction->status = $request->status;
            $dispatchInstruction->save();         
            return back()->with('success','Successfully updated purchase request Information!');     
        }         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($diNo)
    {
		$dispatchInstruction = DispatchInstruction::find($diNo);          
		$dispatchInstruction->delete();
		return redirect('dispatchInstruction')->with('success','Successfully deleted dispatch Instruction!');
    }
    
    /*************************************
     ********  Extend Function ***********
     *************************************/
    
    public function foreignKeyExists($request) 
	{
		return PurchaseRequest::where('requestID', $request->requestID)->exists();
	}
	
	public function getDeliveryNote($diNo)
	{
		return DispatchInstruction::find($diNo)->deliveryNotes;
	}
	
	public function getDispatchInstructionItems($diNo)
	{
		return DispatchInstructionItem::where('diNo', $diNo)->get();
	}
	
	public  function getPurchaseRequest($requestID)
	{
		return PurchaseRequest::where('requestID', $requestID)->first();
	}
	
		public static function getRequestID($diNo)
	{
		return DispatchInstruction::where('diNo', $diNo)->first();
	}


	public function test()
	{
		return DispatchInstruction::all();
	}
	
	public function test2()
	{
		return DispatchInstructionItem::all();
	}

	public function test3()
	{
		return PurchaseOrder::all();
	}
	
	public function test4()
	{
		return PurchaseOrderItem::all();
	}

	public function showDetails($diNo){
		
		$dispatchInstruction=DispatchInstruction::where('diNo',$diNo)->first();
			
		$dispatchInstructionItem = DispatchInstructionItem::where('diNo',$diNo)->get();
		
		return View::make('dispatchInstruction.showDetails')->with('dispatchInstructionItem',$dispatchInstructionItem)
															->with('dispatchInstruction',$dispatchInstruction);
	}
}
