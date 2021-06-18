@extends('layout')
<!-- Child content section -->
@section('content')
<span onclick="history.back()" style="font-size:25px; cursor: pointer;">
    <i class="fas fa-arrow-circle-left"></i>
    Back
</span>
</br>
<h1>Purchase Order Details</h1>
<div class="jumbotron text-left" style="padding:20px">
    <table name="AgreementHeader" class="table table-striped table-bordered table-hover results">
        <tr><th>PO No.</th><td style="padding-left:200px">{{ $purchaseOrder->poNo }}</td></tr>
        <tr><th>Request ID</th><td style="padding-left:200px"> {{ $purchaseOrder->requestID }}</td></tr>
        <tr><th>Agreement ID</th><td style="padding-left:200px">{{ $purchaseOrder->agreementID }}</td></tr>
        <tr><th>Revision</th><td style="padding-left:200px">{{ $purchaseOrder->revision }}</td></tr>
        <tr><th>Supplier ID</th><td style="padding-left:200px">{{ App\Http\Controllers\SupplierController::getSupplierName($purchaseOrder->supplierID)->name }}</td></tr> <!-- Please show the Supplier Name instead of ID "DONE"-->
        <tr><th>Release No.</th><td style="padding-left:200px">{{ $purchaseOrder->releaseNo }}</td></tr>
        <tr><th>Type</th><td style="padding-left:200px">{{ $purchaseOrder->type }}</td></tr>
        <tr><th>Status</th><td style="padding-left:200px">{{ $purchaseOrder->status }}</td></tr>
        <tr><th>Quotation No.</th><td style="padding-left:200px">{{ $purchaseOrder->quotationNo }}</td></tr>
        <tr><th>Created Date</th><td style="padding-left:200px">{{ $purchaseOrder->createdDate }}</td></tr>
        <tr><th>Account No.</th><td style="padding-left:200px">{{ $purchaseOrder->account }}</td></tr>
        <tr><th>Shipment Address</th><td style="padding-left:200px">{{ $purchaseOrder->shipmentAddress }}</td></tr>
    </table>
</div>
<div>
    <h1 style="text-align:Left;">Purchase Order Item</h1>
    <table class="table table-striped table-bordered table-hover results">
        <thead>
            <tr style="text-align: center;">
                <th>Virtual Item ID</th>
                <th>Item Name</th>
                <th>Quantity</th>
            </tr>
        </thread>
        <tbody>
            @foreach($purchaseOrderItem as $key =>$value)
                <tr>
                    <td style="text-align: center;">{{ App\Http\Controllers\ItemController::showDetails($value->itemID)->virtualItemID}}</td> <!-- Please add the virtual item id 'done'-->
                    <td style="text-align: center;">{{ App\Http\Controllers\ItemController::showDetails($value->itemID)->name }}</td>
                    <td style="text-align: center;">{{ $value->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection