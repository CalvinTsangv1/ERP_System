@extends('layout')

@section('content')
<span onclick="history.back()" style="font-size:25px; cursor: pointer;">
    <i class="fas fa-arrow-circle-left"></i>
    Back
</span>
</br>
</br>
<h1>Agreement Information</h1>
</br>
<div class="jumbotron text-left" style="padding:20px">
    <table name="AgreementHeader">
        <tr>
            <th>Agreement ID:</th>
            <td style="padding-left:200px">{{ $agreementHeader->agreementID }}</td>
        </tr>
        <tr>
            <th>Revision:</th>
            <td style="padding-left:200px">{{ $agreementHeader->revision }}</td>
        </tr>
        <tr>
            <th>Supplier ID:</th>
            <td style="padding-left:200px">{{ $agreementHeader->supplierID }}</td>
        </tr>
        <tr>
            <th>Agreement Type:</th>
            <td style="padding-left:200px">{{ $agreementHeader->type }}</td>
        </tr>
        <tr>
            <th>Created Date:</th>
            <td style="padding-left:200px">{{ $agreementHeader->createdDate }}</td>
        </tr>
        <tr>
            <th>Effective Date:</th>
            <td style="padding-left:200px">{{ $agreementHeader->effectiveDate }}</td>
        </tr>
        <tr>
            <th>Expiry Date:</th>
            <td style="padding-left:200px">{{ $agreementHeader->expiryDate }}</td>
        </tr>
        <tr>
            <th>Status:</th>
            <td style="padding-left:200px">{{ $agreementHeader->status }}</td>
        </tr>
        <tr>
            <th>Amount Agreed:</th>
            <td style="padding-left:200px">{{ $agreementHeader->amountAgreed }}</td>
        </tr>
        <tr>
            <th>Currency:</th>
            <td style="padding-left:200px">{{ $agreementHeader->currency }}</td>
        </tr>
        <tr>
            <th>Terms and Condition:</th>
            <td style="padding-left:200px">{{ $agreementHeader->termsAndCondition }}</td>
        </tr>
        <tr>
            <th>Tentative Schedule:</th>
            <td style="padding-left:200px">{{ $agreementHeader->tentativeSchedule }}</td>
        </tr>
        <tr>
            <th>Delivery Address:</th>
            <td style="padding-left:200px">{{ $agreementHeader->deliveryAddress }}</td>
        </tr>
    </table>
</div>
<div>
    <h1  style="text-align:Left;">Agreement Line</h1>
    </br>
    <table name="AgreementLine" class="table table-striped table-bordered">
        <thead>
            <tr style="text-align: center;">
                <th>Item ID</th>
                <th>Item Name</th>
                <th>Promised Quantity</th>
                <th style="text-align: center;">Minimum Order Quantity</th>
                <th>Balance</th>
                <th>Listed Price</th>
                <th>Price Break:Discount</th>
                <th>Reference</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agreementLine as $key =>$value)
            <tr>
                <td style="text-align: center;">{{ $value->itemID }}</td>
                <td style="text-align: left;">{{ App\Http\Controllers\ItemController::showDetails($value->itemID)->name }}</td>
                <td style="text-align: right;">{{ $value->promisedQuantity }}</td>
                <td style="text-align: right;">{{ $value->minimumOrderQuantity }}</td>
                <td style="text-align: right;">{{ $value->balance }}</td>
                <td style="text-align: right;">{{ $value->price }}</td>
                <td style="text-align: center;">{{ App\Http\Controllers\AgreementPriceBreakController::getPriceBreakByItemID($agreementHeader->agreementID,$value->itemID) }}
                <a href="{{ route('agreementPriceBreak.edit', ['agreementID'=>$agreementHeader->agreementID, 'revision'=>$agreementHeader->revision , 'itemID'=>$value->itemID]) }}">
                    <i class="far fa-edit"></i></a></td>
                <td style="text-align: left;">{{ $value->reference }}</td>
            </tr>
            @endforeach
        </tbody>
        
    </table>
</div>
@endsection