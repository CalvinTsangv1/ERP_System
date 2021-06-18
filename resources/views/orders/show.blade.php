@extends('layout')

@section('content')
<h1>Showing {{ $order->regno }}</h1>
<div class="jumbotron text-center">
  <p>Registration Number: {{ $order->regno }}</p>
  <p>Registration State: {{ $order->regstate }}</p>
  <p>Customer Name: {{ $order->custname }}</p>
  <p>Customer Phone: {{ $order->custphone }}</p>
  <p>Vehicle Brand: {{ $order->vehbrand }}</p>
  <p>Vehicle Model: {{ $order->vehmodel }}</p>
  <p>Vehicle Year: {{ $order->vehyear }}</p>
  <p>Vehicle Serial Number: {{ $order->serialno }}</p>
</div>
@endsection