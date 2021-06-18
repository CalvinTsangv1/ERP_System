@extends('layout')

@section('content')
<h1>Set Requested Items Period</h1>
<div class="jumbotron text-left" style="padding:20px">
    {!! Form::open([ 'action'=>'setRecentRequestPeriodController@findPurchaseRequest','method' => 'POST','files'=>true])!!}
    <table name="AgreementHeader">
        <tr>
            <th>From :</th>
            <td style="padding-left:200px">{{ Form::date('from', '2020-01-01' , array('class' => 'form-control')) }}</td>
        </tr>
        <tr>
            <th>To :</th>
            <td style="padding-left:200px">{{ Form::date('to', \Carbon\Carbon::now() , array('class' => 'form-control')) }}</td>
            </br>
        </tr>
    </table>
    <div class="form-group text-right">{{ Form::submit('Save', array('class' =>'btn btn-primary')) }}</div>
    </div>
</div>
@endsection