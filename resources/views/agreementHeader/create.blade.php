@extends('layout')
<!-- Child content section -->
@section('content')

    <h1 style="text-align:left">Create Agreement</h1>
    </br>
    {!! Form::open(['action' =>'AgreementHeaderController@storeWithDetails', 'method'=> 'POST','files'=>true , 'style'=>'width:1000px;'])!!}
        <div class="row">
            <div class="col-4 text-right">{{ Form::label('agreementID', 'Agreement ID') }}</div>
            <div class="col-4"> {{ Form::text('agreementID', $checkAgreementID->agreementID+1, array('class' =>'form-control','readonly')) }}</div>
        </div>
        <div class="row">
            <div class="col-4 text-right">{{ Form::label('revision', 'Revision') }}</div>
            <div class="col-4"> {{ Form::text('revision', 1, array('class' =>'form-control','readonly')) }}</div>
        </div>
        <div class="row">
            <div class="col-4 text-right"> {{ Form::label('supplierID', 'Supplier Name') }}</div>
            <div class="col-4">   {{ Form::select('supplierID', $supplier, null, array('class' =>'form-control', 'placeholder'=>'Select Supplier')) }}</div>
        </div>
        <div class="row">
            <div class="col-4 text-right"> {{ Form::label('type', 'Agreement Type') }}</div>
            <div class="col-4">  {{ Form::select('type', $agreementType, null, array('class' =>'form-control', 'placeholder'=>'Select Agreement Type')) }}</div>
        </div>
        <div class="row">
            <div class="col-4 text-right">{{ Form::label('createdDate', 'Create Date ') }}</div>
            <div class="col-4">   {{ Form::date('createdDate',  \Carbon\Carbon::now() , array('class' =>'form-control')) }}</div>
        </div>
        <div class="row">
            <div class="col-4 text-right">{{ Form::label('effectiveDate', 'Effective Date ') }}</div>
            <div class="col-4">  {{ Form::date('effectiveDate',  \Carbon\Carbon::now() , array('class' =>'form-control')) }}</div>
        </div>
        
        <div class="row">
            <div class="col-4 text-right">    {{ Form::label('expiryDate', 'Expiry Date') }}</div>
            <div class="col-4">      {{ Form::date('expiryDate',  null , array('class' =>'form-control')) }}</div>
        </div>
        <div class="row">
            <div class="col-4 text-right"> {{ Form::label('amountAgreed', 'Amount Agreed') }}</div>
            <div class="col-4">   {{ Form::text('amountAgreed',  null , array('class' => 'form-control')) }}</div>
        </div>
        <div class="row">
            <div class="col-4 text-right">    {{ Form::label('currency', 'Currency ') }}</div>
            <div class="col-4">    {{ Form::select('currency', array('HKD' => 'HKD', 'CNY' => 'CNY', 'USD' => 'USD') , null, array('class' =>'form-control')) }}</div>
        </div>
        <div class="row">
            <div class="col-4 text-right">{{ Form::label('termsAndCondition', 'Terms and Condition') }}</div>
            <div class="col-4">    {{ Form::text('termsAndCondition', null, array('class' =>'form-control')) }}</div>
        </div>
        
        <div class="row">
            <div class="col-4 text-right">    {{ Form::label('tentativeSchedule', 'Tentative Schedule') }}</div>
            <div class="col-4">     {{ Form::select('tentativeSchedule', array('Daily'=>'Daily', 'Weekly'=>'Weekly', 'Monthly'=>'Monthly', 'Bi-monthly'=>'Bi-monthly', 'Quarterly'=>'Quarterly', 'Half-yearly'=>'Half-yearly') , null, array('class' =>'form-control', 'placeholder'=>'Select a Tentative Schedule for PPA')) }}</div>
        </div>
        <div class="row">
            <div class="col-4 text-right"> {{ Form::label('deliveryAddress', 'Delivery Address') }}</div>
            <div class="col-4">       {{ Form::text('deliveryAddress', App\Http\Controllers\BranchController::getBranchName(5)->address , array('class' =>'form-control')) }}</div>
        </div>
        </br>
        
        <div class="card">
            <div class="card-header">
                <span style="font-size:20px;">Agreement Line</span>
            </div>
            <div class="card-body">
                <table class="table" id="items_table">
                     <thead class="thead-light" style="font-size:15px;">
                        <tr style="white-space: nowrap;">
                            <th>Item</th>
                            <th>Promised Qty</th>
                            <th>Minimum Order Qty</th>
                            <th>Listed Price</th>
                            <th style="display:none;">Price Break</th>
                            <th>Reference</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="item0">
                            <td style="width=100px">
                                {{ Form::select('itemID[]', $itemName, null, array('class' => 'form-control', 'placeholder'=>'Select an item')) }}
                            </td>
                            <td><input type="number" name="promisedQuantity[]" class="form-control" min="0" max="99999999"/></td>
                            <td><input type="number" name="minimumOrderQuantity[]" class="form-control" min="0" max="99999999"/></td>
                            <td><input type="number" name="price[]" class="form-control" min="0" max="99999999"/></td>
                            <td style="display:none;"><input type="number" name="priceBreak[]" class="form-control" max="1" step="0.05" min="0.00" /></td> <!-- Please modify -->
                            <td><input type="text" name="reference[]" class="form-control" /></td>
                        </tr>
                        <tr id="item1"></tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>
                                <button id="add_row" class="btn pull-left btn-primary"><i class="fas fa-plus"></i></button>
                                <button id='delete_row' class="btn pull-right btn-secondary delete_row"><i class="fas fa-minus"></i></button>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
        </br>
        <div class="form-group text-right">
            {{ Form::submit('Create', array('class' => 'btn btn-primary')) }}
        </div>
    {{ Form::close() }}
@endsection