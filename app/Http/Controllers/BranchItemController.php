<?php

namespace App\Http\Controllers;

use App\BranchItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;
use Carbon\Carbon;
use Validator;
use Input;
use Session;
use Redirect;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Branch;
use Auth;

class BranchItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        // $branchItem = BranchItem::paginate(30);
       
		// Load the view and pass the retrieved supplier to the view for further processing
		return self::show( Auth::user()->branchID );
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
		$rules = array ('branchID' => 'required|numeric',
						'itemID' => 'required|numeric',
						'quantity' => 'required|numeric',);
		
		$message = ['branchID.required' => 'Please input the branch id',
					'branchID.numeric' => 'Please input the branch id in correct format',
					'itemID.numeric' => 'Please input the item id in correct format',
					'itemID.required' => 'Please input the item id',
					'quantity.required' => 'Please input the quantity',
					'quantity.numeric' => 'Please input the quantity in correct format',];
					
		$validator = Validator::make($input, $rules, $message);
		
		if($validator->fails()) {
			return Redirect::to('branchItem/create')->withErrors($validator);
		} else if (compositeKeyExists($request)) {
			return back()->withErrors('Failed to store the Branch Item as branchID and itemID is duplicated, you enter the unique composite key (branchID, itemID) !'); 
		} else {
			$branchItem = new BranchItem;
			$branchItem->branchID = $request->branchID;
			$branchItem->itemID = $request->itemID;
			$branchItem->quantity = $request->quantity;
			$branchItem->lowStockLevel = $request->lowStockLevel;
			$branchItem->save();
			return back()->with('Apply branch item Information','Apply branch item Information Sucessfully!');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($branchID) /** Pass two parameter (brancID, itemID)**/
    {
        // Retrieve the branchItem
        $branchItem = self::getBranchItemByBranchID($branchID);   
        // Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('branchItem.show')->with('branchItem', $branchItem,'branchID',$branchID ); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Retrieve the branchItem        
        $branchItem = BranchItem::where('branchID',$branchID)->where('itemID',$itemID)->get();                  
        // Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('branchItem.edit')->with('branchItem', $branchItem);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
            $branchItem = BranchItem::where('branchID', $branchID)->where('itemID', $itemID)->get();         
			$branchItem->branchID = $request->branchID;
			$branchItem->itemID = $request->itemID;
			$branchItem->quantity = $request->quantity;
			$branchItem->lowStockLevel = $request->lowStockLevel;
            $branchItem->save();         
            return back()->with('success','Successfully updated branchItem Information!');     
        }   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($branchID, $itemID)
    {
		$branchItem = branchItem::where('branchID', $branchID)->where('itemID', $itemID)->get();
		$branchItem->delete();
		return redirect('branchItem')->with('success','Successfully deleted branchItem!');
    }
    
    
    
    /*************************************
     ********  Extend Function ***********
     *************************************/
     
    public function compositeKeyExists($request) 
    {
        return BranchItem::where('branchID', $request->branchID)->where('itemID', $request->itemID)->exists();    
    } 
    
     
	/** Show branchItem Information By your Item ID **/
	// I changed the return  ** View::make('branchItem.showBranchItemByItemID')->with('branchItem', $result)**
	public function getBranchItemByItemID($id) {
		if(BranchItem::where('itemID', $id)->get() == null) {
			return redirect('branchItem')->withError('Item of BranchItem table is not found!');
		}else {
			$result = BranchItem::where('itemID', $id)->get();
			return $result;
		}
	}
	
	/** Show branchItem Information By your Branch ID **/
	// I changed the return  ** View::make('branchItem.getBranchItemByBranchID')->with('branchID', $result)**
	public function getBranchItemByBranchID($id) {
		if(BranchItem::where('branchID', $id)->get() == null) {
			return redirect('branchItem')->withError('Branch of BranchItem table is not found!');
		}else {
			$result = BranchItem::where('branchID', $id)->get();
			return $result;
		}
	}
	
	
	
	// ***Change name for the below function:
    // public function show($array) /** Pass two parameter (brancID, itemID)**/
    // {
    //     // Retrieve the branchItem
    //     $branchItem = BranchItem::where('branchID', $array[0])->where('itemID', $array[1])->get();                  
    //     // Load the view and pass the retrieved order detail to the view for further processing        
    //     return View::make('branchItem.show')->with('branchItem', $branchItem); 
    // }
}
