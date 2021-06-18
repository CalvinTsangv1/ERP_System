@extends('layout')

@section('content')
<span onclick="history.back()" style="font-size:25px; cursor: pointer;">
    <i class="fas fa-arrow-circle-left"></i>
    Back
</span>
</br>
</br>
<div style="text-align:left;">
    <h1>View Inventory</h1>
    </br>
    <h2>Branch ID: {{ $branchItem[0]['branchID'] }}</h2>
    <h2>Branch Name: {{ App\Http\Controllers\BranchController::getBranchName($branchItem[0]['branchID'])['name'] }} </h2>
</div>
</br>
<table class="table table-striped table-bordered table-hover results">
    <thead>
        <tr style="white-space:nowrap; text-align: center">
            <th>Item ID</th>  
            <th>Virtual ID</th>
            <th>Item Name</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        @foreach($branchItem as $key=> $value)
            <tr style="white-space:nowrap;">
                <td>{{ $value->itemID }}</td>
                <td>{{ App\Http\Controllers\ItemController::showDetails($value->itemID)->virtualItemID }}</td>
                <td>{{ App\Http\Controllers\ItemController::showDetails($value->itemID)->name }}</td>
                <td>{{ App\Http\Controllers\ItemCategoryController::getCategoryName(App\Http\Controllers\ItemController::showDetails($value->itemID)->categoryID)->categoryName }}</td>
                <td style="text-align:right">{{ number_format($value->quantity)  }}</td>
                <td style="text-align:right">{{ App\Http\Controllers\ItemController::showDetails($value->itemID)->unitOfMeasurement }}</td>
                <td>{{ App\Http\Controllers\ItemController::showDetails($value->itemID)->description }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection