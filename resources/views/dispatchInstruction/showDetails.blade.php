@extends('layout')
<!-- Child content section -->
@section('content')
<div>
    <h1>Dispatch Instruction Details</h1>
    <table name="AgreementHeader" class="table table-striped table-bordered table-hover results">
        <tr>
            <th>
                Dispatch Instruction No.
            </th>
                <td style="padding-left:200px">
                    {{ $dispatchInstruction->diNo }}
                </td>
        </tr>
        <tr>
            <th>
                Request ID
            </th>
            <td style="padding-left:200px"> 
                {{ $dispatchInstruction->requestID }}
            </td>
        </tr>
        <tr>
            <th>
                Branch
            </th>
                <td style="padding-left:200px">
                    {{ App\Http\Controllers\BranchController::getBranchName(App\Http\Controllers\PurchaseRequestController::getRequest($dispatchInstruction->requestID)->branchID)->name }}
                </td>
        </tr>
        <tr>
            <th>
                Created Date
            </th>
            <td style="padding-left:200px">
                {{ $dispatchInstruction->createdDate }}
            </td>
        </tr>
        <tr>
            <th>
                Status
            </th>
            <td style="padding-left:200px">
                {{ $dispatchInstruction->status }}
            </td>
        </tr>
    </table>
</div>

<div>
    <h1>
        Dispatch Instruction Item
    </h1>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Virtual Item ID</th>
                <th>Item Name</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dispatchInstructionItem as $key => $value)
            <tr>
                <td>{{ App\Http\Controllers\ItemController::showDetails($value->itemID)->virtualItemID }}</td>
                <td>{{ App\Http\Controllers\ItemController::showDetails($value->itemID)->name }}</td>
                <td>{{ $value->quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<hr>
@endsection