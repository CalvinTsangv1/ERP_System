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

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// Retrieve all the supplier
        $supplier = Supplier::all();
		
		// Load the view and pass the retrieved supplier to the view for further processing
		return View::make('supplier.index')->with('supplier', $supplier);
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
    public function store(Request $request)
    {
		$input = $request->all();
		$rules = array ('name' => 'required',
						'contactPerson' => 'required',
						'telephone' => 'required|numeric',
						'address' => 'required',
						);
		
		$messages = ['name.required' => 'Please input the supplier name',
					 'contactPerson.required' => 'Please input the supplier contact Person',
					 'telephone.required' => 'Please input the telephone number',
					 'telephone.numeric' => 'Please input the telephone number in correct format',
					 'address.required' => 'Please input the address in correct format',
					];
					
		$validator = Validator::make($input, $rules, $messages);
		
		if($validator->fails()) {
			return Redirect::to('supplier/create')->withErrors($validator);
		}else if(self::checkSupplierExist($request->name)){
				return back()->withErrors('Supplier Exist');
		}
			else {
			$supplier = new Supplier;
			$supplier->name = $request->name;
			$supplier->contactPerson = $request->contactPerson;
			$supplier->telephone = $request->telephone;
			$supplier->address = $request->address;
			$supplier->status = 'Active';
			$supplier->save();
			return redirect('supplier')->with('success','Apply Supplier Information Successfully!');
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
         $supplier = Supplier::find($id);                  
         // Load the view and pass the retrieved order detail to the view for further processing        
         return View::make('supplier.show')->with('supplier', $supplier); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Retrieve the order detail         
        $supplier = Supplier::find($id);                  
        // Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('supplier.edit')->with('supplier', $supplier);         
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
		$rules = array ('name' => 'required',
						'contactPerson' => 'required',
						'telephone' => 'required|numeric',
						'address' => 'required',);
		
		$messages = ['name.required' => 'Please input the supplier name',
					'contactPerson.required' => 'Please input the supplier contact Person',
					'telephone.required' => 'Please input the telephone number',
					'telephone.numeric' => 'Please input the telephone number in correct format',
					'address.required' => 'Please input the address in correct format',];
  
        $validator = Validator::make($input, $rules, $messages); 
        
        if ($validator->fails()) {             
            return Redirect::to('supplier/edit')->withErrors($validator);        
        } else if(self::checkSupplierIDAndNameExist($request->supplierID,$request->name)){
				return back()->withErrors('Supplier Exist');
		}else {       
            $supplier = Supplier::find($id);    
            
			$supplier->name = $request->name;
			$supplier->contactPerson = $request->contactPerson;
			$supplier->telephone = $request->telephone;
			$supplier->address = $request->address;
			$supplier->status = $request->status;
            $supplier->save();         
            
            return Redirect::to('supplier')->with('success','Successfully updated Supplier Information!');     
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
        $supplier = Supplier::find($id);
		$supplier->delete();
		return redirect('supplier')->with('success','Successfully deleted Supplier!');
    }
	
	public function test($id) {
		$supplier = new Supplier;
			$supplier->name = 'Test Data';
			$supplier->contactPerson = 'Test Person';
			$supplier->telephone = '29998888';
			$supplier->address = 'Test Address';
			$supplier->status = 'Active';
			$supplier->save();
	}
	
	public static function getSupplierName($id){
	    return Supplier::where('supplierID',$id)->first();
	}
	
	public function checkSupplierIDAndNameExist($id,$name){
	
		$supplier = Supplier::where('supplierID','!=',$id)->get();
		
		foreach($supplier as $key => $value){
			
			if($value->name==$name){
					return true;
			}
		}

		return false;
	}
	
	public function checkSupplierExist($name){
		
		$supplier = Supplier::where('name',$name)->exists();
		
		if($supplier==true){
			return true;
		}

		return false;
	}
	
}
