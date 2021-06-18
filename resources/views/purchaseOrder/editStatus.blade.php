@extends('layout')
<!-- Child content section -->
@section('content')
<h1>Update Purchase Order Status</h1>
</br>
{!! Form::open([ 'action'=>['PurchaseOrderController@update',$purchaseOrder[1]->poNo], 'method' => 'PUT', 'files' => true]) !!}
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>PO No.</th>
                <th>Request ID</th>
                <th>Agreement ID</th>
                <th>Branch</th>
                <th>Status</th>
                <th style="text-align:center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchaseOrder as $key => $value)
                <tr>
                    <td>{{ $value->poNo }}</td> <!-- Don't use the text box -->
                    <td>{{ $value->requestID }}</td>
                    <td>{{ $value->agreementID }}</td>
                    <td>{{ App\Http\Controllers\BranchController::getBranchName(App\Http\Controllers\PurchaseRequestController::getRequest($value->requestID)->branchID)->name}}</td>
                    <td>{{ $value->status }}</td>
                    <td style="text-align:center">
                        <a class="btn btn-outline-success"  href="{{route('purchaseOrder.updateStatus', $value->poNo)}}">Mark as Completed</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
{{ Form::close() }}
@endsection