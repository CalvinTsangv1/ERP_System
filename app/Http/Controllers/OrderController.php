<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\View; 
use Illuminate\Support\MessageBag; 
use Carbon\Carbon; 
use Validator; 
use Input; 
use Session; 
use Redirect; 
use App\OrderDetail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     
        
        // Retrieve all the orders 
        $orders = Order::all(); 
        // Load the view and pass the retrieved orders to the view for further processing 
        return View::make('orders.index')->with('orders', $orders); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {       
       
            // Redirect the user to the create order view for order creation
            return View::make('orders.create');
       

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Get the submitted input
        $input = $request->all();
        // Create validation rules, please refer to https://laravel.com/docs/7.x/validation#available-validationrules for more details
        $rules = array(
            'regno' => 'required',
            'regstate' => 'required',
            'custname' => 'required',
            'custphone' => 'required|numeric',
            'vehbrand' => 'required',
            'vehmodel' => 'required',
            'vehyear' => 'required|numeric',
            'serialno' => 'required'
        );
        // Create customized validation messages
        $messages = [
            'regno.required' => 'Please input the Registration Number',
            'regstate.required' => 'Please input the Registration State',
            'custname.required' => 'Please input the Customer Name',
            'custphone.required' => 'Please input the Customer Phone',
            'custphone.numeric' => 'Please input the Customer Phone in correct format',
            'vehbrand.required' => 'Please input the Vehicle Brand',
            'vehmodel.required' => 'Please input the Vehicle Model',
            'vehyear.required' => 'Please input the Vehivle Manufacture Year',
            'vehyear.numeric' => 'Please input the Vehivle Manufacture Year in correct format',
            'serialno.required' => 'Please input the Vehicle Serial Nnumber',
        ];
        $validator = Validator::make($input, $rules,$messages);
        // Perform insert order action when validation pass or return to the index page if validation fails
        if ($validator->fails()) {
            return Redirect::to('orders/create')->withErrors($validator);
        } else {
        // Create a Order instance and configure the values before insert action
            $order = new Order;
            $order->regno = $request->regno;
            $order->regstate = $request->regstate;
            $order->custname = $request->custname;
            $order->custphone = $request->custphone;
            $order->vehbrand = $request->vehbrand;
            $order->vehmodel = $request->vehmodel;
            $order->vehyear = $request->vehyear;
            $order->serialno = $request->serialno;
            $order->createddate = Carbon::now();
            $order->save();
            
            return back()->with('success','Successfully created order!');
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
       // Retrieve the order
         $order = Order::find($id);
        
         // Load the view and pass the retrieved order to the view for further processing
         return View::make('orders.show')->with('order', $order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Retrieve the order
        $order = Order::find($id);
        // show the edit form and pass the order
        return view('orders.edit',compact('order'));
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
        
        $rules = array(
            'regno' => 'required',
            'regstate' => 'required',
            'custname' => 'required',
            'custphone' => 'required|numeric',
            'vehbrand' => 'required',
            'vehmodel' => 'required',
            'vehyear' => 'required|numeric',
            'serialno' => 'required'
        );
        
        $messages = [
            'regno.required' => 'Please input the Registration Number',
            'regstate.required' => 'Please input the Registration State',
            'custname.required' => 'Please input the Customer Name',
            'custphone.required' => 'Please input the Customer Phone',
            'custphone.numeric' => 'Please input the Customer Phone in correct format',
            'vehbrand.required' => 'Please input the Vehicle Brand',
            'vehmodel.required' => 'Please input the Vehicle Model',
            'vehyear.required' => 'Please input the Vehivle Manufacture Year',
            'vehyear.numeric' => 'Please input the Vehivle Manufacture Year in correct format',
            'serialno.required' => 'Please input the Vehicle Serial Nnumber',
        ];
        
        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to('orders/edit')->withErrors($validator);
        } else {
            $order = Order::find($id); 
            
            $order->regno = $request->regno;
            $order->regstate = $request->regstate;
            $order->custname = $request->custname;
            $order->custphone = $request->custphone;
            $order->vehbrand = $request->vehbrand;
            $order->vehmodel = $request->vehmodel;
            $order->vehyear = $request->vehyear;
            $order->serialno = $request->serialno;
            $order->createddate = Carbon::now();
            // Either one of the following can save the order
            $order->save();
            //$order->whereId($id)->update($input);
            // Redirect
            return redirect('orders')->with('success','Successfully updated order!');
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
        // Retrieve the order
        $order = Order::find($id);
        // Delete the retrieved order
        $order->delete();
        return redirect('orders')->with('success','Successfully deleted order!');
    }
    
    public function createorderwithdetails()
    {
        // Redirect the user back to the create order with details view
        return View::make('orders.createorderwithdetails'); 
    }
    
    public function storewithdetails(Request $request)
    {
        // Get the submitted input
        $input = $request->all();
        
        // Create validation rules, please refer to https://laravel.com/docs/7.x/validation#available-validationrules for more details
        $rules = array(
            'regno' => 'required',
            'regstate' => 'required',
            'custname' => 'required',
            'custphone' => 'required|numeric',
            'vehbrand' => 'required',
            'vehmodel' => 'required',
            'vehyear' => 'required|numeric',
            'serialno' => 'required'
            );
            // Create customized validation messages
            $messages = [
                'regno.required' => 'Please input the Registration Number',
                'regstate.required' => 'Please input the Registration State',
                'custname.required' => 'Please input the Customer Name',
                'custphone.required' => 'Please input the Customer Phone',
                'custphone.numeric' => 'Please input the Customer Phone in correct format',
                'vehbrand.required' => 'Please input the Vehicle Brand',
                'vehmodel.required' => 'Please input the Vehicle Model',
                'vehyear.required' => 'Please input the Vehivle Manufacture Year',
                'vehyear.numeric' => 'Please input the Vehivle Manufacture Year in correct format',
                'serialno.required' => 'Please input the Vehicle Serial Nnumber',
            ];
            
            $validator = Validator::make($input, $rules, $messages);
            // Perform insert order action when validation pass or return to the index page if validation fails
            if ($validator->fails()) {
                return Redirect::to('orders/createorderwithdetails')->withErrors($validator);
            } else {
                // Create a Order instance and configure the values before insert action
                $order = new Order;
                $order->regno = $request->regno;
                $order->regstate = $request->regstate;
                $order->custname = $request->custname;
                $order->custphone = $request->custphone;
                $order->vehbrand = $request->vehbrand;
                $order->vehmodel = $request->vehmodel;
                $order->vehyear = $request->vehyear;
                $order->serialno = $request->serialno;
                $order->createddate = Carbon::now();
                $order->save();
                
                // Insert order item detail based on the inserted order
                $descs = $request->input('desc', []);
                $costs = $request->input('cost', []);
                $prices = $request->input('price', []);
                
                for ($item=0; $item < count($descs); $item++) {
                    $orderdetail = new OrderDetail;
                    if ($descs[$item] != '') {
                        $orderdetail->desc = $descs[$item];
                        $orderdetail->cost = $costs[$item];
                        $orderdetail->price = $prices[$item];
                        $orderdetail->orderid =$order->orderid;
                        $order->orderdetails()->save($orderdetail);
                    }
                }
            }
            // Redirect
            return redirect('orders')->with('success','Successfully inserted order with details!');
    }

}
