<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;
use Carbon\Carbon;
use Validator;
use Input;
use Session;
use Redirect;
use App\AgreementPriceBreak;
use App\Item;

class AgreementPriceBreakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// Load the view and pass the retrieved agreementPriceBreak agreementPriceBreak to the view for further processing
		return self::show();
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
		$rules = array ();
		
		$message = [];
					
		$validator = Validator::make($input, $rules, $message);
		
		if($validator->fails()) 
		{
			return back()->withErrors($validator);
		} 
		else 
		{
			$agreementID = $request->input('agreementID', []);
            $revision = $request->input('revision', []);
            $itemID = $request->input('itemID', []);
            $priceBreak = $request->input('priceBreak', []);
            $discount = $request->input('discount', []);                
            
            for ($item=0; $item < count($itemID); $item++) {
            	$checkVaild = DB::table('agreement_price_break')->where('agreementID', $agreementID[$item])
                												->where('revision', $revision[$item])
            													->where('itemID', $itemID[$item])
            													->get();
            	foreach($checkVaild as $key => $value){
            		
            		 if($priceBreak[$item] == $value->priceBreak){
	                	return back()->withErrors('The price break is already set');
	                }

            	}	
                
                $agreementPriceBreak = new AgreementPriceBreak;
                if ($itemID[$item] != '') {
                	$agreementPriceBreak->agreementID = $agreementID[$item];
                    $agreementPriceBreak->revision = $revision[$item];
                    $agreementPriceBreak->itemID = $itemID[$item];
                    $agreementPriceBreak->priceBreak =$priceBreak[$item];
                    $agreementPriceBreak->discount =$discount[$item];
                    $agreementPriceBreak->save();
                }
            }
            return back()->with('success','Agreement Price Break Information Saved Sucessfully');
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
        // Retrieve the agreementPriceBreak
        $agreementPriceBreak = AgreementPriceBreak::where('agreementID', $agreementID)->where('revision', $revision)->where('itemID', $itemID);                  
        
		// Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('AgreementPriceBreak.show')->with('AgreementPriceBreak', $agreementPriceBreak);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($agreementID, $revision, $itemID)
    {
        // Retrieve the agreementPriceBreak        
        $agreementPriceBreak = AgreementPriceBreak::where('agreementID', $agreementID)->where('revision', $revision)->where('itemID', $itemID)->first(); 
		$agreementPriceBreakList = DB::table('agreement_price_break')->where('agreementID', $agreementID)->where('revision', $revision)->where('itemID', $itemID)->get();
		
        // Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('agreementPriceBreak.edit')->with('agreementPriceBreak', $agreementPriceBreak)->with('agreementPriceBreakList', $agreementPriceBreakList);   
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
						'priceBreak' => 'required|numeric',
						'discount' => 'required|numeric',);
		
		$message = ['agreementID.required' => 'Please input the agreement id',
					'agreementID.numeric' => 'Please input the agreement id in correct format',
					'revision.required' => 'Please input the revision',
					'revision.numeric' => 'Please input the revision in correct format',
					'itemID.required' => 'Please input the item id',
					'itemID.numeric' => 'Please input the item id in correct format',
					'priceBreak.required' => 'Please input the price break',
					'priceBreak.numeric' => 'Please input the price break in correct format',
					'discount.required' => 'Please input the discount',
					'discount.numeric' => 'Please input the discount in correct format',];
  
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) 
		{             
            return Redirect::to('agreementPriceBreak/create')->withErrors($validator);        
        } 
		else if (foreignKeyNoExists($request))
		{
			return Redirect::to('agreementPriceBreak/create')->withErrors('The composite key (agreementID, revision, itemID) does not exist in AgreementPriceBreak Table!');
		}
		else 
		{       
            $agreementPriceBreak = AgreementPriceBreak::where('agreementID', $request->agreementID)->where('revision', $request->revision)->where('itemID', $request->itemID)->where('priceBreak', $request->priceBreak);
			$agreementPriceBreak->discount = $request->discount;
            $agreementPriceBreak->save();         
            return back()->with('success','Updated Agreement Price Break Information Successfully');
        }          
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($agreementID, $revision, $itemID,$priceBreak)
    {
		$agreementPriceBreak = AgreementPriceBreak::where('agreementID', $agreementID)->where('revision', $revision)->where('itemID', $itemID)->where('priceBreak', $priceBreak)->delete();
		return back()->with('success','Successfully deleted agreement line!');
    }
    
    /*************************************
     ********  Extend Function ***********
     *************************************/
    
    public function foreignKeyNoExists($request)
	{
		return !AgreementHeader::where('agreementID', $request->agreementID)->where('revision', $request->revision)->where('itemID', $request->itemID)->exists();
	}
	
	public function getAgreementLine($agreementID, $revision, $itemID)
	{
		/** REMINDER: get single value ( $value->price )**/
		return AgreementLine::where('agreementID', $agreementID)->where('revision', $revision)->where('itemID', $itemID)->first();
	}
	
	public function getAgreementHeader($agreementID, $revision)
	{
		/** REMINDER: get single value ( $value->price )**/
		return AgreementLine::where('agreementID', $agreementID)->where('revision', $revision)->first();
	}
	
	public static function getItem($itemID)
	{
		/** REMINDER: get single value ( $value->name )**/
		return Item::where('itemID', $itemID)->first();
	}
	
	public static function getPriceBreakByItemID($agreementID,$itemID)
	{
		$agreementPriceBreak = AgreementPriceBreak::where('agreementID', $agreementID)->where('itemID', $itemID)->get();
		
		$length= count($agreementPriceBreak);
		$string='';
		for($i=0;$i<$length;$i++){
			if(($length-1) == $i){
		 		$string.=(string)$agreementPriceBreak[$i]['priceBreak'].":".(string)round((float)$agreementPriceBreak[$i]['discount']*100)."%\n";
		 	}else{
		 		$string.=(string)$agreementPriceBreak[$i]['priceBreak'].':'.(string)round((float)$agreementPriceBreak[$i]['discount']*100)."% | \n";
		}}
		return $string;
	}
}
