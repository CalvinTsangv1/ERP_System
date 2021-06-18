@extends('layout')

@section('content')
<h1>Set Requested Items Period</h1>
{{Form::open([ 'method'=> 'POST','files'=>true])}}
<div class="jumbotron text-left" style="padding:20px">
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
    <table class="table table-striped table-bordered">
        <h1>Recent Purchase Request Item</h1>
        <thead>
            <tr>
                <th>Created Date</th>
                <th>Request ID</th>
                <th>Item Name</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
             @foreach($purchaseRequestResult as $value)
            <tr>
                <td>{{ $value[0] }}</a></td>
                <td>{{ $value[1] }}</td>
                <td>{{ $value[2] }}</td>
                <td>{{ $value[3] }}</td>
            </tr>
             @endforeach
        </tbody>
    </table>
</div>
@endsection