<?php

namespace App\Http\Controllers;

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
use gmsdb;
use App\BranchItem;

class ItemCategoryController extends Controller
{
	
	public function index() {
		// Retrieve all item Category
		$itemCategory = ItemCategory::all();
		
		return View::make('itemCategory.index')->with('itemCategory', $itemCategory);
	}
	
	public function create() {
		
	
		$categoryIDAndName = ItemCategory::pluck('categoryName', 'categoryID')->toArray();
		
		 return View::make('itemCategory.create')->with('categoryIDAndName', $categoryIDAndName);
	}    
	
	public function store(Request $request) {
		
		$input = $request->all();
		
		$rules = array ('categoryName' => 'required',
						'parentCategoryID' => 'required|numeric',);
		$messages = ['categoryName.required' => 'Please input the Category Name',
					 'parentCategoryID.required' => 'Please input the Parent Category ID',
					 'parentCategoryID.numeric' => 'Please input the Parent Category in correct format',];
		$validator = Validator::make($input, $rules, $messages);
		
		if($validator->fails()) {
			return back()->withErrors($validator);
		}else {
			$itemCategory = new ItemCategory;
			$itemCategory->categoryName = $request->categoryName;
			$itemCategory->parentCategoryID = $request->parentCategoryID;
			$itemCategory->save();
			return redirect('itemCategory')->with('success', 'Create Item Category Successfully!');
		}
	}
	
    public function show($id)
    {
         // Retrieve the item Category         
         $itemCategory = ItemCategory::find($id);                  
         // Load the view and pass the retrieved order detail to the view for further processing        
         return View::make('itemCategory.show')->with('itemCategory', $itemCategory); 
    }

    public function edit($id)
    {
        // Retrieve the order detail         
        $itemCategory = ItemCategory::find($id);    
        $itemCategoryNameList = ItemCategory:: pluck('categoryName', 'categoryID')->toArray();
        // Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('itemCategory.edit')->with('itemCategory', $itemCategory)->with('itemCategoryNameList', $itemCategoryNameList); 
    }

    public function update(Request $request, $id)
    {  
        $input = $request->all();
 		$rules = array ('categoryName' => 'required',
						'parentCategoryID' => 'required|numeric',);
						
		$messages = ['categoryName.required' => 'Please input the Category Name',
					 'parentCategoryID.required' => 'Please input the Parent Category ID',
					 'parentCategoryID.numeric' => 'Please input the Parent Category in correct format',
					];
  
        $validator = Validator::make($input, $rules, $messages);        
        
        if ($validator->fails()) {             
            return Redirect::to('itemCategory/edit')>withErrors($validator);        
        } else {       
            $itemCategory = ItemCategory::find($id);
            $itemCategory->categoryName = $request->categoryName;
            $itemCategory->parentCategoryID = $request->parentCategoryID;
            $itemCategory->save();  
            
            return redirect('itemCategory')->with('success','Updated Item Category Successfully');     
        } 
    }

    public function destroy($id)
    {        
    	
    	$categoryAll=ItemCategory::all();
    
    	foreach($categoryAll as $key =>$value){
    		
    		if($value->parentCategoryID==$id){
    		
    			return back()->withErrors('Have a child category , cannot delete this category where is '.$value->categoryName);
    		}
    	}
    	
    	$itemCategory=ItemCategory::where('categoryID',$id)->first();
    	
    	if($itemCategory->categoryID>$itemCategory->parentCategoryID){
    		$itemCategory= ItemCategory::find($id)->delete();
    	}
    	
    	return back()->with('success','Deleted Item Category Successfully');   
    	

         
    }

    
    
    /*************************************
     ********  Extend Function ***********
     *************************************/   
     
     
    // public function checkCategoryId($request) 
    // {
    //     return ItemCategory::where('categoryID', $request->parentCategoryID)->exists();    
    // }
 
    public function foreignKeyExists($request) 
    {
        return BranchItem::where('parentCategoryID', $request->parentCategoryID)->exists();    
    }
    
    public static function referenceForeignKeyExists($categoryID)
    {
    	return BranchItem::where('parentCategoryID', $categoryID)->exists();
    }
    
    
    public function getLevelOneItemCategory($itemID) {
		return ItemCategory::with(['parentItemCategory'=> function($query) {
									$query->where('categoryID', '=', $itemID);
									}])->get();
	}
	
	
	public function getItemCategory($itemID) {
		return ItemCategory::where('categoryID', '=', $itemID)->get();
	}
	
	public static function getCategoryName($categoryID) {
		
		if(ItemCategory::where('categoryID', '=', $categoryID)->first('categoryName')==null){
			return ' \ ';
		}else{
			return ItemCategory::where('categoryID', '=', $categoryID)->first('categoryName','');
		}
		
	}
	
	public function getParentItemCategoryIDCount($itemID) {
		$temp = $parentCategoryID = [$itemID];
		$count = 0;
		while($temp[0] != null) {
			$temp = ItemCategory::where('categoryID', '=', $parentCategoryID)->get()->pluck('parentCategoryID');
			$parentCategoryID = $temp;
			$count++;
		}
		return $count;
	}
	
	public static function getParentItemCategoryIDList($itemID) {

		$temp = [$itemID];
		$list = array();
		$count = 0;
		while($temp[0] != null) {
			if($count >= 0) {
				array_push($list, $temp[0]);
			}else {
				$count++;
			}
			$temp = ItemCategory::where('categoryID', '=', $temp)->get()->pluck('parentCategoryID');
		}

		return self::getParentItemCategoryName($list);
	}
	
	public static function getParentItemCategoryName($array) {
		$parentItemCategroyString = '';
		$count = 0;
		foreach($array as $value) {
			if($count == 0) {
				$parentItemCategroyString = sprintf('%s', ItemCategory::where('categoryID', (string)$value)->get()->pluck('categoryName')[0]) ;
				$count++;
			}else {
				$parentItemCategroyString = sprintf('%s \ %s', ItemCategory::where('categoryID', (string)$value)->get()->pluck('categoryName')[0], $parentItemCategroyString) ;
			}
		}
		return $parentItemCategroyString;
	}
	
	/** Reminder: If only get one element, use 'variable -> pluck([key])' */
	public function getParentItemCategory($itemID) {
		$temp = [$itemID];
		while($temp[0] != null) {
			$categoryID = $temp[0];
			$temp = ItemCategory::where('categoryID', '=', $temp)->get()->pluck('parentCategoryID');
		}
		return ItemCategory::where('categoryID', '=', $categoryID)->get();
	}
	

}
