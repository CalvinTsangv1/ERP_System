@extends('layout')
<!-- Child content section -->
@section('content')

   <h1>Supplier Index</h1>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th style="text-align:center">Supplier ID</th>
                <th>Supplier Name</th>
                <th style="text-align:center">Status</th>
                <th style="text-align:center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($supplier as $key => $value)
            <tr>
                <td style="text-align:center">{{ $value->supplierID }}</td>
                <td><a href="{{route('supplier.show',$value->supplierID)}}">{{ $value->name }}</td>
                <td style="text-align:center">{{ $value->status }}</td>
                <td style="text-align:center">

                    <a class="btn btn-small btn-outline-success" href="{{route('supplier.show',$value->supplierID)}}" style="display:inline"><i class="fas fa-eye"></i></a>
                   
                    <a class="btn btn-small btn-outline-primary" href="{{URL::to('supplier/'.$value->supplierID.'/edit')}}" style="display:inline"><i class="fas fa-edit"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
   </table>
@endsection