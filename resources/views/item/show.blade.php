@extends('layout')

@section('content')
<span onclick="history.back()" style="font-size:25px; cursor: pointer;">
  <i class="fas fa-arrow-circle-left"></i>
  Back
</span>
</br>
</br>
<h1>View Item</h1>
<div class="jumbotron text-left" style="font-size:2em">
  <p>Item ID: {{ $item->itemID }}</p>
  <p>Virtual Item ID: {{ $item->virtualItemID }}</p>
  <p>Category: {{ App\Http\Controllers\ItemCategoryController::getCategoryName($item->categoryID)->categoryName }}</p> <!-- Give me the category name"Done" -->
  <p>Item Name: {{ $item->name }}</p>
  <p>Unit of Measurement: {{ $item->unitOfMeasurement }}</p>
  <p>Description: {{ $item->description }}</p>
</div>
@endsection