@extends('layout')
@section('content')

<h1>Edit Category</h1>
</br>
{!! Form::open(['action' => ['ItemCategoryController@update',$itemCategory], 'method'=> 'PUT','files'=>true]) !!}
    <div class="form-group">
        {{ Form::label('categoryName', 'Category Name') }}
        {{ Form::text('categoryName', $itemCategory->categoryName , array('class' => 'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('parentCategoryID', 'Parent Category') }}
        {{ Form::select('parentCategoryID',$itemCategoryNameList,$itemCategory->parentCategoryID , array('class' => 'form-control')) }}
    </div>
    </br>
    <div class="form-group text-right">
        {{ Form::submit('Save', array('class' =>'btn btn-primary')) }}
    </div>
{{ Form::close() }}

@endsection