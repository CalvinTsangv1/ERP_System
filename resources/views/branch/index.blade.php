@extends('layout')
<!-- Child content section -->
@section('content')
<h1>Branch Index</h1>
<table class="table table-striped table-bordered table-hover results">
    <thead>
        <tr>  
            <th style="width:50px; text-align:center">Branch ID</th>
            <th style="width:150px">Branch Name</th>
            <th style="width:20px; text-align:center">View Branch Inventory</th>
        </tr>
    </thead>
    <tbody>
        @foreach($branch as $key => $value)
            <tr>
                <td style="text-align:center">{{ $value->branchID }}</td>
                <td>{{ $value->name }}</td>
                <td style="text-align:center">
                    <?php
                    
                    if($value->branchID >4){
                           echo '<a id="checkInventory" class="btn btn-small btn-success" href="'. URL::to('branchItem', $value->branchID ).
                           '" style="display:inline; "><i class="fas fa-eye"></i></a>';
                    }else{
                         echo '/';
                    }
                    ?>    
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
