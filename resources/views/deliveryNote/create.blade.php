@extends('layout')
<!-- Child content section -->
@section('content')
<h1>Create Delivery Note</h1>
{!! Form::open(['action' =>'DeliveryNoteController@store', 'method'=> 'POST','files'=>true])!!}

    <div class="form-group">
        {{ Form::label('dnNo', 'Delivery Note No.') }}
        {{ Form::text('dnNo', $deliveryNoteNumber+1, array('class' =>'form-control','readonly')) }}
    </div>
    <div class="form-group">
        {{ Form::label('diNo', 'Dispatch Instruction No.') }}
        {{ Form::text('diNo', $dispatchInstruction->diNo, array('class' =>'form-control','readonly')) }}
    </div>
    <div class="form-group">
        {{ Form::label('requestID', 'Request ID') }}
        {{ Form::text('requestID', $dispatchInstruction->requestID, array('class' =>'form-control','readonly')) }}
    </div>
    <div class="form-group">
        {{ Form::label('branchID', 'Branch Name') }}
        {{ Form::text('branchID',  App\Http\Controllers\BranchController::getBranchName( 
                                   App\Http\Controllers\PurchaseRequestController::getRequest($dispatchInstruction->requestID)->branchID)->name,
                                   array('class' =>'form-control','readonly')) }}
    </div>
    <div class="form-group">
        {{ Form::label('createdDate', 'Created Date') }}
        {{ Form::date('createdDate', \Carbon\Carbon::now(), array('class' =>'form-control','readonly')) }}
    </div>
    <div class="form-group text-right">
        {{ Form::submit('Create', array('class' =>'btn btn-primary')) }}
    </div>
{{ Form::close() }}
@endsection