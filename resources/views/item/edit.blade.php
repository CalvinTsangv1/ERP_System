@extends('layout')
@section('content')

<h1>Edit Item</h1>
</br>
</br>
{!! Form::open(['action' =>['ItemController@update',$item], 'method'=> 'PUT','files'=>true]) !!}
    <div class="form-group">
        {{ Form::label('name', 'Item Name') }}
        {{ Form::text('name', $item->name, array('class' =>'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('virtualItemID', 'Virtual Item ID') }}
        {{ Form::text('virtualItemID', $item->virtualItemID, array('class' =>'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('unitOfMeasurement', 'Unit Of Measurement') }}
        {{ Form::text('unitOfMeasurement', $item->unitOfMeasurement, array('class' =>'form-control')) }}
    </div>    
    <div class="form-group">
        {{ Form::label('description', 'Description') }}
        {{ Form::text('description', $item->description, array('class' =>'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('categoryID', 'Category') }}</br>
        {{Form::select('categoryID', $categoryNameAndItem ,$item->categoryID, array('class' =>'form-control')) }}
    </div>
    </br>
    <div class="form-group text-right">
        {{ Form::submit('Save', array('class' =>'btn btn-primary')) }}
    </div>
@endsection