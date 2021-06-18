@extends('layout')
<!-- Child content section -->
@section('content')

   <h1>Update Stock Count</h1>
    <table class="table table-striped table-bordered">
        <div class="card-header">
            <h2>Purchase Orders</h2>
        </div>
        <thead>
            <tr style="text-align:center">
                <th>PO No</th>
                <th>Request ID</th>
                <th>Created Date</th>
                <th style="width:50px" >Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchaseOrder as $key => $value)
            <tr style="text-align:center">
                <td>{{ $value->poNo }}</td>
                <td>{{ $value->requestID }}</td>
                <td>{{ $value->createdDate }}</td>
                <td >
                    <a class="btn btn-small btn-outline-primary" href="{{route('updateStockCount.PO',['requestID' => $value->requestID, 'poNo' => $value->poNo])}}">Mark as Delivered</a>
                </td>
            </tr>
            @endforeach
        </tbody>
   </table>
       <table class="table table-striped table-bordered">
        <div class="card-header">
            <h2>Delivery Notes</h2>
        </div>
        <thead>
            <tr>
                <th>DN No.</th>
                <th>DI No.</th>
                <th>Request ID</th>
                <th>Created Date</th>
                <th style="width:50px" >Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($deliveryNote as $key => $value)
            <tr>
                <td>{{ $value->dnNo }}</td>
                <td>{{ $value->diNo }}</td>
                <td>{{App\Http\Controllers\DispatchInstructionController::getRequestID($value->diNo)->requestID }}</td>
                <td>{{ $value->createdDate }}</td>
                <td >
                    <a class="btn btn-small btn-outline-primary" href="{{route('updateStockCount/DI',['requestID' => App\Http\Controllers\DispatchInstructionController::getRequestID($value->diNo)->requestID,'diNo'=>$value->diNo,'dnNo'=>$value->dnNo])}}">Mark as Delivered</a>
                </td>
            </tr>
            @endforeach
        </tbody>
   </table>
@endsection