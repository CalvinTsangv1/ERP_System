@extends('layout')
@section('content')

<h1>Edit Category Name : {{ $item->name }}</h1>
{!! Form::open(['action' =>['ItemController@update',$item], 'method'=> 'PUT','files'=>true])!!}

    <div class="form-group">
    {{ Form::label('name', 'Item Name') }}
    {{ Form::text('name', $item->name, array('class' =>'form-control')) }}
    </div>
    <div class="form-group">
    {{ Form::label('virtualItemID', 'Virtual Item ID ') }}
    {{ Form::text('virtualItemID', $item->virtualItemID, array('class' =>'form-control')) }}
    </div>
    

    <div class="form-group">
    {{ Form::label('unitOfMeasurement', 'Unit Of Measurement') }}
    {{ Form::text('unitOfMeasurement', $item->unitOfMeasurement, array('class' =>'form-control')) }}
    </div>    
    <div class="form-group">
    {{ Form::label('description', 'Description') }}
    {{ Form::text('description', $item->unitOfMeasurement, array('class' =>'form-control')) }}
    </div>
    <div class="form-group">
    {{ Form::label('categoryID', 'Category ') }}</br>
    {{Form::select('categoryID', 
         $categoryNameAndItem ,$item->categoryID,
        array('class' =>'form-control')) }}
    </div>
    
    <div class="form-group text-right">
    {{ Form::submit('Edit the Item!', array('class' =>'btn btn-primary')) }}
    </div>

@endsection