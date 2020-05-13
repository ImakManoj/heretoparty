@extends('UserDashboard.Userslayouts.apps')
@section('title','Gust List')
@section('content')


  <div class="dashboard-content-wrap">
                <div class="dashboard-content-inner">
                    <div class="profile-box-wrap white-box-shadow">
                       <div class="row-wrap">
                        <div class="d-title d-flex align-items-center justify-content-between">
                            <h3>Guest</h3>
                            <div class="search-wrap search-guest"> 


                              <form>

                              <div class="form-group btns_rt">

                              </div>


                                  <a href="javascipt:void(0);" class="btn btn-default btn-capitalize" data-toggle="modal" data-target="#add-guest">Add Guest</a>
                              </form>


                           <!--  <form class="d-flex align-items-center">
                                    <div class="serch-field col relative">
                                        <input type="text" class="form-control" placeholder="Search" >
                                        <button class="search-btn" type="button"><i class="fa fa-search"></i></button>
                                    </div>
                                        
                            </form>  -->
                            </div>
                       </div>
                        <div class="table-wrap "> 
                            <table class="table table-bordered table-striped" id="example">
                                 <thead class="primary-theme"> 
                                     <tr>
                                        <th>Sr. No.</th> 
                                        <th>Guest Name</th>
                                        <th>Email</th>
                                        <th>RSVP</th>
                                        <th>Action</th> 
                                     </tr>
                                 </thead>  
                                 <tbody>
                                    @if(!$response->isEmpty())
                                        @foreach($response as $ft)
                                     <tr id="remove__{{$ft->id}}">
                                         <td>{{$ft->id}}</td>
                                         <td>{{$ft->guest_name}}</td>
                                         <td>{{$ft->email_name}}</td>
                                         <td>
                                            @if($ft->status==1)
                                            <img src="{{asset('heretoparty')}}/images/tick-1.png" alt="tick-1.png" class="icon-img" /> Attending
                                            @elseif($ft->status==2)
                                            <img src="{{asset('heretoparty')}}/images/question-1.png" alt="question-1.png" class="icon-img" /> Not Sure
                                            @else
                                            <img src="{{asset('heretoparty')}}/images/cancel.png" alt="cancel.png" class="icon-img" /> Not Attending
                                            @endif
                                            </td>
                                         <td>
                                             <a href="javascript:void(0);" class="icon-btn edit-icon-btn" onclick="updateGuestLIst({{$ft->id}})"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                            <a href="javascript:void(0);" class="icon-btn view-icon-btn" onclick="deletegueslist({{$ft->id}})"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                         </td>
                                     </tr>
                                        @endforeach
                                     @endif
                                   

                                 </tbody>
                                 </table>
                          </div>
                   </div>
                    </div>
                </div>
                <!-- dashboard-content-inn  -->
            </div> 




  <!-- Modal -->
  <div class="modal fade custom__modal " id="add-guest" >
    <div class="modal-dialog modal-dialog-centered sm" role="document">
      <div class="modal-content">
          <a href="javascript:void(0);" class="close-btn" data-dismiss="modal" >X</a>
          <div class="d-title d-title-center">
              <h3>Add Guest</h3>
          </div>

            <form action="{{route('submitGuest')}}" method="post"> 
                @csrf
                <div class="form-group">
                    <input type="text" name="guest_name" id="guest_name" class="form-control" placeholder="Guest Name" />
                </div>
                <input type="hidden" name="guest_id" id="guest_id">
                <div class="form-group">
                    <input type="text" name="gust_email" id="gust_email" class="form-control" placeholder="Email" />
                </div>

                <div class="form-group">
                    <select  class="form-control" name="guest_status" id="guest_status">
                        <option value="">Status</option>
                        <option value="1">Attending</option>
                        <option value="2">Not Sure</option>
                        <option value="3">Not Attending</option>
                    </select>
                </div>

                <div class="text-center mt-5">
                    <button class="btn btn-default">Save</button>
                </div>
            </form>
      </div>
    </div>
  </div>


<script type="text/javascript">
    function updateGuestLIst(id){
        const parmt={
            id:id,
            _token:'{{csrf_token()}}'
        }

        $.post('{{route("updateGuestLIst")}}',parmt).then(function(response){
                $('#guest_name').val(response.guest_name);
                $('#gust_email').val(response.email_name);
                $('#guest_status').val(response.status);
                $('#guest_id').val(response.id);

            $('#add-guest').modal('show');
        })
    }
</script>
<script type="text/javascript">
    function deletegueslist(id){
        const parmt={
            id:id,
            _token:'{{csrf_token()}}',
        }
        $.post('{{route("deletegueslist")}}',parmt).then(function(response){
            $('#remove__'+id).remove();
        })
    }
</script>

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
        .columns(1)
        .search( this.value )
        .draw();
} );

        $('div.dataTables_filter input').attr('placeholder', 'Search...','class'); 
        $("#example").wrap("<div class='responsive-table'></div>");
        $('div.dataTables_filter input').addClass('form-control');
        
</script>

@endsection