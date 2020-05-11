@extends('SuperAdmin.layouts.app')
@section('title', 'File Logs')
@include('SuperAdmin.default.header')
@include('SuperAdmin.default.sidebar')
@section('content')
<div class="main-panel">
	<div class="content">
		<div class="page-inner">
     <div class="page-header">
      <h4 class="page-title">File Logs</h4> 
    </div>	
      <div class="col-sm-12">
          <div class="form-group btns_rt" style="float: right;">
           
          </div>
        </div>
    <table class="table" id="example">
      <thead>
      <tr>
        <th>IP Address</th>
        <th>Address</th>
        <th>Category</th>
        <th>Book Date</th>
        <th>Log date</th>
        <th>View</th>
      </tr>
    </thead>
      <tbody>
        @if(!$records->isEmpty())
        @foreach($records as $ft)
        @php
          $details=json_decode($ft->details);
          $search=$details->SearchDetails;
          $Category=json_decode($search->Category);
         
        @endphp
        <tr>
          <td>{{$ft->ip}}</td>
          <td> {{$search->Address}}</td>
          <td>{{implode(' , ',$Category)}}</td>
          <td style="white-space: nowrap;">{{$search->Date}}</td>
          <td style="white-space: nowrap;">{{date('m-d-Y',strtotime($ft->date))}}</td>
          <td><span class="btn btn-success" onclick="GetMoreDetails(<?php echo $ft->id; ?>)" data-toggle="modal" data-target="#exampleModal">View More</span></td>
        </tr>
        @endforeach
        @endif
      </tbody>

    </table>
  </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
     
      <div class="modal-body">
          <h2>Log File Details</h2>
        <table class="table detailsclass">
        <tr>
        <td>IP Address</td>
        <td id="ip"></td>
      </tr>
      <tr>
        <td>Country</td>
        <td id="Country"></td>
      </tr>
      <tr>
        <td>City</td>
        <td id="City"></td>
      </tr>
      <tr>
        <td>Time Zone</td>
        <td id="Zone"></td>
      </tr>
      <tr>
        <td>Latitude</td>
        <td id="Latitude"></td>
      </tr><tr>
        <td>Longitude</td>
        <td id="Longitude"></td>
      </tr>
      
      <tr>
        <td>Search Address</td>
        <td id="Search"></td>
      </tr>
      <tr>
        <td>Category</td>
        <td id="Category"></td>
      </tr>
      <tr>
        <td>Date</td>
        <td id="Date"></td>
      </tr>
      </table>
      </div>
     
    </div>
  </div>
</div>

<script type="text/javascript">
  function GetMoreDetails(id){
    const parmt={
      id:id,
      _token:"{{csrf_token()}}"
    }
    $.post('{{route("GetMoreDetails")}}',parmt).then(function(response){
        let obj=JSON.parse(response);
        $('#ip').html(obj.ip);
       let webdetails=JSON.parse(obj.details);
        $('#Country').html(webdetails.IpDetails.geoplugin_countryName)
        $('#City').html(webdetails.IpDetails.geoplugin_regionName)
        $('#Zone').html(webdetails.IpDetails.geoplugin_timezone)
        $('#Latitude').html(webdetails.IpDetails.geoplugin_latitude)
        $('#Longitude').html(webdetails.IpDetails.geoplugin_longitude)
        $('#Search').html(webdetails.SearchDetails.Address)
        $('#Category').html(JSON.parse(webdetails.SearchDetails.Category))
        $('#Date').html(webdetails.SearchDetails.Date)
        
    })
  }
</script>
<style type="text/css">
  .detailsclass td:first-child {
    background-color: black;
    color: white;
} 
</style>
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    var table = $('#example').DataTable();
 
        function explode(){
        $("#example_filter").detach().appendTo('.btns_rt');
    }

    
    $(document).ready(function() {
        setTimeout(explode, 500);
    table
        .columns(3)
        .search( this.value )
        .draw();
} );

        $('div.dataTables_filter input').attr('placeholder', 'Search...','class'); 
        $("#example").wrap("<div class='responsive-table'></div>");
        $('div.dataTables_filter input').addClass('form-control');
        
</script>
@include('SuperAdmin.default.footer')
@endsection