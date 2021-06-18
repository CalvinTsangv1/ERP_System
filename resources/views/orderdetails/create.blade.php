@extends('layout') 

@section('content') 
 <h1>Create a Order Detail</h1> 
 
 
{!! Form::open(['action' =>'OrderDetailController@store', 'method' => 'POST','files'=>true])!!} 
     <div class="form-group">      
         {{ Form::label('desc', 'Item Description') }}     
         {{ Form::text('desc', null, array('class' => 'form-control')) }}  
     </div> 
     <div class="form-group">      
         {{ Form::label('cost', 'Item Cost') }}     
         {{ Form::text('cost', null, array('class' => 'form-control')) }}    
     </div> 
     <div class="form-group">        
         {{ Form::label('price', 'Item Price') }}       
         {{ Form::text('price', null, array('class' => 'form-control')) }}  
     </div> 
     <div class="form-group">        
         {{ Form::label('orderid', 'Order ID') }}     
         {{ Form::number('orderid', null, array('class' => 'form-control')) }}    
     </div>          
     <div class="form-group text-right">    
         {{ Form::submit('Create the Order Detail', array('class' => 'btn btn-primary')) }} 
     </div> 
 {{ Form::close() }} 
 @endsection 