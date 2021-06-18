<!DOCTYPE html> 
<html lang="en"> 
  <head> 
		<meta charset="UTF-8"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0">  
		<meta http-equiv="X-UA-Compatible" content="ie=edge"> 
		<title>IVE Resturant Group Ltd.</title> 
		
		<!--Function for generate more detail row in the detail form when use click add or delete row button-->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css" /> 
    <link href="{{asset('css/layout.css')}}" rel="stylesheet" type="text/css" />   
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" type="text/css" />
    <link rel="icon" type="image/png" href="{{asset('favicon.png')}}">
    
    <!--JavaScript for Bootstrap -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> 
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> 
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/esm/popper.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/app.js') }}" type="text/js"></script> 

		<script>
		 
	    $(document).ready(function(){
				let row_number = 1;
			    $("#add_row").click(function(e){
			      e.preventDefault();
			      let new_row_number = row_number - 1;
			      $('#item' + row_number).html($('#item' + new_row_number).html()).find('td:first-child');
			      $('#items_table').append('<tr id="item' + (row_number + 1) + '"></tr>');
			      row_number++;
			    });

  				$("#delete_row").click(function(e){
  				  e.preventDefault();
  				  if(row_number > 1){
  					$("#item" + (row_number - 1)).html('');
  				    row_number--;
  				  }
  				});
  			//test this function
  			$(".test").keyup(function(){
            $(".auto").val(this.value);
        });
 

  				$(".sidebar-dropdown a").click(function(e) {
  				  
  				  if($(this).parent().hasClass("active")){
  				      $(this).siblings('div').slideToggle(300);
  				      $(this).parent().toggleClass("active");

  				  }else{
  				     
  				      $(this).siblings('div').slideDown(300); //list on
  				    	$(this).parent().addClass("active");  //arrow on
  				    	$(this).parent().siblings("li").removeClass("active"); //sibling list off
  				    	$(this).parent().siblings('li').children("div").slideUp(300); //sibling arrow off
  				  }
          });
          
          // for Log-out button
          $("#logout-btn").click(function(){
            event.preventDefault();
            var check = confirm("Do you really want to logout?");
            if(check){ 
               $('#logout-form').submit();
            }
          });
          
          $("#close-sidebar").click(function() {
            $(".page-wrapper").removeClass("toggled");
          });
          $("#show-sidebar").click(function() {
            $(".page-wrapper").addClass("toggled");
          });
          
          
          // for View-Inventory Page
          $("#changeView").click(function(e) {
              if("{{Gate::allows('isAdmin')||Gate::allows('isPM')||Gate::allows('isCM')}}"){
                window.location.href="{{ URL::to('branch') }}";
              }else{ 
                window.location.href="{{ URL::to('branchItem')}}";
              }
          })
          
          // for welcome page
          var string = "Welcome to the Enterprise Resource Planning System";
          var str = string.split("");
          var el = document.getElementById('str');
          (function animate() {
            str.length > 0 ? el.innerHTML += str.shift() : clearTimeout(running);
            var running = setTimeout(animate, 90);
          })();
          
          // for search function
          // var $rows = $('.card #inventoryTable tr');
          // $('.card #search').keyup(function() {
          
          //     var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
          //         reg = RegExp(val, 'i'),
          //         text;
          
          //     $rows.show().filter(function() {
          //         text = $(this).text().replace(/\s+/g, ' ');
          //         return !reg.test(text);
          //     }).hide();
          // });
        
        
        
   
         $('#myTable').DataTable();
         
         var table = $('#example').DataTable();
 
          // #myInput is a <input type="text"> element
          $('#myInput').on( 'keyup', function () {
              table.search( this.value ).draw();
          } );
          
          $("#clickToSearch").click(function() {
             event.preventDefault();
             $("#displayResult").html('adssadsadas');
          });
         //  search function end
        


          
          
			});
		</script>

  </head> 
  <body>

    
    <div class="page-wrapper chiller-theme toggled">
      <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
        <i class="fa fa-bars"></i>
      </a>
      <nav id="sidebar" class="sidebar-wrapper">
        <div class="sidebar-content">
          <div class="sidebar-brand">
            <a class="navbar-brand" href="#" style="font-size:16px;">ERPS - Procurement</a> 
          <div id="close-sidebar">
            <i class="far fa-arrow-alt-circle-left"></i>
          </div>
          </div>
          <div class="sidebar-header">
            <div class="user-info">
              <span class="user-name">

                <strong> {{ ucfirst(trans( Auth::user()->name)) }}  </strong></a>
              </span>
              <span class="user-role"> {{ Auth::user()->postTitle }} </span>
              <span class="user-brand"> {{ App\Http\Controllers\BranchController::getBranchName(Auth::user()->branchID )->name}} </span>

            </div>
          </div>
          <!-- sidebar-header  -->

          <div class="sidebar-menu">
            <ul>

              <!--Menu Title: Order -->
           <!--@if(Gate::allows('isAdmin'))-->
           <!--   <li class="header-menu">-->
           <!--     <span>Order</span>-->
           <!--   </li>-->
              
           <!--   <li>-->
           <!--      <a class="nav-link" href="{{ URL::to('orders/') }}">-->
           <!--       <i class="fa fa-shopping-cart"></i>-->
           <!--       <span>View All Orders</span>-->
           <!--     </a>-->
           <!--   </li>-->
           <!--   <li >-->
           <!--     <a class="nav-link" href="{{ URL::to('orderdetails/') }}">-->
           <!--       <i class="fa fa-list-ol"></i>-->
           <!--       <span>View All Order Details</span>-->
           <!--     </a>-->
           <!--   </li>-->
              
           <!--   <li class="sidebar-dropdown">-->
           <!--     <a href="#">-->
           <!--       <i class="fa fa-chart-line"></i>-->
           <!--       <span id="testing">Manipulate Orders</span>-->
           <!--     </a>-->
           <!--      <div class="sidebar-submenu">-->
           <!--       <ul>-->
           <!--         <li>-->
           <!--          	<a  href="{{ URL::to('orders/create') }}" >Create New Order</a>-->
           <!--         </li>-->
           <!--         <li>-->
           <!--         	<a  href="{{ URL::to('orders/createorderwithdetails') }}">Create New Order with Details</a>-->
           <!--         </li>-->
           <!--       </ul>-->
           <!--     </div>-->
           <!--   </li>-->
           <!--   <li class="sidebar-dropdown">-->
           <!--     <a href="#">-->
           <!--       <i class="fa fa-chart-line"></i>-->
           <!--       <span>Manipulate Order Detail</span>-->
           <!--     </a>-->
           <!--      <div class="sidebar-submenu">   -->
           <!--       <ul>-->
           <!--         <li>-->
           <!--            <a href="{{ URL::to('orderdetails/create') }}">Create New Order Detail</a> -->
           <!--         </li>-->
           <!--       </ul>-->
           <!--     </div>-->
           <!--   </li>-->
           <!-- @endif  -->
            @if(Gate::allows('isAdmin') ||Gate::allows('isPM') )
              <!--Menu Title: Invertory -->
              <li class="header-menu">
                <span>Supplier</span>
              </li>
              <li class="sidebar-dropdown">
                <a href="#">
                  <i class="fa fa-chart-line"></i>
                  <span>Manage Supplier</span>
                </a>
                 <div class="sidebar-submenu">   
                  <ul>
                    <li>
                       <a  href="{{ URL::to('supplier/create') }}">Create Supplier</a> <!-- Add & Delete inventory within here -->
                    </li>
                    <li>
                       <a  href="{{ URL::to('supplier/') }}">View / Update / Disable Supplier</a> <!-- Add & Delete inventory within here -->
                    </li>
   
                  </ul>
                </div>
              </li>
              <li class="sidebar-dropdown">
                <a href="#">
                  <i class="fa fa-chart-line"></i>
                  <span>Manage Agreement</span>
                </a>
                 <div class="sidebar-submenu">   
                  <ul>
                    <li>
                       <a  href="{{ URL::to('agreementHeader/create') }}">Create Agreement</a> <!-- Add & Delete inventory within here -->
                    </li>
                    <li>
                       <a  href="{{ URL::to('agreementHeader/') }}">View / Update / Disable Agreement</a> <!-- Add & Delete inventory within here -->
                    </li>

                  </ul>
                </div>
              </li>
          @endif
           @if(Gate::allows('isAdmin') ||Gate::allows('isCM')||Gate::allows('isPM') ||Gate::allows('isRM') ||Gate::allows('isWC'))
              <!--Menu Title: Invertory -->
              <li class="header-menu">
                <span>Inventory</span>
              </li>
              
              <li >
                <a class="nav-link" href="#" id="changeView" >
                  <i class="fa fa-chart-line"></i>
                  <span>View Inventory</span>
                </a>
              </li>
              
              @if( Gate::denies('isPM') && Gate::denies('isRM') && Gate::denies('isWC') )
              <li class="sidebar-dropdown">
                <a href="#">
                  <i class="fa fa-chart-line"></i>
                  <span>Manage Category</span>
                </a>
                 <div class="sidebar-submenu">   
                  <ul>
                    <li>
                       <a  href="{{ URL::to('itemCategory/create') }}">Create Category</a> <!-- Add & Delete inventory within here -->
                    </li>
                    <li>
                       <a  href="{{ URL::to('itemCategory/') }}">View / Update / Delete Category</a> <!-- Add & Delete inventory within here -->
                    </li>

                  </ul>
                </div>
              </li>
              <li class="sidebar-dropdown">
                <a href="#">
                  <i class="fa fa-chart-line"></i>
                  <span>Manage Item</span>
                </a>
                 <div class="sidebar-submenu">   
                  <ul>
                    <li>
                       <a  href="{{ URL::to('item/create') }}">Create Item</a> <!-- Add & Delete inventory within here -->
                    </li>
                    <li>
                       <a  href="{{ URL::to('item/') }}">View / Update / Delete Item</a> <!-- Add & Delete inventory within here -->
                    </li>

                  </ul>
                </div>
              </li>
          @endif
          @endif
           @if(Gate::allows('isAdmin') || Gate::allows('isRM')||Gate::allows('isPM')||Gate::allows('isCM'))
              <!--Menu Title: Request -->
              <li class="header-menu">
                <span>Request Mapping</span>
              </li>
            @endif
            @if( Gate::denies('isCM') && Gate::denies('isPM') && Gate::denies('isWC') && Gate::denies('isAM'))
              <li class="sidebar-dropdown">
                <a href="#">
                  <i class="fa fa-chart-line"></i>
                  <span>Manage Purchase Request</span>
                </a>
                 <div class="sidebar-submenu ">   
                  <ul>
                    <li>
                       <a  href="{{ URL::to('purchaseRequest/create') }}">Create Purchase Request</a> 
                    </li>
                    <li>
                       <a  href="{{ URL::to('purchaseRequest/') }}">View / Update / Delete PR</a> 
                    </li>
                  </ul>
                </div>
              </li>
             @endif
              
              @if( Gate::denies('isCM') && Gate::denies('isRM')&& Gate::denies('isWC') && Gate::denies('isAM'))
              <li class="sidebar-dropdown">
                <a href="#">
                  <i class="fa fa-chart-line"></i>
                  <span>Map Purchase Request</span>
                </a>
                 <div class="sidebar-submenu">   
                  <ul>
                    <li>
                       <a  href="{{ URL::to('mapPurchaseRequest/auto') }}">Automatic</a> 
                    </li>
                    <li>
                       <a  href="{{ URL::to('mapPurchaseRequest/manual') }}">Manual</a> 
                    </li>
                  </ul>
                </div>
              </li>
              @endif
              @if(Gate::denies('isPM') && Gate::denies('isRM') && Gate::denies('isWC') && Gate::denies('isAM'))
              <li >
                <a class="nav-link" href="{{ URL::to('setRecentRequestPeriod') }}">
                  <i class="fa fa-chart-line"></i>
                  <span>Set Requested Items Period</span>
                </a>
            </li>
            @endif
           
           @if(Gate::allows('isAdmin')|| Gate::allows('isAM')||Gate::allows('isPM') ||Gate::allows('isRM') ||Gate::allows('isWC') ||Gate::denies('isCM'))
              <!--Menu Title: Dispatch Instruction -->
              <li class="header-menu">
                <span>Delivery</span>
              </li>
              @endif
              @if  (Gate::denies('isCM'))
              <li class="sidebar-dropdown">
                <a href="#">
                  <i class="fa fa-chart-line"></i>
                  <span>Purchase Order</span>
                </a>
                 <div class="sidebar-submenu">   
                  <ul>
                    @if( Gate::denies('isCM') )
                    <li>
                       <a  href="{{ URL::to('purchaseOrder') }}">View Purchase Order</a> 
                    </li>
                    @endif
                    @if(Gate::denies('isWC') && Gate::denies('isPM') && Gate::denies('isRM') && Gate::denies('isCM'))
                    <li>
                       <a  href="{{  URL::to('purchaseOrder/editStatus')}}">Update Purchase Order Status</a> 
                    </li>
                    @endif
                  </ul>
                </div>
              </li>
              @endif
              @if(Gate::denies('isAM') && Gate::denies('isCM'))
               @if( Gate::denies('isRM'))
              <li >
                <a class="nav-link" href="{{ URL::to('dispatchInstruction') }}">
                  <i class="fa fa-chart-line"></i>
                  <span>View Dispatch Instruction</span>
                </a>
              </li>
              @endif
              @if(Gate::denies('isPM'))
              <li class="sidebar-dropdown">
                <a href="#">
                  <i class="fa fa-chart-line"></i>
                  <span>Delivery Note</span>
                </a>
                 <div class="sidebar-submenu">   
                  <ul>
                     @if( Gate::denies('isRM'))
                    <li>
                       <a  href="{{ URL::to('deliveryNote/show') }}">Create Delivery Note</a> 
                    </li>
                    @endif
                    <li>
                       <a  href="{{ URL::to('deliveryNote/') }}">View Delivery Note</a> 
                    </li>
                  </ul>
                </div>
              </li>
              <li >
                <a class="nav-link" href="{{URL::to('updateStockCount/')}}">
                  <i class="fa fa-chart-line"></i>
                  <span>Update Stock Count</span>
                </a>
              </li>
               
               @endif
              <!--Menu Title: Supplier & Agreement -->
              @endif

            </ul>
          </div>
          <!-- sidebar-menu  -->
        </div>
        <!-- sidebar-content  -->
        <div class="sidebar-footer">
          <a href="#" id="alert">
            <i class="fa fa-bell"></i>
          </a>
          <a href="#">
            <i class="fa fa-envelope"></i>
          </a>
          <a href="#">
            <i class="fa fa-cog"></i>
          </a>
          <a id="logout-btn" href="{{ route('logout') }}" >
            <i class="fas fa-sign-out-alt"></i></a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
        </div>
      </nav>
      <!-- sidebar-wrapper  -->
      <main class="page-content" >
        <div class="container" >
        	@if (count($errors) > 0) 
    				<div class="alert alert-danger"> 
    					<ul> 
    						@foreach ($errors->all() as $error) 
    						<li>{{ $error }}</li> 
    						@endforeach      
    					</ul>     
    				</div>   
    			@endif 
    			@if ($message = Session::get('success')) 
    				<div class="alert alert-success alert-block">       
    					<button type="button" class="close" data-dismiss="alert">×</button>       
    					<strong>{{ $message }}</strong> 
    				</div>   
    			@endif 

    			 <!--Start of child content -->
    			@yield('content')
    			 <!--End of child content -->
        </div>
      </main>
      <!-- page-content" -->
    </div>
    <!-- page-wrapper -->
  
  </body>
</html>


