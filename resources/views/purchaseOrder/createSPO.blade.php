@extends('layout')

@section('content')

<h1>Create Standard Purchase Order</h1>
{!! Form::open([ 'action'=>['PurchaseOrderController@createSPOWithDetail',$purchaseOrder], 'method' => 'GET','files'=>true])!!}
    </br>
    </br>
    <div class="jumbotron text-left" style="padding:20px">
        <h1 style="text-decoration: underline;">Standard Purchase Order</h1>
        <table name="AgreementHeader">
            <tr>
                <th>{{ Form::label('poNo', 'PO No.') }}</th>
                <td style="padding-left:200px">{{ Form::text('poNo', $purchaseOrder+1, array('class' => 'form-control','readonly')) }}</td>
            </tr>
            <tr style="display:none;">
                <th>{{ Form::label('requestID', 'Request ID') }}</th>
                <td style="padding-left:200px"> {{ Form::text('requestID', $purchaseRequest->requestID, array('class' => 'form-control','readonly')) }}</td>
            </tr>
            <tr>
                <th>{{ Form::label('supplierID', 'Supplier Name') }}</th>
                <td style="padding-left:200px">{{ Form::select('supplierID', $SupplierIDAndName,null, array('class' => 'form-control')) }}</td>
            </tr>

            <tr>
                <th>{{ Form::label('quotationNo', 'Quotation No.') }}</th>
                <td style="padding-left:200px">{{ Form::text('quotationNo', null, array('class' => 'form-control')) }}</td>
            </tr>
            <tr>
                <th>{{ Form::label('account', 'Account No.') }}</th>
                <td style="padding-left:200px">{{ Form::text('account', null, array('class' => 'form-control')) }}</td>
            </tr>
        </table>
    </div>
    <hr>
    <div class="jumbotron text-left" style="padding:20px">
    <h1 style="text-decoration: underline;">Purchase Request Details</h1>
        <table name="AgreementHeader">
            <tr><th>Request ID</th><td style="padding-left:200px">{{ $purchaseRequest->requestID }}</td></tr>
            <tr><th>Branch</th><td style="padding-left:200px"> {{ App\Http\Controllers\BranchController::getBranchName($purchaseRequest->branchID)->name }}</td></tr>
            <tr><th>Created Date</th><td style="padding-left:200px">{{ $purchaseRequest->createdDate }}</td></tr>
            <tr><th>Status</th><td style="padding-left:200px">{{ $purchaseRequest->status }}</td></tr>
            <tr><th>Expected Delivery Date</th><td style="padding-left:200px">{{ $purchaseRequest->expectedDeliveryDate }}</td></tr>
            <tr><th>Remarks</th><td style="padding-left:200px">{{ $purchaseRequest->remarks }}</td></tr>
        </table>
    </div>
    <hr>
    <div>
        <table class="table table-striped table-bordered">
            <div class="card-header">
                <h2>Purchase Request Item</h2>
            </div>
            <thead>
                <tr>
                    <th style="text-align:center">Item ID</th>
                    <th style="text-align:center">Item Name</th>
                    <th style="text-align:center">Requested Quantity</th>
                    <th style="text-align:center">Balance</th>
                    <th style="text-align:center">Quantity</th>
                    <th style="text-align:center">Unit Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchaseRequestItem as $key => $value)
                    <tr>
                        <td style="width:100px">{{ Form::text('itemID[]',$value->itemID , array('class' => 'form-control','readonly','style'=>'border-style:hidden;background:transparent;'))}}</td>
                        <td style="vertical-align:middle; ">{{ App\Http\Controllers\ItemController::showDetails($value->itemID)->name}}</td>
                        <td style="text-align:right;vertical-align:middle;">{{ $value->quantity }}</td>
                        <td style="text-align:right;vertical-align:middle;">{{ $value->balance }}</td>
                        <td style="text-align:center;vertical-align:middle;">{{ Form::number('quantity[]', $value->balance , array('class' => 'form-control','min'=>'0','max'=>$value->quantity)) }}</td>
                        <td style="text-align:center;vertical-align:middle;">{{ Form::number('price[]', 0 , array('class' => 'form-control','min'=>'0','max'=>'999999')) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="form-group text-right">
        {{ Form::submit('Submit', array('class' =>'btn btn-primary')) }}
    </div>
{{ Form::close() }}
@endsection