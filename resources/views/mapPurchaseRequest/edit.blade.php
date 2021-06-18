@extends('layout')
<!-- Child content section -->
@section('content')
<h1>Update Purchase Order Status</h1>
</br>
{!! Form::open([ 'action'=>['Controller@method','parameter'],'method' => 'GET', 'files' => true]) !!}
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>PO Number</th>
                <th>Request ID</th>
                <th>Agreement ID</th>
                <th>Branch</th>
                <th>Marked as Completed</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchaseOrder as $key => $value)
                <tr>
                    <td>{{ Form::number('poNo', $value->poNo, array('class'=>'form-control', 'readonly', 'style'=>'border:0')) }}</td> <!-- Don't use the text box -->
                    <td>{{ $value->requestID }}</td>
                    <td>{{ $value->agreementID }}</td>
                    <td><!-- Give me the branch name --></td>
                    <td>{{ Form::select('status', $statusArray, $value->status, array('class'=>'form-control','id'=>'form-status')) }}</td> <!-- Only need to change as "Completed" -->
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="form-group text-right">
        {{ Form::submit('Save', array('class' =>'btn btn-outline-success change-po-status')) }}
    </div>
{{ Form::close() }}
@endsection