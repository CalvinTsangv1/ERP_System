@extends('layout')
<!-- Child content section -->
@section('content')
<div >
    <h1>Agreement Index</h1>
    </br>
    <table class="table table-striped table-bordered">
        <thead>
            <tr style="white-space:nowrap;">
                <th>ID</th>
                <th>Revision</th>
                <th>Agreement Type</th>
                <th>Supplier</th>
                <th>Effective Date</th>
                <th>Expiry Date</th>
                <th>Status</th>
                <th style="text-align:center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agreementHeader as $key => $value)
            
            
        
                <tr style="white-space:nowrap;">
                    <td>{{ $value->agreementID }}</td>
                    <td>{{ $value->revision }}</td>
                    <td>{{ $value->type }}</td>
                    <td style="white-space: pre-line">{{ App\Http\Controllers\SupplierController::getSupplierName($value->supplierID)->name }}</td>
                    <td>{{ $value->effectiveDate }}</td>
                    <td>{{ $value->expiryDate }}</td>
                    <td>{{ $value->status }}</td>
                    <td style="white-space:nowrap;">
                        <!-- Show the order (uses the show method found at GET /orders/{id} -->
                        <a class="btn btn-small btn-success" href="{{ route('agreementHeader.show', ['agreementID'=>$value->agreementID, 'revision'=>$value->revision]) }}" style="display:inline"><i class="fas fa-eye"></i></a>
                        <!-- Edit this order (uses the edit method found at GET /orders/{id}/edit -->
                        <a class="btn btn-small btn-info" href="{{ route('agreementHeader.edit', ['agreementID'=>$value->agreementID, 'revision'=>$value->revision]) }}" style="display:inline"><i class="fas fa-edit"></i></a>
                        <!-- Please amend the 'DELETE', just update the status as 'Disabled'-->
                        <a class="btn btn-small btn-danger" href="{{ route('agreementHeader.disable', ['agreementID'=>$value->agreementID, 'revision'=>$value->revision]) }}" style="display:inline">Disable</a>
                    </td>
                </tr>
               
            @endforeach
        </tbody>
   </table>
</div>   
@endsection