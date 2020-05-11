@extends('UserDashboard.Userslayouts.apps')
@section('title','Budgeter')
@section('content')
@php
use App\Http\Controllers\Users\UsersController
@endphp
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  <div class="dashboard-content-wrap">
                <div class="dashboard-content-inner">
                    <div class="profile-box-wrap white-box-shadow">
                       <div class="row-wrap">
                        <div class="d-title d-flex align-items-center justify-content-between">
                            <h3>Budgeter</h3>
                       </div>

                       <form>
                            <div class="totla-budget form-row">
                                <div class="col col-lg-4">
                                        <div class="form-group relative">
                                          <input type="text" class="form-control pr-5" placeholder="Total Budget"/>
                                          <a href="javascript:void(0);" class="edit-bbtn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <div class="col col-lg-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Total Budget"/>
                                    </div>
                            </div>
                            <div class="col col-lg-4">
                                <div class="form-group">
                                    <span class="btn icon-btn" onclick="addBudgeter()">Add Budgeter</span>
                                </div>
                            </div>
                            </div>
                    </form>


                        <div class="table-wrap"> 
                            <table class="table table-bordered table-striped badget-table">
                                 <thead class="primary-theme"> 
                                     <tr>
                                        <th>Event</th> 
                                        <th>Actual Cost</th>
                                        <th>Action</th> 
                                     </tr>
                                 </thead>  
                                 <tbody>
                                    @if(!$events->isEmpty())
                                        @foreach($events as $ft)
                                     <tr class="white_bg" id="updateEvents_{{$ft->id}}">
                                         <td>
                                            <div class="toreplace_{{$ft->id}}">
                                            <strong>{{$ft->name}}</strong>
                                            </div>
                                            <div class="sowalldiv__{{$ft->id}}" style="display: none;">
                                                <input type="text"name="changeevent_{{$ft->id}}" id="changeevent_{{$ft->id}}" value="{{$ft->name}}">
                                            
                                        </div>

                                         </td>
                                         <td>
                                            <div class="toreplace_{{$ft->id}}">
                                                <Strong>$ {{$ft->amount}}</Strong>
                                            </div>
                                            <div class="sowalldiv__{{$ft->id}}" style="display: none;">
                                            <input type="text" name="changeamount_{{$ft->id}}" id="changeamount_{{$ft->id}}" value="{{$ft->amount}}">
                                            </div>
                                         </td>
                                         <td>
                                             <div class="toreplace_{{$ft->id}}">
                                             <a href="javascript:void(0);" class="icon-btn edit-icon-btn" onclick="updateEvents({{$ft->id}})"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                                            <a href="avascript:void(0);" class="icon-btn view-icon-btn" onclick="DeleteEvents({{$ft->id}})"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                             </div>
                                            <div class="sowalldiv__{{$ft->id}}" style="display: none;">
                                                <span class="btn btn-primary" onclick="UpdateEvent({{$ft->id}})">Update</span>
                                            </div>
                                         </td>
                                     </tr>
                                     @php
                                        $response=UsersController::getItems($ft->id)
                                     @endphp
                                        @foreach($response as $row)
                                     <tr id="replaceitemList_{{$row->id}}">
                                        <td> 
                                          <div class="itemnamedivshow__{{$row->id}}">
                                          {{$row->itme_name}}
                                        </div>
                                        <div class="itemnamediv__{{$row->id}}"  style="display: none;"> 
                                          <input type="text" name="changeItem__name{{$row->id}}" id="changeItem__name{{$row->id}}" value="{{$row->itme_name}}">
                                        </div>
                                        </td>
                                        <td>
                                          <div class="itemnamedivshow__{{$row->id}}"> 
                                          ${{$row->itme_amount}}
                                          </div>
                                          <div class="itemnamediv__{{$row->id}}"  style="display: none;">
                                            <input type="text" name="itemamoutchanged__{{$row->id}}" id="itemamoutchanged__{{$row->id}}" value="{{$row->itme_amount}}">
                                          </div>
                                        </td>
                                        <td>
                                          <div class="itemnamedivshow__{{$row->id}}">
                                          <a href="javascript:void(0);" class="icon-btn edit-icon-btn" onclick="OpenEditItem({{$row->id}})"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                           <a href="javascript:void(0);" class="icon-btn view-icon-btn" onclick="Deleteitem({{$row->id}})"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                         </div>
                                         <div class="itemnamediv__{{$row->id}}"  style="display: none;">
                                          <input type="submit" value="Update" class="btn btn-primary" onclick="itemReupdate({{$row->id}})">
                                         </div>
                                        </td>
                                    </tr>
                                            @endforeach
                                        @endforeach
                                    @endif
                                   

                                    <tr>
                                       <td colspan="3">
                                           <a href="javascript:void(0);"  data-toggle="modal" data-target="#add-items" class="add-item-btn"><i class="fa fa-plus" aria-hidden="true"></i> Add Item</a>
                                       </td>
                                    </tr>
                                 </tbody>
                                 </table>
                          </div>
                   </div>
                    </div>
                </div>
                <!-- dashboard-content-inn  -->
            </div> 



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Budgeter</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="{{route('saveBudgeter')}}" method="post">
      <div class="modal-body">
        <div class="row">
        <div class="col col-lg-6">
            <div class="form-group">
                <input type="text" name="budgeterName" id="budgeterName"  class="form-control"  placeholder="Enter Budgeter" required="">
            </div>
            @csrf
        </div>
        <div class="col col-lg-6">
            <div class="form-group">
                <input type="text" name="amount" id="amount"  class="form-control"  placeholder="Enter Amount" required="">
            </div>
        </div>
         
      </div>
  </div>
      <div class="modal-footer">
        <input type="submit" name="submit" id="submit" class="btn btn-success" value="Save">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
</form>
  </div>
</div>
  

  <!-- Modal -->
  <div class="modal fade custom__modal " id="add-items" >
    <div class="modal-dialog modal-dialog-centered sm" role="document">
      <div class="modal-content">
          <a href="javascript:void(0);" class="close-btn" data-dismiss="modal" ><i class="fa fa-minus" aria-hidden="true"></i></a>
          <div class="d-title d-title-center">
              <h3>Add Item</h3>
          </div>

            <form action="{{route('saveBudgeterList')}}" method="post">
            @csrf 
                <div class="form-group">
                    <select  class="form-control" name="event" id="event" onchange="geteventprice(this.value)">
                        <option value="">Event</option>
                        @foreach($events as $ft)
                        <option value="{{$ft->id}}">{{$ft->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="amounts" id="amounts" placeholder="Actual Cost" />
                </div>
               
                <section id="appenddiv"></section>

                <div class="form-group form-row form-inline flex-nowrap">
                    <div class="col inline_col">
                        <input type="text" name="itemName[]" class="form-control" placeholder="Catering" />
                    </div>
                    <div class="col inline_col">
                        <input type="text" class="form-control" name="itemAmount[]" placeholder="$1000" />
                    </div>
                    <div class="col inline_col">
                        <a href="javascript:void(0);" class="action__btn plus__bttn" onclick="appenddiv()"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <button class="btn btn-default">Save</button>
                </div>
            </form>
      </div>
    </div>
  </div>



<script type="text/javascript">
    function addBudgeter(){
        $('#myModal').modal('show');
    }
</script>
<script type="text/javascript">
     $(".datepicker").datepicker({
        dateFormat: 'dd-mm-yy'
}); 
</script> 
<script type="text/javascript">
    let i=0;

    function appenddiv(){
        i++;

        var appenddiv='<div id="append_'+i+'"><div class="form-group form-row form-inline flex-nowrap"><div class="col inline_col"><input type="text" name="itemName[]" class="form-control" placeholder="Food"  required/></div><div class="col inline_col"><input type="text" name="itemAmount[]" class="form-control" placeholder="$1000" required /></div><div class="col inline_col"><a href="javascript:void(0);" class="action__btn delete__bttn" onclick="removediv('+i+')"><i class="fa fa-minus" aria-hidden="true"></i></a></div></div></div>';


        $('#appenddiv').append(appenddiv)

    }
</script>
<script type="text/javascript">
    function removediv(i){
        $('#append_'+i).remove();
    }
</script>
<script type="text/javascript">
    function geteventprice(id){
        const parmt={
            id:id,
            _token:"{{csrf_token()}}"
        }
        $.post('{{route("geteventprice")}}',parmt).then(function(response){
            $('#amounts').val(response.amount);
        })
    }
</script>

<script type="text/javascript">
    function updateEvents(id){
       $('.sowalldiv__'+id).show();
       $('.toreplace_'+id).hide();
    }
</script>

<script type="text/javascript">
    function OpenEditItem(id){
       $('.itemnamediv__'+id).show();
       $('.itemnamedivshow__'+id).hide();
    }
</script>



<script type="text/javascript">
    function UpdateEvent(id){
        const parmt={
            _token:'{{csrf_token()}}',
            id:id,
            amount:$('#changeamount_'+id).val(),
            changeevent:$('#changeevent_'+id).val()
        }
        $.post('{{route("UpdateEvents")}}',parmt).then(function(response){
            var obj=JSON.parse(response);
            $('#updateEvents_'+id).html('<td><div class="toreplace_'+obj.id+'"><strong>'+obj.name+'</strong></div><div class="sowalldiv__'+obj.id+'" style="display: none;"><input type="text"name="changeevent_'+obj.id+'" id="changeevent_'+obj.id+'" value="'+obj.name+'"></div></td><td><div class="toreplace_'+obj.id+'"><Strong>$ '+obj.amount+'</Strong></div><div class="sowalldiv__'+obj.id+'" style="display: none;"><input type="text" name="changeamount_'+obj.id+'" id="changeamount_'+obj.id+'" value="'+obj.amount+'"></div></td><td><div class="toreplace_'+obj.id+'"><a href="javascript:void(0);" class="icon-btn edit-icon-btn" onclick="updateEvents('+obj.id+')"><i class="fa fa-pencil" aria-hidden="true"></i></a><a href="#" class="icon-btn view-icon-btn" onclick="DeleteEvents('+obj.id+')"><i class="fa fa-trash" aria-hidden="true"></i></a></div><div class="sowalldiv__'+obj.id+'" style="display: none;"><span class="btn btn-primary" onclick="UpdateEvent('+obj.id+')">Update</span></div></td>')

        })
    }
</script>
<script type="text/javascript">
    function itemReupdate(id){
        const parmt={
            _token:'{{csrf_token()}}',
            id:id,
            amount:$('#itemamoutchanged__'+id).val(),
            changeevent:$('#changeItem__name'+id).val(),
        }
        $.post('{{route("UpdateBudgeter")}}',parmt).then(function(response){
            var obj=JSON.parse(response);
            $('#replaceitemList_'+id).html('<td><div class="itemnamedivshow__'+obj.id+'">'+obj.itme_name+'</div><div class="itemnamediv__'+obj.id+'"  style="display: none;"><input type="text" name="changeItem__name'+obj.id+'" id="changeItem__name'+obj.id+'" value="'+obj.itme_name+'"></div></td><td><div class="itemnamedivshow__'+obj.id+'">$'+obj.itme_amount+'</div><div class="itemnamediv__'+obj.id+'"  style="display: none;"><input type="text" name="itemamoutchanged__'+obj.id+'" id="itemamoutchanged__'+obj.id+'" value="'+obj.itme_amount+'"></div></td><td><div class="itemnamedivshow__'+obj.id+'"><a href="javascript:void(0);" class="icon-btn edit-icon-btn" onclick="OpenEditItem('+obj.id+')"><i class="fa fa-pencil" aria-hidden="true"></i></a><a href="javascript:void(0);" class="icon-btn view-icon-btn"><i class="fa fa-trash" aria-hidden="true"></i></a></div><div class="itemnamediv__'+obj.id+'"  style="display: none;"><input type="submit" value="Update" class="btn btn-primary" onclick="itemReupdate('+obj.id+')"></div></td>')

        })
    }
</script>

<script type="text/javascript">
  function DeleteEvents(id){
      const parmt={
        id:id,
        _token:'{{csrf_token()}}'
       }
       $.post('{{route("deleteEvents")}}',parmt).then(function(response){
        window.location.href="";
       })
  }
</script>


<script type="text/javascript">
  function Deleteitem(id){
      const parmt={
        id:id,
        _token:'{{csrf_token()}}'
       }
       $.post('{{route("Deleteitem")}}',parmt).then(function(response){
       $('#replaceitemList_'+id).remove();
       })
  }
</script>




@endsection