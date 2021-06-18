@extends('layout')
<!-- Child content section -->
@section('content')
<h1>Purchase Order Index</h1>
</br>
<table class="table table-striped table-bordered table-hover results">
    <thead>
        <tr>
            <th>PO No.</th>
            <th>Request ID</th>
            <th>Branch</th>
            <th>Status</th>
            <th style="text-align:center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($purchaseOrder as $key => $value)
        <tr>
            <td>{{ $value->poNo }}</td>
            <td>{{ $value->requestID }}</td>
            <td>{{ App\Http\Controllers\BranchController::getBranchName(App\Http\Controllers\PurchaseRequestController::getRequest($value->requestID)->branchID)->name}}</td>
            <td>{{ $value->status }}</td>
            <!-- we will also add show, edit, and delete buttons -->
            <td style="text-align:center">
            <!-- Show the order (uses the show method found at GET /orders/{id} -->
                <a class="btn btn-small btn-success" href="{{ URL::to('purchaseOrder/'.$value->poNo ) }}">View Details</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection