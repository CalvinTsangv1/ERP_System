@extends('layout')
    @section('content')
        <h1>Edit {{ $order->regno }}</h1>
        {!! Form::open(['action' => ['OrderController@update', $order], 'method' => 'PUT','files'=>true])!!}
        <div class="form-group">
            {{ Form::label('regno', 'Registration Number') }}
            {{ Form::text('regno', $order->regno, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('regstate', 'Registration State') }}
            {{ Form::text('regstate', $order->regstate,array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('custname', 'Customer Name') }}
            {{ Form::text('custname', $order->custname, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('custphone', 'Customer Phone') }}
            {{ Form::text('custphone', $order->custphone, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('vehbrand', 'Vehicle Brand') }}
            {{ Form::text('vehbrand', $order->custphone, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('vehmodel', 'Vehicle Model') }}
            {{ Form::text('vehmodel', $order->vehmodel, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('vehyear', 'Vehicle Year') }}
            {{ Form::text('vehyear', $order->vehyear, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('serialno', 'Vehicle Serial Number') }}
            {{ Form::text('serialno', $order->serialno, array('class' => 'form-control')) }}
        </div>
        <div class="form-group text-center">
            {{ Form::submit('Edit the Order!', array('class' => 'btn btn-primary')) }}
        </div>
        {{ Form::close() }}
    @endsection