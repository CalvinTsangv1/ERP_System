<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;
use Carbon\Carbon;
use Validator;
use Input;
use Session;
use Redirect;
use Illuminate\Http\Request;
use App\PurchaseRequest;
use App\PurchaseRequestItem;
use App\PurchaseOrder;
use App\PurchaseOrderItem;
use App\AgreementHeader;
use App\AgreementLine;
use App\AgreementPriceBreak;
use App\DispatchInstruction;
use App\BranchItem;
use App\Branch;

class ManualPurchaseRequestMappingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	
    public function index($itemID)
    {
        $agreementHeaders = [];
        $branchItem = [];
		// Retrieve all the supplier
		foreach(AgreementLine::where('itemID',$itemID)->get()->pluck('agreementID') as $value)
		{
		    if(AgreementHeader::where("agreementID", $value)->where("status","Active")->exists()) {
		        $agreement = AgreementHeader::where("agreementID", $value)->where("status","Active")->first();
		        array_push($agreementHeaders,  $agreement);
		        array_push($agreementLines, AgreementLine::where('agreementID', $agreement->agreementID)->where('revision', $agreement->revision)->where('itemID', $value));
		    }
		}
		
		if(BranchItem::where("itemID", $itemID)->exists()) {
		    array_push($branchItem, Branch::where("itemID", $itemID)->get());
		}
	
		// Kim Lam 
		return View::make('manualPurchaseRequestMapping.index')->with('agreementHeaders', $agreementHeaders)->with('agreementLines', $agreementLines)->with('branchItem', $branchItem);
		
		// Load the view and pass the retrieved supplier to the view for further processing
		//return View::make('supplier.index')->with('supplier', $supplier);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
      return View::make('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAgreement(Request $request)
    {
        $input = $request->all();
		$rules = array ('agreementID' => 'required|numeric',
						'revision' => 'required|numeric',
						'itemID' => 'required|numeric',
						'balance' => 'required|numeric',);
		
		$message = ['agreementID.required' => 'Please input the agreement id',
					'agreementID.numeric' => 'Please input the agreement id in correct format',
					'revision.required' => 'Please input the revision',
					'revision.numeric' => 'Please input the revision in correct format',
					'itemID.required' => 'Please input the item id',
					'itemID.numeric' => 'Please input the item id in correct format',
					'balance.required' => 'Please input the price',
					'balance.numeric' => 'Please input the price in correct format',];
					
		$validator = Validator::make($input, $rules, $messages);
		
		if($validator->fails()) {
			return Redirect::to('supplier/create')->withErrors($validator);
		}else {
			AgreementLine::where("agreementID", $request->agreementID)->where("revision", $request->revision)->where("itemID", $request->itemID)->update(["balance"=>$request->balance]);
			return redirect('supplier')->with('success','Apply Supplier Information Sucessfully!');
		}
    }
    
    public function updateBranchItem(Request $request)
    {
        $input = $request->all();
		$rules = array ('branchID' => 'required|numeric',
						'itemID' => 'required|numeric',
						'quantity' => 'required|numeric',);
		
		$message = ['branchID.required' => 'Please input the branch id',
					'branchID.nuermic' => 'Please input the branch id in correct format',
					'itemID.required' => 'Please input the telephone number',
					'itemID.numeric' => 'Please input the telephone number in correct format',
					'quantity.required' => 'Please input the quantity',
					'quantity.numeric' => 'Please input the quantity in correct format',];
  
        $validator = Validator::make($input, $rules, $messages);                 
        if ($validator->fails()) {             
            return Redirect::to('branchItem/create')->withErrors($validator);
        } else if (!compositeKeyExists($request)) {
            return back()->withErrors('Failed to update the Branch Item as branchID and itemID is not found !'); 
        } else {       
            $branchItem = BranchItem::where('branchID', $request->branchID)->where('itemID', $request->itemID)->update(["quantity"=>$request->quantity]);
            return back()->with('success','Successfully updated branchItem Information!');     
        }   
    }

// Redirect to Purchae Order or Dispatch Instruction Page, if success update
	
}
