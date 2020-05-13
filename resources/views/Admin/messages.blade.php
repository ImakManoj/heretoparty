@extends('Admin.Userslayouts.apps')
@section('title','Message')
@section('content')
 

 <div class="dashboard-content-wrap">
                <div class="dashboard-content-inner">

                <div class="white-box-shadow">
                      <div class="d-title">
                           <h3>Message</h3>
                      </div>
                 <div class="inbox-wrap">
                     <div class="inbox-list">
                         <div class="chat-search-wrap">
                             <form>
                                 <input type="text" class="form-control" placeholder="Search..."/>
                                 <button type="button" class="search-btn"><i class="fa fa-search" aria-hidden="true"></i></button>
                             </form>      
                         </div>
                         <ul>
                                @if(!$response->isEmpty())
                                    @foreach($response as $ft)
                                       
                                <li onclick="shiftUsers({{$ft->uid}})">
                                 <a href="javascript:void(0);">
                                     <figure style="background-image: url('{{asset($ft->img)}}');"></figure>
                                     <h6 id="UserNames_{{$ft->uid}}">{{$ft->first_name}} {{$ft->last_name}}</h6>
                                     <span class="notify msg">2</span>
                                    </a>
                                </li>
                                    @endforeach
                                @endif

                         </ul>
                     </div>
                    
                    <div class="chat-box-wrap">
                        <div class="chat-title-box">
                             <div class="profile-box profile-left">
                                <figure style="background-image: url('../images/member5.jpg');"></figure>
                                <h6 id="namedisplay">Mark</h6>
                             </div>
                             <div class="profile-right">
                                 <a href="javascript:void(0);" class="eye-icon"><i class="fa fa-eye" aria-hidden="true"></i></a>
                           </div>
                        </div>
                         <div class="chat-box-sec">
                             <div id="Message">Not message found</div>
                         </div>
                        <form enctype="multipart/form-data" onsubmit="return false">
                            @csrf
                            <input type="hidden" name="afterappend" id="afterappend">       
                             <div class="form-group">
                                 <textarea class="form-control" name="ClientMessage"  id="ClientMessage" placeholder="Type your message here"></textarea>
                                 <a href="javascript:void(0);"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
                             </div>
                             <input type="submit" onclick="SendMessagetoUser()" />
                         </form>
                     </div>
                 </div>
                </div> 
                </div>   <!-- dashboard-content-inn  -->
             </div> 
<script type="text/javascript">

</script>

<script type="text/javascript">
    setInterval(function(){ GetMessages(); }, 4000);
    function shiftUsers(id){

        const parmt={
            _token:"{{csrf_token()}}",
            id:id,
            Greater:'',
        }
         $('#afterappend').val('');
        $('#UserId').val(id);
        $('#Message').html('');
         $('#displayFrom').show();
        
      }
     
</script>
<input type="hidden" name="UserId" id="UserId" >
<script type="text/javascript">
    function SendMessagetoUser(){
        if($('#ClientMessage').val().trim()==''){
           return false;
        }
        if($('#UserId').val().trim()==''){
            return false;
        }
        let id=$('#UserId').val();
        const parmt={
            _token:"{{csrf_token()}}",
            id:id,
            Message:$('#ClientMessage').val()
        }
        $.post('{{route("SendMessagetoUser")}}',parmt).then(function(msg){
            $('#ClientMessage').val('');
        })
    }

</script>
<script type="text/javascript">
    function GetMessages(){
        if($('#UserId').val().trim()==''){
            return false;
        }
        var appens='';
        const parmt={
            id:$('#UserId').val(),
            _token:"{{csrf_token()}}",
            Greater:$('#afterappend').val()
        }
        //console.log(parmt);
        $.post('{{route("getallMessages")}}',parmt).then(function(response){

            var obj=JSON.parse(response);
           
            for(var i=0;i<obj.length;i++){
                 $('#afterappend').val(obj[0].Maxid);
                if(obj[i].type=='2'){
                    var images="{{asset('')}}"+obj[i].img;
                    appens+='<article class="chat-list"><div class="chat-content"><figure style="background-image: url('+images+');"></figure><div class="content"><p>'+obj[i].message+'</p></div><span>'+obj[i].times+'</span></div></article>';
                }else{
                    var images="{{asset('')}}"+obj[i].img;
                    appens +='<article class="chat-list user-chat"><div class="chat-content"><figure style="background-image: url('+images+');"></figure><div class="content"><p>'+obj[i].message+'</p></div><span>'+obj[i].times+'</span></div></article>';
                }
            }
            //console.log(obj[0].Maxid);
           
            $('#Message').append(appens);

        })

    }
</script>
@endsection