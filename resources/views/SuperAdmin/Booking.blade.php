@extends('SuperAdmin.layouts.app')
@section('title', 'Booked History')
@include('SuperAdmin.default.header')
@include('SuperAdmin.default.sidebar')
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<div class="main-panel">
	<div class="content">
		<div class="page-inner">


			<div class="page-header">
        <h4 class="page-title">Booked History</h4> 
      </div>	
      <div class="row">
        <div class="col-sm-4">
          <div class="form-group">
            <label>Professional Name</label>
            <input type="text" name="Name" placeholder="Enter Professional Name" id="name"  class="form-control" onkeyup="SearchBooking()">
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <label>Order No</label>
            <input type="text" name="orderNo" placeholder="Enter order number" id="orderNo" class="form-control" onkeyup="SearchBooking()">
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <label>Date</label>
            <input type="text" name="date" placeholder="Enter Date" id="date" class="form-control datepicker" onchange="SearchBooking()" autocomplete="off" >
          </div>

        </div>




      </div>
      <table class="table">

        <thead>

          <tr>

            <th>S.no</th>

            <th>Booking Date</th>

            <th>Time Slot</th>

            <th>User</th>
            <th>Professional</th>
            <th>Payment Status</th>
            <th>Status</th>
            <th>View</th>

            <th>Pay</th>

          </tr>

        </thead>

        <tbody id="replacetable">
          @if(!empty($records))
          <?php       $i=0; ?>
          @foreach($records as $ft)
          <?php $i++; ?>
          <tr id="OrderChanges{{$ft->order_Id}}">
            <td>{{$i}}</td>
            <td>{{date('d-M-Y',strtotime($ft->userOrder_Date))}}</td>
            <td>{{$ft->order_time}}</td>
            <td>{{$ft->first_name}}{{$ft->last_name}}</td>
            <td>{{$ft->ProfessionalName}}</td>

            <?php if($ft->Paymentid==''){ ?>
              <td>Paid in Person</td>
            <?php    }elseif($ft->Paymentid!='' && $ft->admin_pay==0) {?>
              <td>Waiting on Payment</td>
            <?php }else{ ?>
              <td>Paid</td>
            <?php     } ?>

            <td>@php
              if(strtotime(date('Y-m-d')) > strtotime($ft->userOrder_Date)){
              if($ft->order_status==1){
              echo '<span class="status yellow"></span>Pending';
            }elseif($ft->order_status==2){
            echo '<span class="status red"></span>Completed';
          }else{
          echo '<span class="status yellow"></span>Cancel';
        }
      }else{
      echo '<span class="status green"></span>Upcomming';
    }
  @endphp</td>
  <td><span class="btn btn-danger btn-sm"  onclick="displayBookDetails({{$ft->order_Id}})" data-toggle="modal" data-target="#BookingView">View</span></td>
  <td>
    <?php if($ft->Paymentid!=''){ ?>
    @if($ft->admin_pay==1)
    <!--   <span class="btn btn-default btn-sm" style="pointer-events: none;">Paid</span> -->
    @else
    <span class="btn btn-success btn-sm" onclick="PaymentButton(<?php echo $ft->order_Id; ?>)">Pay Now</span>
    @endif

  <?php } ?>

  </td>
</tr> 
@endforeach

@endif

</tbody>

</table>
</div>
</div>
</div>



<!-- Modal -->
<div class="modal fade bookingView" id="BookingView" tabindex="-1" role="dialog"
aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
  <div class="modal-content" style="padding: 2em;font-size: 14px;">
    <div class="row no-gutters">
      <div class="col-md-12">
        <div class="model_title_wrap">
          <h3>Booking Details</h3>

        </div>
        <div class="booking-detail-wrap">
          <div class=" row">
            <div class="col-sm-4 c-label">Booking ID</div>
            <div class="col-sm-8 c-label input-label" id="bookid"></div>
          </div>

          <div class=" row">
            <div class="col-sm-4 c-label">Name</div>
            <div class="col-sm-8 c-label input-label" id="UserName"></div>
          </div>

          <div class=" row">
            <div class="col-sm-4 c-label">Booking Date</div>
            <div class="col-sm-8 c-label input-label" id="BookDate"> </div>
          </div>

          <div class=" row">
            <div class="col-sm-4 c-label">Time Slot</div>
            <div class="col-sm-8 c-label input-label" id="BookTime"></div>
          </div>

          <div class=" row ">
            <div class="col-sm-4 c-label">Address</div>
            <div class="col-sm-8 c-label input-label"n id="ClientAddress"></div>
          </div>
          <div class=" row ">
            <div class="col-sm-4 c-label">Services</div>
            <div class="col-sm-8 c-label input-label"n id="service_name"></div>
          </div>

          <div class=" row ">
            <div class="col-sm-4 c-label">Professional's Name</div>
            <div class="col-sm-8 c-label input-label" id="ClientName"></div>
          </div>

          <div class=" row ">
            <div class="col-sm-4 c-label">Status</div>
            <div class="col-sm-8 c-label input-label" id="Status"></div>
          </div>


          <div class=" row">
            <div class="col-sm-4 c-label">Price</div>
            <div class="col-sm-8 c-label input-label" id="Payments">$230</div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
  function displayBookDetails(id){

    const parmt={
      _token:"{{csrf_token()}}",
      id:id
    }
    $.post('{{route("AdminBookhistory")}}',parmt).then(function(response){
      console.log(response);
      var obj=JSON.parse(response);
      for(var i=0;i<obj.length;i++){
        $('#bookid').html(obj[i].order_Id);
        $('#ClientName').html(obj[i].first_name+' '+obj[i].last_name);
        $('#ClientAddress').html(obj[i].companies_address);
        $('#service_name').html(obj[i].service_names);
        $('#BookDate').html(obj[i].bookDate);
        $('#BookTime').html(obj[i].order_time);
        $('#Status').html(obj[i].status);
        $('#Payments').html('$'+obj[i].totalPay);
        $('#UserName').html(obj[i].usersName);
        $('#BookService').html(obj[i].service_names);
      }


    })
  }
</script>

<script>
  function PaymentButton(id){
    const parmt={
      _token:"{{csrf_token()}}",
      order_id:id,
    }
    $.post('{{route("PaymentButton")}}',parmt).then(function(response){
      $('#OrderChanges'+id).html(response);
    })
  }
</script>

<script type="text/javascript">
  function SearchBooking(){
    const parmt={
      name:$('#name').val(),
      orderNo:$('#orderNo').val(),
      date:$('#date').val(),
      _token:"{{csrf_token()}}"
    }
    $.post('{{route("searchingBook")}}',parmt).then(function(response){
      $('#replacetable').html(response);
    })
  }
</script>

<script type="text/javascript">
  var dateToday = new Date();
  var dates = $('.datepicker').datepicker({


  });
</script>
<link rel="stylesheet" type="text/css" href="{{asset('')}}/datepicker.css">
@include('SuperAdmin.default.footer')
@endsection