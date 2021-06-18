@extends('layout')
<!-- Child content section -->
@section('content')
<h1>Create Category</h1>
</br>
{!! Form::open(['action' =>'ItemCategoryController@store', 'method'=> 'POST','files'=>true])!!}
    <div class="form-group">
        {{ Form::label('categoryName', 'Category Name') }}
        {{ Form::text('categoryName', null, array('class' =>'form-control')) }}
    </div>
    <div class="form-group">
        {{ Form::label('parentCategoryID', 'Parent Category') }}
        {{ Form::select('parentCategoryID', $categoryIDAndName , null, array('class' =>'form-control')) }}
    </div>
    </br>
    <div class="form-group text-right">
        {{ Form::submit('Create', array('class' =>'btn btn-primary')) }}
    </div>
{{ Form::close() }}
@endsection