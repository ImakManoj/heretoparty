@extends('VendorPanel.Userslayouts.apps')
@section('title','My Query')
@section('content')

@php
use App\Http\Controllers\Vender\VenderController;
@endphp

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css">

             <div class="dashboard-content-wrap"> 
                <div class="dashboard-content-inner"> 

                <div class="white-box-shadow">
                    <div class="row-wrap">
                        <div class="d-title d-flex align-items-center justify-content-between">
                            <h3>My Quotes</h3>
                            <div class="search-wrap">
                            <form>
                                <input type="text" class="form-control" placeholder="Search" >
                                 <button class="search-btn" type="button"><i class="fa fa-search"></i></button>
                            </form>
                            </div>
                       </div>
                       <div class="table-wrap"> 
                         <table class="table table-bordered tr__sub table-striped quote-table ">
                              <thead class="primary-theme"> 
                                  <tr>
                                  <th>Event</th> 
                                  <th>Quote</th>
                                  <th>Document</th>
                                  <th>Notes</th>
                                  <th>Status</th> 
                                  <th>Action</th>
                                  </tr>
                              </thead>   
                              <tbody>
                                @foreach($response as $row)
                                  <tr>
                                      <td colspan="6" style="padding: 0; border: 0;">
                                          <table cellpading="0" cellspacing="0" style="border: 0; width: 100%; border: 0;">
                                                <tr class="white_bg">
                                                    <td colspan="6">{{$row->first_name}} {{$row->last_name}}</td>
                                                </tr>
                                                <tr class="white_bg">
                                                <td colspan="6"><strong>{{$row->event_name}}</strong></td>
                                                </tr>
                @php
                 $services=VenderController::getServices($row->servces_id,$row->vid); 
                @endphp
                  @foreach($services as $ft)
                      <tr>
                          <td>{{$ft->service_name}}</td>
                          <td>$ {{$ft->price}}</td>
                          <td><i class="fa fa-file-pdf-o" aria-hidden="true" onclick="getImages({{$ft->id}})"></i></td>
                          <td>{{$ft->description}}</td>
                          <td class="green-text">Accepted</td>
                          <td>
                          <a href="#" class="btn green-btn table-btn" onclick="submitMyQutotes()">Submit</a>
                          <a href="#" class="btn yellow-btn table-btn" onclick="resubmitMyQutotes()">Resubmit</a>
                          <a href="#" class="btn red-btn table-btn" onclick="withdrawMyQutotes()">Withdraw</a>
                          </td>
                      </tr>
                  @endforeach
                                             </table>
                                      </td>
                                  </tr>
                                  @endforeach                               
                              </tbody>
                              </table>
                       </div>
                   </div>
                </div> 
                </div>   <!-- dashboard-content-inn  -->
             </div>  

            <!-- dashboard-content-wrap  -->
<!-- Model Start -->


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Documents</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" id="images">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
<script type="text/javascript">
  $(window).ready(function(){
    $.noConflict();
  })
</script>
<!-- End Model -->

            <script type="text/javascript">
              function getImages(id){
                const parmt={
                  _token:"{{csrf_token()}}",
                  id:id
                }
                $.post('{{route("getImagesServices")}}',parmt).then(function(response){
                  $('#images').html(response);
                   $('#myModal').modal('show');
                })
               
              }
            </script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.js"></script>

<script type="text/javascript">
  function submitMyQutotes(){
        $.toast({
          heading: 'My Quote',
          text: 'My Quote Send Successfuly !',
          showHideTransition: 'fade',
          icon: 'success'
      });
}
</script>


<script type="text/javascript">
  function resubmitMyQutotes(){
        $.toast({
          heading: 'My Quote',
          text: 'My Quote Resend Successfuly !',
          showHideTransition: 'fade',
          icon: 'warning'
      });
}
</script>

<script type="text/javascript">
  function withdrawMyQutotes(){
        $.toast({
          heading: 'My Quote',
          text: 'My Quote Withdraw!',
          showHideTransition: 'fade',
          icon: 'denger'
      });
}
</script>



@endsection

    

  