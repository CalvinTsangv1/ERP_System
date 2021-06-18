@extends('layout')
<!-- Child content section -->
@section('content')

   <h2>
      Dispatch  Instruction 
    </h2>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th style="text-align:center">DI No.</th>
                <th style="text-align:center">Request ID</th>
                <th>Branch</th>
                <th style="text-align:center">Created Date</th>
                <th style="text-align:center">Status</th>
                <th style="text-align:center">Actions</th>
            </tr>
        </thead>
       <tbody>
            @foreach($dispatchInstruction as $key => $value)
            <tr>
                <td style="text-align:center">{{ $value->diNo }}</td>
                <td style="text-align:center">{{ $value->requestID}}</td>
                <td>{{ App\Http\Controllers\BranchController::getBranchName(App\Http\Controllers\PurchaseRequestController::getRequest($value->requestID)->branchID)->name }}</td>
                <td style="text-align:center">{{ $value->createdDate }}</td>
                <td style="text-align:center">{{ $value->status }}</td>
                <td style="text-align:center">
                
                <a class="btn btn-small btn-outline-success" href="{{route('dispatchInstruction.showDetails',$value->diNo)}}" style="display:inline"><i class="fas fa-eye"></i></a>
                <a class="btn btn-small btn-outline-secondary" href="{{URL::to('deliveryNote/create/'.$value->diNo)}}" style="display:inline">Create Delivery Note</a>
                </td>
            </tr>
            @endforeach
        </tbody>
   </table>
@endsection