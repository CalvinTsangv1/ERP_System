@extends('layout')

@section('content')

<span onclick="history.back()" style="font-size:25px; cursor: pointer;">
  <i class="fas fa-arrow-circle-left"></i>
  Back
</span>
</br>
</br>
<h1>Category Information</h1>
<div class="jumbotron text-left" style="font-size:2em">
  <p>Category ID: {{ $itemCategory->categoryID }}</p>
  <p>Category Name: {{ $itemCategory->categoryName }}</p>
  <p>Path: {{ App\Http\Controllers\ItemCategoryController::getParentItemCategoryIDList($itemCategory->parentCategoryID )}}</p> <!-- Please reverse the path --> <!-- Done by Calvin -->
</div>
@endsection