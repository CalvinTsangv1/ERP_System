@extends('layout')
<!-- Child content section -->
@section('content')

   <h2>
       Auto
    </h2>
    <div class="text-right">
         <a href="{{ URL::to('mapPurchaseRequest/manual') }}"class="btn btn-outline-info" >Change to Manual</a>
    </div>
   </br>
    <table class="table table-striped table-bordered">
                <div class="card-header">Purchase Request – Pending to Mapping
        </div>   
        <thead>
            <tr>
                <th>Request ID </th>
                <th>Branch </th>
                <th>Created Date</th>
            </tr>
        </thead>
       <tbody>
           @foreach(App\Http\Controllers\PurchaseRequestController::getPendingRequest() as $key =>$value )
            <tr>
               
                <td>{{$value->requestID}}</td>
                <td>{{App\Http\Controllers\BranchController::getBranchName($value->branchID)->name}}</td>
                <td>{{$value->createdDate}}</td>
               
            </tr>
       @endforeach
        </tbody>
   </table>
   <div style="text-align:center">
       
          <!--To Sang: Put the Auto-Mapping Method Here and return back()-with('success','Succeefully')-->
       <a href="{{ action('AutomationPurchaseRequestMappingController@buttonClick')}}" class="btn btn-outline-success"> Start</a>

       
      

    </div>   
@endsection