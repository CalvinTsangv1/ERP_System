
@extends('layout')

@section('content')
<span onclick="history.back()" style="font-size:25px; cursor: pointer;">
  <i class="fas fa-arrow-circle-left"></i>
  Back
</span>
</br>
</br>
<h1>Supplier Information</h1>

<div class="jumbotron text-left" style="font-size: 2em">
  
  <p>Supplier ID : {{ $supplier->supplierID }}</p>
  <p>Supplier Name : {{ $supplier->name }}</p>
  <p>Contact Person : {{ $supplier->contactPerson }}</p>
  <p>Telephone : {{ $supplier->telephone }}</p>
  <p>Company Address : {{ $supplier->address }}</p>
  <p>Status : {{ $supplier->status }}</p>

</div>
@endsection
