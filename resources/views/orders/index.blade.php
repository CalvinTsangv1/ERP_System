@extends('layout')
<!-- Child content section -->
@section('content')
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Registration Number</th>
                <th>Registration State</th>
                <th>Customer Name</th>
                <th>Customer Phone</th>
                <th>Vehicle Brand</th>
                <th>Vehicle Model</th>
                <th>Vehicle Year</th>
                <th>Vehicle Serial Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $key => $value)
            <tr>
                <td><a href="{{ route('orders.show', $value->orderid)}}">{{ $value->regno }}</a></td>
                <td>{{ $value->regstate }}</td>
                <td>{{ $value->custname }}</td>
                <td>{{ $value->custphone }}</td>
                <td>{{ $value->vehbrand }}</td>
                <td>{{ $value->vehmodel }}</td>
                <td>{{ $value->vehyear }}</td>
                <td>{{ $value->serialno }}</td>
                <!-- we will also add show, edit, and delete buttons -->
                <td>
                    <!-- delete the order (uses the destroy method DESTROY /orders/{id} -->
                    <!-- we will add this later since its a little more complicated than the other two buttons -->
                    <form action="{{ route('orders.destroy', $value->orderid)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-small btn-danger" type="submit">Delete Order</button>
                    </form>
                            <!-- Show the order (uses the show method found at GET /orders/{id} -->
                    <a class="btn btn-small btn-success" href="{{ URL::to('orders/'.$value->orderid) }}">Show this Order</a>
                    <!-- Edit this order (uses the edit method found at GET /orders/{id}/edit -->
                    <a class="btn btn-small btn-info" href="{{ URL::to('orders/'.$value->orderid.'/edit') }}">Edit this Order</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection