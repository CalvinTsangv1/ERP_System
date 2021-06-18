@extends('layout')
@section('content')
<h1>Edit Purchase Request Item</h1>

{!! Form::open([ 'method' => 'PUT', 'files' => true]) !!}
   
    <div class="form-group">
    {{ Form::label('requestID', 'requestID') }}
    {{ Form::text('requestID', $purchaseRequestItem->requestID, array('class' => 'form-control','readonly')) }}
    </div>
    <div class="form-group">
    {{ Form::label('itemID', 'Item ID') }}
    {{ Form::text('itemID', $purchaseRequestItem->itemID, array('class' => 'form-control','readonly')) }}
    </div>
    <div class="form-group">
    {{ Form::label('quantity', 'quantity ') }}
    {{ Form::number('quantity',$purchaseRequestItem->quantity, array('class' => 'form-control','min'=>'0','max'=>'9999')) }}
    </div>
    <div class="form-group">
    {{ Form::label('balance', 'balance') }}
    {{ Form::number('balance', $purchaseRequestItem->balance, array('class' => 'form-control')) }}
    </div>
  
    <div class="form-group text-right">
    {{ Form::submit('Save', array('class'=>'btn btn-primary')) }}
    </div>
{{ Form::close() }}

@endsection  
