@extends('layout')
<!-- Child content section -->
@section('content')
<h2>Map Purchase Request (Manual)</h2>
    <div class="text-right">
        <a href="{{ URL::to('mapPurchaseRequest/auto') }}" class="btn btn-outline-info">Re-direct to Map Purchase Request (Automatic)</a>
    </div>
    </br>

    <table class="table table-striped table-bordered">
        <div class="card-header">
            <h2>Outstanding Purchase Requests</h2>
        </div>
        <thead>
            <tr>
                <th style="text-align:center">Request ID</th>
                <th>Branch</th>
                <th style="text-align:center">Created Date</th>
                <th style="text-align:center">Status</th>
                <th style="width:100px;text-align:center">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach(App\Http\Controllers\PurchaseRequestController::getPendingAndFailedRequest() as $key =>$value )
                <tr>
                    <td style="text-align:center">{{ $value->requestID }}</td>
                    <td>{{ App\Http\Controllers\BranchController::getBranchName($value->branchID)->name }}</td>
                    <td style="text-align:center">{{ $value->createdDate }}</td>
                    <td style="text-align:center">{{ $value->status }}</td>
                    <td style="white-space:nowrap;text-align:center">
                        <button type="button" class="btn btn-outline-info"><a href="{{ URL::to('purchaseRequest/'.$value->requestID.'/showDetails')}}">View</button>
                        <button type="button" class="btn btn-outline-success"><a href="{{ URL::to('mapPurchaseRequest/execute/'.$value->requestID)}}">Map This Request</button>
                        <a href="{{ URL::to('purchaseOrder/createSPO/'.$value->requestID) }}" class="btn btn-outline-secondary">Create SPO</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
   </table>
@endsection