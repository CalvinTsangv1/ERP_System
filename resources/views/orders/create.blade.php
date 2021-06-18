@extends('layout')
@section('content')
<h1>Create a Order</h1>
{!! Form::open(['action' =>'OrderController@store', 'method'=> 'POST','files'=>true])!!}
<div class="form-group">
{{ Form::label('categoryID', 'Category ID') }}
{{ Form::text('categoryID', null, array('class' => 'form-control'))}}
</div>
<div class="form-group">
{{ Form::label('regstate', 'Registration State') }}
{{ Form::text('regstate', null, array('class' =>'form-control')) }}
</div>
<div class="form-group">
{{ Form::label('custname', 'Customer Name') }}
{{ Form::text('custname', null, array('class' =>'form-control')) }}
</div>
<div class="form-group">
{{ Form::label('custphone', 'Customer Phone') }}
{{ Form::text('custphone', null, array('class' =>'form-control')) }}
</div>
<div class="form-group">
{{ Form::label('vehbrand', 'Vehicle Brand') }}
{{ Form::text('vehbrand', null, array('class' =>'form-control')) }}
</div>
<div class="form-group">
{{ Form::label('vehmodel', 'Vehicle Model') }}
{{ Form::text('vehmodel', null, array('class' =>'form-control')) }}
</div>
<div class="form-group">
{{ Form::label('vehyear', 'Vehicle Year') }}
{{ Form::text('vehyear', null, array('class' =>'form-control')) }}
</div>
<div class="form-group">
{{ Form::label('serialno', 'Vehicle Serial Number') }}
{{ Form::text('serialno', null, array('class' =>'form-control')) }}
</div>
<div class="form-group text-right">
{{ Form::submit('Create the Order!', array('class' =>'btn btn-primary')) }}
</div>
{{ Form::close() }}
@endsection