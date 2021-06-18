@extends('layout')
@section('content')

       
<h1>Edit Agreement</h1>
{{Form::open(['action' =>['AgreementHeaderController@update',$agreementHeader->agreementID], 'method'=> 'PUT','files'=>true,'style'=>'width:1000px;margin-left:auto;margin-right:auto;'])}}

<div class="jumbotron" style="padding:20px">
    <table name="AgreementHeader" style="font-size: 1.5em">
        <tr>
            <th>Agreement ID:</th>
            <td>{{ Form::text('agreementID', $agreementHeader->agreementID, array('class' =>'form-control','readonly')) }}</td>
        </tr>
        <tr>
            <th>Revision:</th>
            <td>{{ Form::text('revision',  $agreementHeader->revision, array('class' =>'form-control','readonly')) }}</td>
        </tr>
        <tr>
            <th>Supplier:</th>
            <td>{{ Form::select('supplierID', $supplier, $agreementHeader->supplierID, array('class' =>'form-control')) }}</td>
        </tr>
        <tr>
            <th>Agreement Type:</th>
            <td>{{ Form::select('type', $agreementType,$agreementHeader->type, array('class' =>'form-control')) }}</td>
        </tr>
        <tr>
            <th>Created Date:</th>
            <td>{{ Form::date('createdDate',  $agreementHeader->createdDate , array('class' =>'form-control')) }}</td>
        </tr>
        <tr>
            <th>Effective Date:</th>
            <td>{{ Form::date('effectiveDate', $agreementHeader->effectiveDate , array('class' =>'form-control')) }}</td>
        </tr>
        <tr>
            <th>Expiry Date:</th>
            <td>{{ Form::date('expiryDate',  $agreementHeader->expiryDate , array('class' =>'form-control')) }}</td>
        </tr>
        <tr>
            <th>Status:</th>
            <td>{{ Form::select('status', ['Active'=>'Active','Inactive'=>'Inactive','Expired'=>'Expired','Superseded'=>'Superseded','Disabled'=>'Disabled'] ,$agreementHeader->status , array('class' =>'form-control')) }}</td>
        </tr>
        <tr>
            <th>Amount Agreed:</th>
            <td>{{ Form::text('amountAgreed',  $agreementHeader->amountAgreed , array('class' =>'form-control')) }}</td>
        </tr>
        <tr>
            <th>Currency:</th>
            <td>{{ Form::select('currency',  array('HKD' =>'HKD','CNY' =>'CNY','USD' =>'USD') ,$agreementHeader->currency, array('class' =>'form-control')) }}</td>
        </tr>
        <tr>
            <th>Terms And Condition:</th>
            <td>{{ Form::text('termsAndCondition',  $agreementHeader->termsAndCondition , array('class' =>'form-control')) }}</td>
        </tr>
        <tr>
            <th>Tentative Schedule:</th>
            <td>{{ Form::select('tentativeSchedule', array('Daily'=>'Daily', 'Weekly'=>'Weekly', 'Monthly'=>'Monthly', 'Bi-monthly'=>'Bi-monthly', 'Quarterly'=>'Quarterly', 'Half-yearly'=>'Half-yearly'), $agreementHeader->tentativeSchedule , array('class' =>'form-control', 'placeholder'=>'Select a Tentative Schedule for PPA')) }}</td>
        </tr>
        <tr>
            <th>Delivery Address:</th>
            <td>{{ Form::text('deliveryAddress',  App\Http\Controllers\BranchController::getBranchName(5)->address , array('class' =>'form-control')) }}</td>
        </tr>
    </table>
</div>

<div class="card"  >
    <div class="card-header ">
        <span style="font-size:20px;">Agreement Line </span>
    </div>
    <div class="card-body">
        <table class="table" id="items_table">
             <thead class="thead-light">
                <tr style="white-space: nowrap; font-size:15px;">
                    <th>Action</th>
                    <th>Item </th>
                    <th>Promised Qty</th>
                    <th>Mini-Order Qty</th>
                    <th>Price</th>
                   
                    <th>Reference</th>
                </tr>
            </thead>
            <tbody >
                <tr id="item0">
                    <td ><button id="btn-delete_row" class="btn btn-outline-danger delete_row" style="font-size:15x;" onclick=""><i class="fas fa-times" ></i></button></td>
                    <td style="width:150px">
                        {{ Form::select('itemID[]',$itemName+['select item'=>'select item'], 'select item', array('class' => 'form-control')) }}
                    </td>
                    <td><input type="number" name="promisedQuantity[]" class="form-control" /></td>
                    <td><input type="number" name="minimumOrderQuantity[]" class="form-control" /></td>
                    <td><input type="number" name="price[]" class="form-control" /></td>
                   
                    <td><input type="text" name="reference[]" class="form-control" /></td>
                </tr>
                <tr id="item1"></tr>
            </tbody>
        </table>
        <div >
            <span >
                <button id="add_row" class="btn pull-left btn-primary"><i class="fas fa-plus"></i></button>
                <button id='delete_row' class="btn pull-right btn-secondary delete_row"><i class="fas fa-minus"></i></button>
            </span>
        </div>
    </div>
</div>
</br>


    <div class="form-group text-right">
    {{ Form::submit('Save', array('class' =>'btn btn-primary')) }}
    </div>


@endsection