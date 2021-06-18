@extends('layout')
<!-- Child content section -->
@section('content')
<div>
    <span onclick="history.back()" style="font-size:25px; cursor: pointer;">
        <i class="fas fa-arrow-circle-left"></i>
        Back
    </span>
</div>
<h1>Purchase Request Details</h1>
</br>
<div class="jumbotron text-left" style="font-size: 2em">
    <p>Purchase request ID: {{ $colmunName['requestID'] }}</p>
    <p>Branch Name: {{ $colmunName['branchName'] }}</p>
    <p>Created Date: {{ $colmunName['createdDate'] }}</p>
    <p>Expected Delivery Date: {{ $colmunName['expectedDeliveryDate'] }}</p>
    <p>Status: {{ $colmunName['status'] }}</p>
    <p>Remarks: {{ $colmunName['remarks'] }}</p>
</div>
    
</br></br>

<table class="table table-striped table-bordered">
    <div class="card-header">
        <h2>Purchase Request Item</h2>
    </div>
    <thead>
        <tr>
            <th>Virtual Item ID</th>
            <th style="text-align:center">Item Name</th>
            <th style="text-align:center">Quantity</th>
            <th style="text-align:center">Balance</th>
            <th style="text-align:center">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($purchaseRequestItem as $key => $value)
            <tr>
                <td>{{ App\Http\Controllers\ItemController::showDetails($value->itemID)->virtualItemID }}</td>
                <td>{{ App\Http\Controllers\ItemController::showDetails($value->itemID)->name }}</td>
                <td style="text-align:right">{{ $value->quantity }}</td>
                <td style="text-align:right">{{ $value->balance }}</td>
                <!-- we will also add show, edit, and delete buttons -->
                <td style="text-align:center">
                    <a class="btn btn-small btn-outline-danger" href="{{ route('purchaseRequestItem.destroy', ['requestID'=>$value->requestID,'itemID'=>$value->itemID])}}" style="display:inline"><i class="fas fa-trash-alt"></i></a>
                    <!-- Show the order (uses the show method found at GET /orders/{id} -->
                    <a class="btn btn-small btn-outline-primary" href="{{ route('purchaseRequestItem.edit',['requestID'=>$value->requestID,'itemID'=>$value->itemID])}}" ,style="display:inline"><i class="fas fa-edit"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection