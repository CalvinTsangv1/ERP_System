@extends('layout')
<!-- Child content section -->
@section('content')




            <div class="card-header">
                <h2>Agreement Price Break</h2>
            </div>

             
                <h1 style="text-align:center;padding :5px;"> ITEM : {{App\Http\Controllers\ItemController::showDetails($agreementPriceBreak->itemID)->name}}</h1>
          
            <div>
                
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                             <th>Price Break</th>
                            <th>Discount</th>
                           
                            <th style="text-align:center">Actions</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($agreementPriceBreakList as $key => $value)
                        <tr>
                            <td>{{ $value->priceBreak }}</td>
                   
                            <td>{{ $value->discount }}</td>
                            <td style="text-align:center">
                              
                                <!-- Edit this order (uses the edit method found at GET /orders/{id}/edit -->
                                 <form action="{{ route('agreementPriceBreak.destroy', ['agreementID'=>$value->agreementID,'revision'=>$value->revision,'itemID'=>$value->itemID,'priceBreak'=>$value->priceBreak])}}" method="get">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-small btn-outline-danger" type="submit">Delete</button>
                                </form>
                    
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
               </table>
            </div>
            <hr>
            {{Form::open([ 'action'=>'AgreementPriceBreakController@store', 'method'=> 'Get','files'=>true,'style'=>'width:500px;margin-left:auto;margin-right:auto;'])}}
              <div class="card-body">
                <table class="table" id="items_table">
                     <thead class="thead-light" style="font-size:15px;">
                        <tr style="white-space: nowrap;">
                            <th>Price Break</th>
                            <th>Discount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="item0">

                               <td style="display:none">
                                   {{ Form::label('agreementID', 'agreementID') }}
                                 {{ Form::number('agreementID[]',$agreementPriceBreak->agreementID, array('class' => 'form-control','readonly')) }}
                            </td>
                               <td style="display:none">
                                    {{ Form::label('revision', 'revision') }}
                                 {{ Form::number('revision[]', $agreementPriceBreak->revision, array('class' => 'form-control', 'readonly')) }}
                            </td>
                               <td style="display:none">
                                     {{ Form::label('itemID', 'itemID') }}
                                 {{ Form::number('itemID[]', $agreementPriceBreak->itemID, array('class' => 'form-control','readonly')) }}
                            </td>
                            <td style="width=100px">
                                {{ Form::number('priceBreak[]', 0, array('class' => 'form-control', 'max'=>'1000000', 'min'=>'0')) }}
                            </td>
                            <td>
                                 {{ Form::number('discount[]', 0, array('class' => 'form-control', 'max'=>'1.00', 'min'=>'0.00','step'=>'0.05')) }}
                            </td>
                        </tr>
                        <tr id="item1"></tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>
                                <button id="add_row" class="btn pull-left btn-primary"><i class="fas fa-plus"></i></button>
                                <button id='delete_row' class="btn pull-right btn-secondary delete_row"><i class="fas fa-minus"></i></button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="form-group text-right">
                {{ Form::submit('Save', array('class' =>'btn btn-primary')) }}
            </div>
         <hr >
            

{{ Form::close() }}
@endsection
