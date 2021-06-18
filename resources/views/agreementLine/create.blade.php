@extends('layout')
<!-- Child content section -->
@section('content')

   <h1 style="text-align:left"> Create Agreement Line </h1>
 
      {!! Form::open(['action' =>'AgreementLineController@store', 'method'=> 'POST','files'=>true,'style'=>'width:1000px' ])!!}
 
<!-- Detail Form -->
<div class="card"  >
    <div class="card-header ">
        <span style="font-size:20px;">Agreement Line </span>
    </div>
    <div class="card-body">
        <table class="table" id="items_table">
             <thead class="thead-light">
                <tr style="white-space: nowrap;">
                    <th>Action</th>
                    <th>Item </th>
                    <th>Promised Qty</th>
                    <th>Mini-Order Qty</th>
                    <th>Price</th>
                    <th>Price-Break</th>
                    <th>Reference</th>
                </tr>
            </thead>
            <tbody >
                <tr id="item0">
                    <td ><button id="btn-delete_row" class="btn btn-outline-danger delete_row" style="font-size:15x;" onclick=""><i class="fas fa-times" ></i></button></td>
                    <td style="display:none;"><input type="text" name="agreementID[]" class="form-control"  value="{{$latestAgreementIDAndRevision->agreementID}}"/></td>
                    <td style="display:none;"><input type="text" name="revision[]" class="form-control"  value="{{$latestAgreementIDAndRevision->revision}}"/></td>
                    <td style="width:150px">
                        {{ Form::select('itemID[]',$itemName+['select item'=>'select item'], 'select item', array('class' => 'form-control')) }}
                    </td>
                    <td><input type="number" name="promisedQuantity[]" class="form-control" /></td>
                    <td><input type="number" name="minimumOrderQuantity[]" class="form-control" /></td>
                    <td><input type="number" name="price[]" class="form-control" /></td>
                    <td><input type="number" name="priceBreak[]" class="form-control" /></td>
                    <td><input type="text" name="reference[]" class="form-control" /></td>
                </tr>
                <tr id="item1"></tr>
            </tbody>
        </table>
        <div >
            <span >
                <button id="add_row" class="btn pull-left btn-primary"><i class="fas fa-plus"></i></button>
                <button id='delete_row' class="btn pull-right btn-secondary delete_row"><i class="fas fa-minus"></i></button>
            </span>
        </div>
    </div>
</div>
</br>
<div class="row">
    <div class="col-4"></div>
    <div class="col-8 text-right">
       {{ Form::submit('Create the Agreement Line!', array('class' =>'btn btn-primary')) }}
    </div>
    <div class="col-4"></div>
</div>

{{ Form::close() }}
    

@endsection