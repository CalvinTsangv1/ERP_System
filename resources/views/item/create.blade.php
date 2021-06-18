@extends('layout')
<!-- Child content section -->
@section('content')
<h1>Create Item</h1>
</br>
{!! Form::open(['action' =>'ItemController@store', 'method'=> 'POST','files'=>true]) !!}
    <div class="form-group">
        {{ Form::label('name', 'Item Name') }}
        {{ Form::text('name', null, array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('virtualItemID', 'Virtual Item ID') }}
        {{ Form::text('virtualItemID', null, array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('unitOfMeasurement', 'Unit of Measurement') }}
        {{ Form::text('unitOfMeasurement', null, array('class' => 'form-control')) }}
    </div>    
    <div class="form-group">
        {{ Form::label('description', 'Description') }}
        {{ Form::text('description', null, array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('categoryID', 'Category') }}
        {{Form::select('categoryID', $categoryNameAndItem ,null,array('class' => 'form-control')) }}
    </div>
    </br>
    <div class="form-group text-right">
        {{ Form::submit('Create', array('class' => 'btn btn-primary')) }}
    </div>
{{ Form::close() }}
@endsection