@extends('VendorPanel.Userslayouts.apps')
@section('title','Files')
@section('content')
 
            <div class="dashboard-content-wrap"> 
                <div class="dashboard-content-inner"> 

                <div class="white-box-shadow">
                    <div class="row-wrap">
                        <div class="d-title d-flex align-items-center justify-content-between">
                            <h3>Files</h3>
                            <span class="btn btn-success sm-btn" onclick="addBoucher()">Add Brochure</span>
                            <div class="search-wrap">
                            <form>
                                <input type="text" class="form-control" placeholder="Search" >
                                 <button class="search-btn" type="button"><i class="fa fa-search"></i></button>
                            </form>
                            </div>
                       </div>
                       <div class="table-wrap files-table"> 
                         <table class="table table-bordered table-striped">
                              <thead class="primary-theme"> 
                                  <tr>
                                  <th>Sr. No.</th> 
                                  <th>Name</th>
                                  <th>Service name</th>
                                  <th>Document</th>
                                  <th>Action</th> 
                                  </tr>
                              </thead>  
                              <tbody>
                                @if(!$boucher->isEmpty())
                                  @foreach($boucher as $ft)
                                  <tr>
                                  <td>{{$ft->bid}}</td>
                                  <td>{{$ft->bname}}</td>
                                  <td>{{$ft->name}}</td>
                                  <td><a href="{{asset($ft->images)}}" download=""><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a></td>
                                  <td>
                                     <a href="javascript:void(0)" class="icon-btn view-icon-btn" onclick="ShowVoucher('{{$ft->images}}')"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                     <a href="javascript:void(0)" class="icon-btn edit-icon-btn" onclick="fatch_records({{$ft->bid}})"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                  </td>
                                  </tr>
                                    @endforeach
                                  @endif
                              </tbody>
                              </table>
                       </div>
                   </div>
                </div> 
                </div>   <!-- dashboard-content-inn  -->
             </div>   

            <!-- dashboard-content-wrap  -->

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Brochure</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form action="{{route('saveBrochure')}}" method="post"  enctype="multipart/form-data">
          <div class="row">
            @csrf
          <div class="col-md-6">
            <div class="form-group">
              <label>Enter Brochure</label>
              <input type="text" name="name" id="name" placeholder="Enter Brochure  Name" class="form-control" required="">
            </div>
            <input type="hidden" name="boucherIds" id="boucherIds">
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Select Service</label>
              <select type="text" name="services" id="services" placeholder="Enter Brochure  Name" class="form-control" required="">
                <option value="">Select Service</option>
                @foreach($service as $ft)
                  <option value="{{$ft->serviceId}}">{{$ft->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Choose Document</label>
              <input type="file" name="files" id="files" placeholder="Enter Brochure  Name" class="form-control" required="">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group" style="padding-top: 2.5em">
              <input type="submit" name="submit" id="submit" class="btn btn-primary" style="width: 100%">
            </div>
          </div>
        </div>
        </form>
    </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
  <script type="text/javascript">
    function addBoucher(){
      $('#myModal').modal('show');
    }
  </script>
    

  <!-- Modal -->
  <div class="modal fade" id="ShowVoucher" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Document</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div id="images_show"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <script type="text/javascript">
    function ShowVoucher(images){
      $('#images_show').html('<img src="{{asset("")}}'+images+'" style="width:100%">');
      $('#ShowVoucher').modal('show');
    }
  </script>
  <script type="text/javascript">
    function fatch_records(id){
      const parmt={
          _token:"{{csrf_token()}}",
          id:id
      }
      $.post('{{route("getbouchers")}}',parmt).then(function(response){
        var obj=JSON.parse(response);
          $('#name').val(obj.bname);
          $('#services').val(obj.service_id);
          $('#boucherIds').val(obj.bid);
           $('#myModal').modal('show');
      })
    }
  </script>
  @endsection
