@extends('layout')
<!-- Child content section -->
@section('content')


{!! Form::open([ 'action'=>'MapPurchaseRequestController@submitAgreementAndInventory','method' => 'POST','files'=>true])!!}
  <table class="table table-striped table-bordered">
      <h1>Purchase Request Details</h1>
        <thead>
            <tr>
                <th>Purchase request ID</th>
                <th>Branch Name</th>
                <th>Created Date</th>
                <th>Expected Delivery Date</th>
                <th>Status</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
      
            <tr>
                <td>{{$purchaseRequest->requestID}}</td>
                <td>{{  App\Http\Controllers\BranchController::getBranchName($purchaseRequest->branchID)->name}}</td>
                <td>{{$purchaseRequest->createdDate}}</td>
                <td>{{$purchaseRequest->expectedDeliveryDate}}</td>
                <td>{{$purchaseRequest->status}}</td>
                <td>{{$purchaseRequest->remarks}}</td>
             
            </tr>
           
        </tbody>
    </table>
<hr>

    <table class="table table-striped table-bordered">
        <h1>Purchase Request Item Details</h1>
        <thead>
            <tr>
                <th>Request ID</th>
                <th>Item Name</th>
                <th>Requested Quantity</th>
            <!--    <th>Quantity</th> -->
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
             @foreach($purchaseRequestItem as $key => $value)
            <tr>
                <td>{{ $value->requestID }}</a></td>
                <td>{{ App\Http\Controllers\ItemController::showDetails($value->itemID)->name }}</td>
                <td >{{ $value->quantity }}</td>
            <!--    <td >{{Form::number('mapQuantity[]',0,array('class'=>'form-control', 'max'=> $value->quantity ,'min'=>'0' ))}}</td> -->
                <td >{{ $value->balance }}</td>
                <!--點做個即時計算出黎？-->

            </tr>
             @endforeach
        </tbody>
    </table>
    <hr>
    {{ Form::text('branchID', $purchaseRequest->branchID, array('style'=>'display:none')) }}
    {{ Form::text('requestID', $purchaseRequest->requestID, array('style'=>'display:none'))}}
    @foreach($agreementHeaderList as $key=>$value)
    {{ Form::text('agreementID[]', $value['agreementID'], array('style'=>'display:none')) }}
    {{ Form::text('agreementRevision[]', $value['revision'], array('style'=>'display:none')) }}
    {{ Form::text('agreementItemID[]', $value['itemID'], array('style'=>'display:none')) }}
    @endforeach
    <table class="table table-striped table-bordered">
        <h1>Agreement Details</h1>
        <thead>
            <tr>
                <th>Agreement ID</th>
                <th>Agreement Type</th>
                <th>Item Name</th>
                <th>Agreement Balance</th>
                <th>Price</th>
                <th>Purchase Quantity</th>
            </tr>
        </thead>
        <tbody>
             @foreach($agreementHeaderList as $key=>$value)
            <tr>
                <td>{{ $value['agreementID'] }}</td>
                <td>{{ $value['type'] }}</td>
                <td>{{ App\Http\Controllers\ItemController::showDetails($value['itemID'])->name }}</td>
                <td>{{ $value['balance'] }}</td>
                <td>{{ $value['price'] }}</td>
                <td><input type="number" name="agreementQuantity[]" class="form-control"/></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @foreach($branchList as $value)
    {{ Form::text('branchItemID[]', $value->itemID, array('style'=>'display:none')) }}
    @endforeach
    <hr>
    <table class="table table-striped table-bordered">
        <h1>Inventory Details</h1>
        <thead>
            <tr>
                <th>Branch Name</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Low Stock Level</th>
                <th>Purchase Quantity</th>
            </tr>
        </thead>
        <tbody>
             @foreach($branchList as $value)
            <tr>
                <td>{{ $value->branchID }}</td>
                <td>{{ App\Http\Controllers\ItemController::showDetails($value->itemID)->name }}</td>
                <td>{{ $value->quantity }}</td>
                <td>{{ $value->lowStockLevel }}</td>
                <td><input type="number" name="branchQuantity[]" class="form-control" /></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
    <div style="text-align:right">   
    <!--To Sang: Mannual Mapping Method Here with back()->with('success','Succeefully')-->
    <button class="btn btn-small" style="display:inline">{{ Form::submit('Submit',array('class' => 'btn btn-primary')) }}</button></div>

   <span onclick="history.back()" style="font-size:25px; cursor: pointer;">
  <i class="fas fa-arrow-circle-left"></i>
Return
</span>

    {{ Form::close() }}


@endsection
