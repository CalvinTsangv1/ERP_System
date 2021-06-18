@extends('layout') 
 
@section('content') 
 <h1>Showing : {{ $orderdetail->order->regno }} / ID : {{ $orderdetail->detailid }}</h1> 
 <div class="jumbotron text-center">    
     <!-- Show the vehicle registration number belongs t this order detail using the relationship method in the model -->
     <p>Vehicle Registration Number: {{ $orderdetail->order->regno }}</p>     
     <p>Item Description: {{ $orderdetail->desc }}</p>
     <p>Item Cost: {{ $orderdetail->cost }}</p>    
     <p>Item Price: {{ $orderdetail->price }}</p>
 </div> 
 @endsection 