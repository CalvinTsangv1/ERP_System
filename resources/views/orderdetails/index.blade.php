@extends('layout') 
<!-- Child content section --> 
@section('content') 
<table class="table table-striped table-bordered">    
 <thead>        
  <tr >        
   <th>Detail Description</th>           
   <th>Item Cost</th>       
   <th>Item Price</th>           
   <th>Actions</th>      
  </tr>    
 </thead>     
 <tbody>     
 @foreach($orderdetails as $key => $value)         
  <tr>   
   <td>
    <a href="{{ route('orderdetails.show', $value->orderid)}}">{{ $value->desc  }}</a>
   </td>
   <td>{{ $value->cost }}</td>     
   <td>{{ $value->price }}</td> 
   <!-- we will also add show, edit, and delete buttons -->            
   <td>     
    <div class="btn-group">
     <button type="button" class="btn btn-danger">Action</button>
     <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <span class="caret"></span>
      <span class="sr-only">Toggle Dropdown</span>
     </button>
     <ul class="dropdown-menu">
      <li><a href="#">
       <form action="{{ route('orderdetails.destroy', $value->detailid)}}" method="post">       
        @csrf              
        @method('DELETE')             
        <button class="btn btn-block btn-danger" type="submit">Delete Order</button>      
       </form>                           
      </a></li>
      <li><a class="btn btn-block btn-success" href="{{ URL::to('orderdetails/' . $value->detailid) }}">Show this Order Detail</a></li>
      <li><a class="btn btn-block btn-info" href="{{ URL::to('orderdetails/' . $value->detailid . '/edit') }}">Edit this Order Detail</a> </li>
     </ul>
    </div>
   </td>     
  </tr>   
 @endforeach   
 </tbody>
</table> 
 @endsection 
 
