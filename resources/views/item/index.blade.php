@extends('layout')
<!-- Child content section -->
@section('content')
<h1>Item Index</h1>
<div class="form-group pull-left">
    <input type="text" class="search form-control" placeholder="Search here..." >
</div>
<span class="counter pull-left"></span>

<table class="table table-hover table-bordered results" id="myTable">
    <thead>
        <tr>
            <th>Item ID</th>
            <th>Virtual Item ID</th>
            <th>Item Name</th>
            <th style="text-align:center">Actions</th>
        </tr>
        <tr class="warning no-result">
            <td colspan="4"><i class="fa fa-warning"></i>No result</td>
        </tr>
    </thead>
    <tbody>
        @foreach($item as $key => $value)
            <tr>
                <td>{{ $value->itemID }}</td>
                <td>{{ $value->virtualItemID }}</td>
                <td><a href="{{ route('item.show',$value->itemID) }}">{{ $value->name }}</td>
                <td style="text-align:center">
                    <!-- Show the order (uses the show method found at GET /orders/{id} -->
                    <a class="btn btn-small btn-outline-success" href="{{ route('item.show',$value->itemID) }}" style="display:inline"><i class="fas fa-eye"></i></a>
                    <!-- Edit this order (uses the edit method found at GET /orders/{id}/edit -->
                    <a class="btn btn-small btn-outline-primary" href="{{ URL::to('item/'.$value->itemID.'/edit') }}" style="display:inline"><i class="fas fa-edit"></i></a>
                    <!-- delete the order (uses the destroy method DESTROY /orders/{id} -->
                    <!-- we will add this later since its a little more complicated than the other two buttons -->
                    <form action="{{ route('item.destroy', $value->itemID)}}" method="post" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-small btn-outline-danger" type="submit" style="display:inline;"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>

 
$(".search").keyup(function () {
    var searchTerm = $(".search").val();
    var listItem = $('.results tbody').children('tr');
    var searchSplit = searchTerm.replace(/ /g, "'):containsi('")
    
  $.extend($.expr[':'], {'containsi': function(elem, i, match, array){
        return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
    }
  });
    
  $(".results tbody tr").not(":containsi('" + searchSplit + "')").each(function(e){
    $(this).attr('visible','false');
  });

  $(".results tbody tr:containsi('" + searchSplit + "')").each(function(e){
    $(this).attr('visible','true');
  });

  var jobCount = $('.results tbody tr[visible="true"]').length;
    $('.counter').text(jobCount + ' item');

  if(jobCount == '0') {$('.no-result').show();}
    else {$('.no-result').hide();}
		  });
</script>
@endsection
