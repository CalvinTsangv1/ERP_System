<?php

namespace App\Http\Controllers;

use App\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// Retrieve all the supplier
        $staff = Staff::all();
		
		// Load the view and pass the retrieved supplier to the view for further processing
		return View::make('supplier.index')->with('staff', $staff);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $input = $request->all();
		$rules = array ('name' => 'required',
						'contactPerson' => 'required',
						'telephone' => 'required|numeric',
						'address' => 'required',);
		
		$message = ['name.required' => 'Please input the supplier name',
					'contactPerson.required' => 'Please input the supplier contact Person',
					'telephone.required' => 'Please input the telephone number',
					'telephone.numeric' => 'Please input the telephone number in correct format',
					'address.required' => 'Please input the address in correct format',];
					
		$validator = Validator::make($input, $rules, $message);
		
		if($validator->fails()) {
			return Redirect::to('supplier/create')->withErrors($validator);
		}else {
			$supplier = new Supplier;
			$supplier->name = $request->name;
			$supplier->contactPerson = $request->contactPerson;
			$supplier->telephone = $request->telephone;
			$supplier->address = $request->address;
			$supplier->save();
			return back()->with('Apply Supplier Information','Apply Supplier Information Sucessfully!');
		}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
		
		$message = ['name.required' => 'Please input the supplier name',
					'contactPerson.required' => 'Please input the supplier contact Person',
					'telephone.required' => 'Please input the telephone number',
					'telephone.numeric' => 'Please input the telephone number in correct format',
					'address.required' => 'Please input the address in correct format',];
  
        $validator = Validator::make($input, $rules, $messages);                 
        if ($validator->fails()) {             
            return Redirect::to('supplier/create')>withErrors($validator);        
        } else {       
            $supplier = Supplier::find($id);         
			$supplier->name = $request->name;
			$supplier->contactPerson = $request->contactPerson;
			$supplier->telephone = $request->telephone;
			$supplier->address = $request->address;
            $supplier->save();         
            return back()->with('success','Successfully updated Supplier Information!');     
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
	
	
	
	/** Show Notification Information by your staff ID **/
	
	public function showNotifications($staffID) {
		if(Staff::find($id) == null) {
			return redirect('supplier')->withError('Notifications are not found!');
		}else{
			$result = Staff::find($id)->notifications;  
			return View::make('supplier.showNotifications')->with('supplier', $result);
		}
	}
	
	/** Show Branch Information By your staff ID **/
	
	public function showBranch($staffID) {
		return Staff::find($staffID)->branch;
	}
}
