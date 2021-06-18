@extends('layout')
<!-- Child content section -->
@section('content')
<h1>Here is Branch Item</h1>
<table class="table table-striped table-bordered table-hover results">
    <thead>
        <tr>  
            <th style="width:50px">Branch ID</th>
            <th style="width:150px">Name</th>
            <th style="width:20px">Actions</th>
                
            </tr>
        </thead>
       <tbody>
           @foreach($branchItem as $key => $value)
           
            <tr>
                <td>{{ $value->branchID }}</td>
                <td>{{ $value->name }}</td>
                <td>

                            <!-- Show the order (uses the show method found at GET /orders/{id} -->
                    <a class="btn btn-small btn-success" href="{{route('branchItem.show',array($value->branchID, $value->itemID)) }}" style="display:inline"><i class="fas fa-eye"></i></a>
                 
                   
                </td>
            </tr>
             
             @endforeach
        </tbody>
      
   </table>

   
   <!--  pass two parameter to function : https://stackoverflow.com/questions/31681715/passing-multiple-parameters-to-controller-in-laravel-5   -->
@endsection
