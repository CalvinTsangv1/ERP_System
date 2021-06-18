@extends('layout')
@section('content')

<h1>Edit Supplier Information</h1>
{!! Form::open(['action' => ['SupplierController@update', $supplier], 'method' => 'PUT', 'files' => true]) !!}

    <div class="form-group">
    {{ Form::label('supplierID', 'Supplier ID') }}
    {{ Form::text('supplierID', $supplier->supplierID, array('class' => 'form-control','readonly')) }}
    </div>

    <div class="form-group">
    {{ Form::label('name', 'Supplier Name') }}
    {{ Form::text('name', $supplier->name, array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
    {{ Form::label('contactPerson', 'Contact Person') }}
    {{ Form::text('contactPerson', $supplier->contactPerson, array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
    {{ Form::label('telephone', 'Telephone Number') }}
    {{ Form::text('telephone', $supplier->telephone, array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
    {{ Form::label('address', 'Company Address') }}
    {{ Form::text('address', $supplier->address, array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
    {{ Form::label('status', 'Status') }}
    {{ Form::select('status', array('Active'=>'Active', 'Inactive'=>'Inactive') ,$supplier->status, array('class' => 'form-control')) }}
    </br>
    <div class="form-group text-right">
    {{ Form::submit('Save', array('class'=>'btn btn-primary')) }}
    </div>
{{ Form::close() }}

@endsection