<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;
use Carbon\Carbon;
use Validator;
use Input;
use Session;
use Redirect;
use Illuminate\Http\Request;
use App\ItemCategory;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // Retrieve all the supplier
        $item = Item::all();
		
		// Load the view and pass the retrieved supplier to the view for further processing
		return View::make('item.index')->with('item', $item);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryNameAndItem = ItemCategory::pluck('categoryName','categoryID')->toArray();
        return view('item.create' ,compact($categoryNameAndItem,'categoryNameAndItem'));
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
		$rules = array ('virtualItemID' => 'required',
						'name' => 'required',
						'unitOfMeasurement' => 'required',
						'categoryID' => 'required',);
		
		$messages = ['name.required' => 'Please input the item name',
					 'virtualItemID.required' => 'Please input the virtual item ID',
					 'unitOfMeasurement.required' => 'Please input the unit of Measurement',
					 'virtualItemID.numeric' => 'Please input the Virtual Item ID number in correct format',
					 'categoryID.required' => 'Please select the correct category',];
					
		$validator = Validator::make($input, $rules, $messages);
		
		if($validator->fails()) {
			return Redirect::to('item/create')->withErrors($validator);
		}else if(!$this->foreignKeyExists($request)) {
		    return back()->withErrors('Failed to store Items as categoryID does not exist on ItemCategory Table'); 
		}else {
			$item = new Item;
			$item->name = $request->name;
			$item->virtualItemID = $request->virtualItemID;
			$item->unitOfMeasurement = $request->unitOfMeasurement;
			$item->description = $request->description;
			$item->categoryID = $request->categoryID;
			$item->save();
			return redirect('item')->with('success','Create Item Successfully');
		}
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
                 // Retrieve the Supplier       
         $item = Item::find($id);                  
         // Load the view and pass the retrieved order detail to the view for further processing
         return View::make('item.show')->with('item', $item); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $categoryNameAndItem = ItemCategory::pluck('categoryName','categoryID')->toArray();
         // Retrieve the order detail         
        $item = Item::find($id);                  
        // Load the view and pass the retrieved order detail to the view for further processing        
        return view('item.edit',compact('item', $item , 'categoryNameAndItem',$categoryNameAndItem )); 
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
 		$rules = array ('virtualItemID' => 'required',
						'name' => 'required',
						'unitOfMeasurement' => 'required',
						'categoryID' => 'required',);
						
		$messages = ['name.required' => 'Please input the item name',
					'virtualItemID.required' => 'Please input the virtual item number',
					'unitOfMeasurement.required' => 'Please input the unit of Measurement',
					'categoryID.required' => 'Please select the correct category ',
					'categoryID.numeric' => 'Please input the Category number in correct format',];
  
        $validator = Validator::make($input, $rules, $messages);        
        
        if ($validator->fails()) {             
            return Redirect::to('item/edit')->withErrors($validator);        
        } else if (!$this->foreignKeyExists($request)) {
            return back()->withErrors('Failed to edit the Item as categoryID is not found on ItemCategory Table !'); 
        }else {       
            $item = Item::find($id);    
            $item->name = $request->name;
			$item->virtualItemID = $request->virtualItemID;
			$item->unitOfMeasurement = $request->unitOfMeasurement;
			$item->description = $request->description;
			$item->categoryID = $request->categoryID;
        	$item->save();
            
            return Redirect::to('item')->with('success','Successfully updated Item !');     
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
		$item->delete();
		return redirect('item')->with('success','Successfully deleted item!');
    }
    
    
    
    /*************************************
     ********  Extend Function ***********
     *************************************/
     
     /** Validate Insert Process **/
     public function foreignKeyExists($request)
     {
        return ItemCategory::find($request->categoryID)->exists();
     }
    
	public function showItemCategory($id)
	{
		return Item::find($id)->itemCategory;	
	}
	
	public function showItemCategoryRelationship($id)
	{
		$temp = [Item::find($id)->itemCategory->categoryID];
		$list = array();
		while($temp[0] != null) {
			array_push($list,$temp[0]);
			$temp = ItemCategory::where('categoryID','=',$temp)->get()->pluck('parentCategoryID');
		}
		return ItemCategory::find($list);
	}
	
	 public static function showDetails($id){
	     return  Item::where('itemID',$id)->first();
	 }
	
	
}
