@extends('layout')
<!-- Child content section -->
@section('content')
<h1>Category Index</h1>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Category ID</th>
            <th>Category Name</th>
            <th>Path</th>
            <th style="text-align:center">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($itemCategory as $key => $value)
            <tr>
                <td style="text-align:center"><a href="{{ route('itemCategory.show',$value->categoryID)}}">{{ $value->categoryID }}</td>
                <td><a href="{{ route('itemCategory.show',$value->categoryID)}}">{{ $value->categoryName }}</td>
                <td>{{ App\Http\Controllers\ItemCategoryController::getParentItemCategoryIDList($value->parentCategoryID )}}</td> <!-- Give me the path "done"-->
                <td style="text-align:center ;  white-space: nowrap;">
                    <!-- Show the order (uses the show method found at GET /orders/{id} -->
                    <a class="btn btn-small btn-success" href="{{ route('itemCategory.show',$value->categoryID) }}" style="display:inline"><i class="fas fa-eye"></i></a>
                    <!-- Edit this order (uses the edit method found at GET /orders/{id}/edit -->
                    <a class="btn btn-small btn-info" href="{{ URL::to('itemCategory/'.$value->categoryID.'/edit') }}" style="display:inline"><i class="fas fa-edit"></i></a>
                    <!-- delete the order (uses the destroy method DESTROY /orders/{id} -->
                    <!-- we will add this later since its a little more complicated than the other two buttons -->
                    <form action="{{ route('itemCategory.destroy', $value->categoryID)}}" method="post" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-small btn-danger" type="submit" style="display:inline"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection