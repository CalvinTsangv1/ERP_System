@extends('layout')
<!-- Child content section -->
@section('content')

 <h1>Create Supplier</h1>
 </br>
 {!! Form::open(['action' =>'SupplierController@store', 'method'=> 'POST','files'=>true])!!}
  <div class="form-group">
   {{ Form::label('name', 'Supplier Name') }}
   {{ Form::text('name', null, array('class' => 'form-control')) }}
  </div>
  <div class="form-group">
   {{ Form::label('contactPerson', 'Contact Person') }}
   {{ Form::text('contactPerson',null, array('class' => 'form-control')) }}
  </div>
  <div class="form-group">
   {{ Form::label('telephone', 'Telephone Number') }}
   {{ Form::text('telephone',null , array('class' => 'form-control')) }}
  </div>
  <div class="form-group">
   {{ Form::label('address', 'Company Address') }}
   {{ Form::text('address',null , array('class' => 'form-control')) }}
  </div>
  <div class="form-group text-right">
   {{ Form::submit('Create', array('class' =>'btn btn-primary')) }}
  </div>
 {{ Form::close() }}
 
@endsection