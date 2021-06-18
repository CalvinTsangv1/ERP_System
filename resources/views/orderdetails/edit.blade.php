@extends('layout') 
 
@section('content') 
 
<h1>Edit {{ $orderdetail->detailid }}</h1> 
 
 
{!! Form::open(['action' => ['OrderDetailController@update', $orderdetail], 'method' => 'PUT','files'=>true])!!} 
 
    <div class="form-group">    
        {{ Form::label('desc', 'Item Description') }}     
        {{ Form::text('desc', $orderdetail->desc, array('class' => 'form-control')) }}   
    </div> 
 
    <div class="form-group">      
        {{ Form::label('cost', 'Item Cost') }}      
        {{ Form::text('cost', $orderdetail->cost, array('class' => 'form-control')) }}  
    </div> 
 
    <div class="form-group">     
        {{ Form::label('price', 'Item Price') }} 
        {{ Form::text('price', $orderdetail->price, array('class' => 'form-control')) }}    
    </div> 
 
    <div class="form-group">       
        {{ Form::label('orderid', 'Order ID') }}      
        {{ Form::number('orderid', $orderdetail->detailid, array('class' => 'form-control')) }}    
    </div>     
    <div class="form-group text-right">      
        {{ Form::submit('Edit the Order Detail', array('class' => 'btn btn-primary')) }}    
    </div> 
 
{{ Form::close() }} 
 
@endsection 