@extends('layout')
<!-- Child content section -->
@section('content')

<h1>Purchase Request Index</h1>
</br>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Request ID</th>
            <th>Branch Name</th>
            <th>Status</th>
            <th>Created Date</th>
            <th>Remarks</th>
            <th style="text-align:center">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($purchaseRequest as $key => $value)
            <tr>
                <td>{{ $value->requestID }}</td>
                <td>{{ App\Http\Controllers\BranchController::getBranchName($value->branchID)->name }}</td>     <!-- Branch Name is better "Done" -->
                <td>{{ $value->status }}</td>
                <td>{{ $value->createdDate }}</td>
                <td>{{ $value->remarks }}</td>
                <!-- we will also add show, edit, and delete buttons -->
                <td style="text-align:center">
                    <!-- Show the order (uses the show method found at GET /orders/{id} -->
                    <a class="btn btn-small btn-outline-success" href="{{ URL::to('purchaseRequest/'.$value->requestID.'/showDetails')}}" style="display:inline"><i class="fas fa-eye"></i></a>
                    <!-- Edit this order (uses the edit method found at GET /orders/{id}/edit -->
                    <a class="btn btn-small btn-outline-primary" href="{{ URL::to('purchaseRequest/'.$value->requestID.'/edit') }}" style="display:inline"><i class="fas fa-edit"></i></a>
                    <!-- delete the order (uses the destroy method DESTROY /orders/{id} -->
                    <!-- we will add this later since its a little more complicated than the other two buttons -->
                    <form action="{{ route('purchaseRequest.destroy', $value->requestID)}}" method="post" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-small btn-outline-danger" type="submit" ><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection