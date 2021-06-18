@extends('layout')
<!-- Child content section -->
@section('content')
<h1>Delivery Note Index</h1>
</br>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th style="text-align:center">Delivery Note No.</th>
            <th style="text-align:center">Dispatch Instruction No.</th>
            <th style="text-align:center">Created Date</th>
            <th style="text-align:center">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($deliveryNote as $key => $value)
            <tr>
                <td style="text-align:center">{{ $value->dnNo }}</td>
                <td style="text-align:center">{{ $value->diNo }}</td>
                <td style="text-align:center">{{ $value->createdDate }}</td>
                <td style="text-align:center">{{ $value->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection