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
use Illuminate\Database\Eloquent\Builder;
use App\Branch;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// Retrieve all the supplier
        $branch = Branch::all();
		
		// Load the view and pass the retrieved supplier to the view for further processing
		return View::make('branch.index')->with('branch', $branch);
		
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
		$rules = array ('name' => 'required',
						'type' => 'required',
						'telephone' => 'required|numeric',
						'address' => 'required',);
		
		$message = ['name.required' => 'Please input the branch name',
					'type.required' => 'Please input the branch type',
					'telephone.required' => 'Please input the telephone number',
					'telephone.numeric' => 'Please input the telephone number in correct format',
					'address.required' => 'Please input the address',];
					
		$validator = Validator::make($input, $rules, $message);
		
		if($validator->fails()) {
			return Redirect::to('branch/create')->withErrors($validator);
		}else {
			$branch = new Branch;
			$branch->name = $request->name;
			$branch->type = $request->type;
			$branch->telephone = $request->telephone;
			$branch->address = $request->address;
			$branch->save();
			return back()->with('Apply Branch Information','Apply Branch Information Sucessfully!');
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
        // Retrieve the branch       
        $branch = Branch::find($id);                  
        // Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('branch.show')->with('branch', $branch); 
    }
    
    
    public function showBranch($staffID) 
    {
		if($this->getBranch($staffID) == null) 
		{
			return redirect('staff')->withError('Branch is not found!');
		}
		else 
		{
			$result = $this->getBranch($staffID)->branch;
			return View::make('staff.showBranch')->with('staff', $result);
		}
	}
	
	public function showItems($id) 
	{
		$list = array();
		foreach($this->getBranchItems($id) as $value) 
		{
			array_push($list, BranchItem::find($value->pluck('itemID')) ->item);
		}
		return $list;
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Retrieve the branch        
        $branch = Branch::find($id);                  
        // Load the view and pass the retrieved order detail to the view for further processing        
        return View::make('branch.edit')->with('branch', $branch);     
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
						'type' => 'required',
						'telephone' => 'required|numeric',
						'address' => 'required',);
		
		$message = ['name.required' => 'Please input the branch name',
					'type.required' => 'Please input the branch type',
					'telephone.required' => 'Please input the telephone number',
					'telephone.numeric' => 'Please input the telephone number in correct format',
					'address.required' => 'Please input the address',];
  
        $validator = Validator::make($input, $rules, $messages);                 
        if ($validator->fails()) {             
            return Redirect::to('branch/create')>withErrors($validator);        
        } else {       
            $branch = Branch::find($id);         
			$branch->name = $request->name;
			$branch->type = $request->type;
			$branch->telephone = $request->telephone;
			$branch->address = $request->address;
            $branch->save();         
            return back()->with('success','Successfully updated Branch Information!');     
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
		$branch = Branch::find($id);
		$branch->delete();
		return redirect('branch')->with('success','Successfully deleted Branch!');
    }
    
    
        
    /*************************************
     ********  Extend Function ***********
     *************************************/
	
	/** Get Branch Information By your staff ID **/
	public function getBranch($staffID) 
	{
		return Staff::find($staffID)->first();
	}
	
	public function getBranchItems($branchID)
	{
		return Branch::find($branchID)->branchItems;	
	}
	
	public static function getBranchName($branchID)
	{
		return Branch::where('branchID','=',$branchID)->first();	
	}
	
	
}
