@extends('UserDashboard.Userslayouts.apps')
@section('title','My Query')
@section('content')
@php
use App\Http\Controllers\Vender\VenderController;
@endphp
 
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
                         <table class="table table-bordered tr__sub table-striped quote-table customer-quote-table ">
                              <thead class="primary-theme"> 
                                  <tr>
                                  <th>Event</th> 
                                  <th>Quote</th>
                                  <th>Document</th>
                                  <th>Rating</th> 
                                  <th>Notes</th>
                                  <th>Action</th>
                                  </tr>
                              </thead>   
                              <tbody>
                                  @foreach($response as $row)
                                  <tr>
                                      <td colspan="6" style="padding: 0; border: 0;">
                                          <table cellpading="0" cellspacing="0" style="border: 0; width: 100%; border: 0;">
                                                <tr class="white_bg">
                                                  <td colspan="6"><strong>{{$row->first_name}} {{$row->last_name}}</strong></td>
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
                                                    <td><img src="../images/rating-1.png" alt="rating.png" /></td>
                                                    <td>{{$ft->description}}</td>
                                                    <td>
                                                        <a href="#" class="btn green-btn table-btn">Submit</a>
                                                        <a href="#" class="btn yellow-btn table-btn">Resubmit</a>
                                                        <a href="#" class="btn red-btn table-btn">Withdraw</a>
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
  

            <!-- dashboard-content-wrap  -->

    

            <script type="text/javascript">
              function getImages(id){
                const parmt={
                  _token:"{{csrf_token()}}",
                  id:id
                }
                $.post('{{route("usersgetImagesServices")}}',parmt).then(function(response){
                  $('#images').html(response);
                   $('#myModal').modal('show');
                })
               
              }
            </script>
@endsection
  