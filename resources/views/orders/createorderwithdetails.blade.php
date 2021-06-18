@extends('layout')

@section('content')

<h1>Create a Order</h1>

{!! Form::open(['action' =>'OrderController@storewithdetails', 'method' => 'POST','files'=>true])!!}

<div class="row">

    <div class="col-4 text-right">{{ Form::label('regno', 'Registration Number') }}</div>
    <div class="col-4">{{ Form::text('regno', null, array('class' => 'form-control')) }}</div>

</div>

<div class="row">

    <div class="col-4 text-right">{{ Form::label('regstate', 'Registration State') }}</div>
    <div class="col-4">{{ Form::text('regstate', null, array('class' => 'form-control')) }}</div>

</div>

<div class="row">

    <div class="col-4 text-right">{{ Form::label('custname', 'Customer Name') }}</div>
    <div class="col-4">{{ Form::text('custname', null, array('class' => 'form-control')) }}</div>

</div>

<div class="row">

    <div class="col-4 text-right">{{ Form::label('custphone', 'Customer Phone') }}</div>
    <div class="col-4">{{ Form::number('custphone', null, array('class' => 'form-control')) }}</div>

</div>

<div class="row">

    <div class="col-4 text-right">{{ Form::label('vehbrand', 'Vehicle Brand') }}</div>
    <div class="col-4">{{ Form::text('vehbrand', null, array('class' => 'form-control')) }}</div>

</div>

<div class="row">

    <div class="col-4 text-right">{{ Form::label('vehmodel', 'Vehicle Model') }}</div>
    <div class="col-4">{{ Form::text('vehmodel', null, array('class' => 'form-control')) }}</div>

</div>

<div class="row">

    <div class="col-4 text-right">{{ Form::label('vehyear', 'Vehicle Year') }}</div>
    <div class="col-4">{{ Form::text('vehyear', null, array('class' => 'form-control')) }}</div>

</div>

<div class="row">

    <div class="col-4 text-right">{{ Form::label('serialno', 'Vehicle Serial Number') }}</div>
    <div class="col-4">{{ Form::text('serialno', null, array('class' => 'form-control')) }}</div>

</div>



<br/><br/>
<!-- Detail Form -->
<div class="card">
    <div class="card-header ">
        <span >Order Items</span>
        <span >
            <button id="add_row" class="btn pull-left btn-primary">+</button>
            <button id='delete_row' class="btn pull-right btn-secondary">-</button>
        </span>
    </div>
    <div class="card-body">
        <table class="table" id="items_table">
             <thead class="thead-light">
                <tr>
                    <th>Description</th>
                    <th>Cost</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <tr id="item0">
                    <td><input type="text" name="desc[]" class="form-control" /></td>
                    <td><input type="number" name="cost[]" class="form-control" /></td>
                    <td><input type="number" name="price[]" class="form-control" /></td>
                </tr>
                <tr id="item1"></tr>
            </tbody>
        </table>
    </div>
</div>
</br>
<div class="row">
    <div class="col-4"></div>
    <div class="col-8 text-right">
        {{ Form::submit('Create the Order!', array('class' => 'btn btn-primary')) }}
    </div>
    <div class="col-4"></div>
</div>

{{ Form::close() }}

@endsection
