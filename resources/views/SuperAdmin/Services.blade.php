@extends('SuperAdmin.layouts.app')
@section('title', 'SERVICES')
@include('SuperAdmin.default.header')
@include('SuperAdmin.default.sidebar')
@section('content')
<div class="main-panel">
  <div class="content">
    <div class="page-inner">
      @if ($message = Session::get('message'))
      <div class="alert alert-warning alert-block">
       <button type="button" class="close" data-dismiss="alert">×</button>  
       <strong>{{ $message }}</strong>
     </div>
     @endif
   @if ($error = Session::get('error'))
        <div class="alert alert-danger alert-block">
         <button type="button" class="close" data-dismiss="alert">×</button>  
         <strong>{{ $error }}</strong>
       </div>
       @endif

     <div class="page-header">
      <h4 class="page-title">Services</h4> 
    </div>  
    <div class="row">
      <div class="col-md-3">
        <ul class="list-group">
          <li class="list-group-item" id="active" onclick="filter('Banner')">Banner</li>
          <li class="list-group-item" onclick="filter('Welcome')">Welcome</li>
          <li class="list-group-item" onclick="filter('ServicesWeDealIn')">Services We Deal In</li>
          <li class="list-group-item" onclick="filter('HairforWomen')">Hair for Women</li>
          <li class="list-group-item" onclick="filter('HairforMen')">Hair for Men</li>
          <li class="list-group-item" onclick="filter('Massage')">Massage</li>
          <li class="list-group-item" onclick="filter('Makeup')">Makeup</li>
          <li class="list-group-item" onclick="filters('MeetOurProfessional')">Meet Our Professional</li>
          <li class="list-group-item" onclick="filteres('OurPortfolio')">Our Portfolio</li>
          <li class="list-group-item" onclick="filter('Gallery')">Portfolio Gallery</li>
        </ul>
      </div>

      <div class="col-md-9">

<!-- Banner Implement -->
        <section id="Banner">
           <form action="{{route('SubmitSelectServiceServices')}}" method="post" enctype="multipart/form-data">
            <div class="row">
              @csrf
              <div class="col-md-12">
               <input type="hidden" name="BannerServiceId" id="BannerServiceId">
             </div>
             <div class="col-md-12" > 
              <label>Containt</label>
              <textarea  name="BannerText" id="BannerText" placeholder="Our Services" class="form-control ckeditor"></textarea>
            </div>
            <div class="col-md-12" >
              <label>Select Image</label>
              <input type="file" name="Services" id="Services" placeholder="Our Services" class="form-control">
            </div>
            <div class="col-md-12">
              <input type="submit" name="SaveOurService" id="SaveOurService" value="Save" class="btn btn-primary sm-btn pull-right">
            </div>
          </div>
        </form>
        </section>

<!-- Welcome Implement -->
        <section id="Welcome">
           <form action="{{route('SubmitSelectServiceServices')}}" method="post" enctype="multipart/form-data">
            <div class="row">
              @csrf
              <div class="col-md-12">
               <input type="hidden" name="welcomeupdateid" id="welcomeupdateid">
             </div>
             <div class="col-md-12"> 
              <label>Containt</label>
              <textarea  name="WelcomeText" id="WelcomeText" placeholder="Our Services" class="form-control ckeditor"></textarea>
            </div>
            <div class="col-md-12">
              <input type="submit" name="SaveOurService" id="SaveOurService" value="Save" class="btn btn-primary sm-btn pull-right">
            </div>
          </div>
        </form>
        </section>

<!-- Service We Details Implement -->
        <section id="ServicesWeDealIn">
            <form action="{{route('SubmitSelectServiceServices')}}" method="post" enctype="multipart/form-data">
            <div class="row">
              @csrf
              <div class="col-md-12">
               <input type="hidden" name="wedealinupdateid" id="wedealinupdateid">
             </div>
             <div class="col-md-12"> 
              <label>Containt</label>
              <textarea  name="WeDealInText" id="WeDealInText" placeholder="Our Services" class="form-control ckeditor"></textarea>
            </div>
            <div class="col-md-12">
              <input type="submit" name="SaveOurService" id="SaveOurService" value="Save" class="btn btn-primary sm-btn pull-right">
            </div>
          </div>
        </form>
        </section>


<!-- Hair for Woman  Implement -->
        <section id="HairforWomen">
            <form action="{{route('SubmitSelectServiceServices')}}" method="post" enctype="multipart/form-data">
            <div class="row">
              @csrf
              <div class="col-md-12">
               <input type="hidden" name="hairforwomanupdateid" id="hairforwomanupdateid">
             </div>
             <div class="col-md-12"> 
              <label>Our Services</label>
              <textarea  name="WomenText" id="WomenText" placeholder="Our Services" class="form-control ckeditor"></textarea>
            </div>
            <div class="col-md-12">
              <input type="submit" name="SaveOurService" id="SaveOurService" value="Save" class="btn btn-primary sm-btn pull-right">
            </div>
          </div>
        </form>
        </section>

<!-- Hair for Man Implement -->
        <section id="HairforMen">
            <form action="{{route('SubmitSelectServiceServices')}}" method="post" enctype="multipart/form-data">
            <div class="row">
              @csrf
              <div class="col-md-12">
               <input type="hidden" name="hairformanupdateid" id="hairformanupdateid">
             </div>
             <div class="col-md-12"> 
              <label>Our Services</label>
              <textarea  name="MenText" id="MenText" placeholder="Our Services" class="form-control ckeditor"></textarea>
            </div>
            <div class="col-md-12">
              <input type="submit" name="SaveOurService" id="SaveOurService" value="Save" class="btn btn-primary sm-btn pull-right">
            </div>
          </div>
        </form>
        </section>

<!-- Massage Implement -->
        <section id="Massage">
            <form action="{{route('SubmitSelectServiceServices')}}" method="post" enctype="multipart/form-data">
            <div class="row">
              @csrf
              <div class="col-md-12">
               <input type="hidden" name="serviceidMassage" id="serviceidMassage">
             </div>
             <div class="col-md-12"> 
              <label>Our Services</label>
              <textarea  name="MassageText" id="MassageText" placeholder="Our Services" class="form-control ckeditor"></textarea>
            </div>
            <div class="col-md-12">
              <input type="submit" name="SaveOurService" id="SaveOurService" value="Save" class="btn btn-primary sm-btn pull-right">
            </div>
          </div>
        </form>
        </section>

<!-- Makeup Implement -->
        <section id="Makeup">
            <form action="{{route('SubmitSelectServiceServices')}}" method="post" enctype="multipart/form-data">
            <div class="row">
              @csrf
              <div class="col-md-12">
               <input type="hidden" name="serviceidMakeup" id="serviceidMakeup">
             </div>
             <div class="col-md-12"> 
              <label>Our Services</label>
              <textarea  name="MakeupText" id="MakeupText" placeholder="Our Services" class="form-control ckeditor"></textarea>
            </div>
            <div class="col-md-12">
              <input type="submit" name="SaveOurService" id="SaveOurService" value="Save" class="btn btn-primary sm-btn pull-right">
            </div>
          </div>
        </form>
        </section>

<!-- Meeat Professional Implement -->
        <section id="MeetOurProfessional">
             <form action="{{route('SubmitSelectServiceServices')}}" method="post" enctype="multipart/form-data">
        <div class="row">
          @csrf
          <div class="col-md-12">
           <input type="hidden" name="serviceidProfessional" id="serviceidProfessional">
         </div>
         <div class="col-md-12" id="ourserviceContainer"> 
          <label>Our Services</label>
          <textarea  name="OurServicesText" id="OurServicesText" placeholder="Our Services" class="form-control ckeditor"></textarea>
        </div>
       

        <div style="width: 100%;margin-top: 2em" id="imageourserviceContainer">
          <h3 style="font-weight: bold;background: antiquewhite;padding: 10px;font-family: new roam time;">Add new Our Professional</h3>
        <div class="row" >
        <div class="col-md-5">
          <label>Our Professional</label>
          <input type="file" name="Servicesimg[]" id="Servicesimg" placeholder="Our Services" class="form-control">
        </div>
        <div class="col-md-5">
          <label>Nane</label>
          <input type="text" name="ServicesUserName[]" id="ServicesUserName_1" placeholder="Nane" class="form-control">
        </div>
        <div class="col-md-2">
          <label>&nbsp;</label>
          <span class="btn btn-danger btn-sm" style="margin-top: 2em" onclick="AddProfination()">Add</span>
        </div>
      </div>
    </div>
        <div id="Shiftdivs" style="width: 100%"></div>
        <div class="col-md-12">
          <input type="submit" name="SaveOurService" id="SaveOurService" value="Save" class="btn btn-primary sm-btn pull-right">
        </div>
      </div>
    </form>
        </section>

<!-- Our Protfolio Implement -->
        <section id="OurPortfolio">
            <form action="{{route('SubmitSelectServiceServices')}}" method="post" enctype="multipart/form-data">
            <div class="row">
              @csrf
              <div class="col-md-12">
               <input type="hidden" name="serviceidOurPortfolio" id="serviceidOurPortfolio">
             </div>
             <div class="col-md-12" id="displayNew"> 
              <label>Our Portfolio</label>
              <textarea  name="PortfoliosText" id="PortfoliosText" placeholder="Our Services" class="form-control ckeditor"></textarea>
            </div>
            <div class="row" id="displayNew1" style="width: 100%">
            <div class="col-md-6">
              <div class="form-group">
              <label>Category</label>
             <select id="getall_category" name="getall_category" class="form-control"></select>
            </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
              <label>Select Image</label>
              <input type="file" name="Servicesport[]" id="Services" placeholder="Our Services" class="form-control" multiple="">
            </div>
            </div>
          </div>
            <div class="col-md-12">
              <input type="submit" name="SaveOurService" id="SaveOurService" value="Save" class="btn btn-primary sm-btn pull-right">
            </div>
          </div>
        
        </form>
        </section>

<!--Gallery Implement -->
        <section id="Gallery">
            <form action="{{route('SubmitSelectServiceServices')}}" method="post" enctype="multipart/form-data">
            <div class="row">
              @csrf
              <div class="col-md-12">
              <!--  <label>Service Name</label>
               <input type="text" name="serviceName" id="serviceName" placeholder="Service Name" class="form-control"> -->
               <input type="hidden" name="serviceid" id="serviceid">
             </div>
             <div class="col-md-12"> 
              <label>Our Services</label>
              <textarea  name="GalleryText" id="GalleryText" placeholder="Our Services" class="form-control ckeditor"></textarea>
            </div>
            <div class="col-md-12">
              <label>Select Image</label>
              <input type="file" name="Services" id="Services" placeholder="Our Services" class="form-control">
            </div>
            <div class="col-md-12">
              <input type="submit" name="SaveOurService" id="SaveOurService" value="Save" class="btn btn-primary sm-btn pull-right">
            </div>
          </div>
        </form>
        </section>

      


        <section id="SelectItems">
          <!-- <form action="{{route('SubmitSelectServiceServices')}}" method="post" enctype="multipart/form-data">
            <div class="row">
              @csrf
              <div class="col-md-12">
               <label>Service Name</label>
               <input type="text" name="serviceName" id="serviceName" placeholder="Service Name" class="form-control">
               <input type="hidden" name="serviceid" id="serviceid">
             </div>
             <div class="col-md-12"> 
              <label>Our Services</label>
              <textarea  name="OurServicesText" id="OurServicesText" placeholder="Our Services" class="form-control ckeditor"></textarea>
              <input type="hidden" name="OurServicePage" value="Our Services">
            </div>
            <div class="col-md-12">
              <label>Select Image</label>
              <input type="file" name="Services" id="Services" placeholder="Our Services" class="form-control">
            </div>
            <div class="col-md-12">
              <input type="submit" name="SaveOurService" id="SaveOurService" value="Save" class="btn btn-primary sm-btn pull-right">
            </div>
          </div>
        </form> -->
      </section>
      <section id="SelectIteme2">
        <form action="{{route('SubmitSelectServiceGallery')}}" method="post" enctype="multipart/form-data">
          <div class="row">
            @csrf
            <div class="col-md-12">
             <label>Service Type</label>
             <select name="serviceNametype" id="serviceNametype" placeholder="Service Name" class="form-control" required="">
               <option value="">Select Type</option>
               <option value="man">Man's Hair</option>
               <option value="woman">Woman's Hair</option>
               <option value="makeup">Makeup</option>
               <option value="massage">Massage</option>
             </select>
             <input type="hidden" name="serviceidss" id="serviceidss">
           </div>

           <div class="col-md-12">
            <label>Select Image</label>
            <input type="file" name="ServicesGallery[]" id="ServicesGallery" placeholder="Our Services" class="form-control" multiple="">
          </div>
          <div class="col-md-12">
            <input type="submit" name="SaveOurService" id="SaveOurService" value="Save" class="btn btn-primary sm-btn pull-right">
          </div>
        </div>
      </form>
    </section>
    <div >
      <span id="onlyshow" class="btn btn-danger btn-sm" onclick="ContainerServiceUpdate(27,'yes')" style="display: none;float: right;">New Professional</span>
      <span id="onlyshow1" class="btn btn-danger btn-sm" onclick="ContainerServiceUpdate1(28,'yes')" style="display: none;float: right;">New Portfolio</span>
      <table class="table mt-3" id="example">
        <thead>
          <tr>
            <th>S.No.</th>
            <th style="width: 20%">Page Name</th>
            <th style="width: 50%">Content</th>
            <th>Images</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="displaydetails">

        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
</div>
</div>
<input type="hidden" name="storetyep" id="storetyep">
<style type="text/css">
  section{
    display:none;
  }
  #displaydetails{
    display:none;
  }
</style>

<script type="text/javascript">
  function filter(id){
    $('#onlyshow').hide();
   $('section').css('display','none');
   if(id!=''){  
    $('#storetyep').val(id);
    //GetDetails(id);
    if(id=="Gallery"){
      GetDetailsGallery(id);
    }else{
      GetDetails(id);
    }
  }
}
</script>
<style type="text/css">
  .btn-primary{
    margin-top: 1.3em;
  }
</style>
<script type="text/javascript">
  function GetDetails(id){
    const parmt={
      _token:'{{csrf_token()}}',
      id:id
    }
    $.post("{{route('GetServices')}}",parmt).then(function(response){
      $('#displaydetails').html(response);   
      $('#displaydetails').show(); 
    })
  }
</script>
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
  CKEDITOR.replace( 'ckeditor' );
</script>
<script type="text/javascript">
  function EditDetails(id){
    const parmt={
      values:id,
      _token:"{{csrf_token()}}",
    }
  
$.post('{{route("EditFrontHome")}}',parmt).then(function(response){
        var filters=$('#storetyep').val();
        if(filters=="Banner"){
            $('section').attr('display','none');
            CKEDITOR.instances['BannerText'].setData(response[0].content_statument);
            $('#BannerServiceId').val(response[0].content_id);
            $('#Banner').show();

        }else if(filters=="Welcome"){
            $('section').attr('display','none');
            CKEDITOR.instances['WelcomeText'].setData(response[0].content_statument);
            $('#welcomeupdateid').val(response[0].content_id);
            $('#Welcome').show();

        }else if(filters=="ServicesWeDealIn"){
            $('section').attr('display','none');
            CKEDITOR.instances['WeDealInText'].setData(response[0].content_statument);
            $('#wedealinupdateid').val(response[0].content_id);
            $('#ServicesWeDealIn').show();

        }else if(filters=="HairforWomen"){
            $('section').attr('display','none');
            CKEDITOR.instances['WomenText'].setData(response[0].content_statument);
            $('#hairforwomanupdateid').val(response[0].content_id);
            $('#HairforWomen').show();

        }else if(filters=="HairforMen"){
            $('section').attr('display','none');
            CKEDITOR.instances['MenText'].setData(response[0].content_statument);
            $('#hairformanupdateid').val(response[0].content_id);
            $('#HairforMen').show();

        }else if(filters=="Massage"){
            $('section').attr('display','none');
            CKEDITOR.instances['MassageText'].setData(response[0].content_statument);
            $('#serviceidMassage').val(response[0].content_id);
            $('#Massage').show();

        }else if(filters=="Makeup"){
            $('section').attr('display','none');
            CKEDITOR.instances['MakeupText'].setData(response[0].content_statument);
            $('#serviceidMakeup').val(response[0].content_id);
            $('#Makeup').show();

        }else if(filters=="MeetOurProfessional"){
            $('section').attr('display','none');
            CKEDITOR.instances['OurServicesText'].setData(response[0].content_statument);
            $('#serviceidProfessional').val(response[0].content_id);
            $('#MeetOurProfessional').show();

        }else if(filters=="OurPortfolio"){
            $('section').attr('display','none');
            CKEDITOR.instances['PortfoliosText'].setData(response[0].content_statument);
            $('#serviceidOurPortfolio').val(response[0].content_id);
            $('#OurPortfolio').show();

        }else if(filters=="Gallery"){
            $('section').attr('display','none');
            CKEDITOR.instances['GalleryText'].setData(response[0].content_statument);
            $('#serviceid').val(response[0].content_id);
            $('#Gallery').show();
        }

  /*$('#serviceName').val(response[0].content_title);



  if(response[0].frontpage_title=='Gallery'){
   $('#serviceidss').val(response[0].content_id);
   $('#SelectIteme2').show();
 }else{
  $('#SelectItems').show();
}
*/


})

}
</script>
<script type="text/javascript">
  function GetDetailsGallery(id){
    const parmt={
      _token:'{{csrf_token()}}',
      id:id
    }
    $.post("{{route('GetDetailsGallery')}}",parmt).then(function(response){
      $('#displaydetails').html(response);   
      $('#displaydetails').show(); 
    })
  }
</script>
 
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
  var i=1;
  function AddProfination(){
    i++;
    $('#Shiftdivs').append('<div class="row" id="removes_'+i+'"><div class="col-md-5"> <label>Select Image</label><input type="file" name="Servicesimg[]" id="Servicesimg_'+i+'" placeholder="Our Services" class="form-control"></div><div class="col-md-5"><label>Nane</label><input type="text" name="ServicesUserName[]" id="ServicesUserName_'+i+'" placeholder="Nane" class="form-control"></div><div class="col-md-2"><label>&nbsp;</label><span class="btn btn-default btn-sm" style="margin-top: 2em" onclick="RemoveServiceName('+i+')" style="background-color:black">Delete</span></div></div>');
  }
</script>
<script type="text/javascript">
  function RemoveServiceName(id){
      $('#removes_'+id).remove();
  }
</script>

<script type="text/javascript">
  function filters(id){
     $('section').css('display','none');
    $('#onlyshow1').hide();
    $('#onlyshow').show();
    const parmt={
      _token:'{{csrf_token()}}',
      id:id
    }
    $.post("{{route('GetServiceses')}}",parmt).then(function(response){
      $('#displaydetails').html(response);   
      $('#displaydetails').show(); 
    })
  }
</script>


<script type="text/javascript">
  function filteres(id){
    $('section').css('display','none');
     $('section').css('display','none !important');
    $('#onlyshow').hide();
    $('#onlyshow1').show();
    const parmt={
      _token:'{{csrf_token()}}',
      id:id
    }
    $.post("{{route('GetProtflio')}}",parmt).then(function(response){
      $('#displaydetails').html(response);   
      $('#displaydetails').show(); 
    })
  }
</script>




<script type="text/javascript">
  function ContainerServiceUpdate(id,status){
    const parmt={
      id:id,
      _token:"{{csrf_token()}}"
    }
    $.post('{{route("GetSearvicesDetails")}}',parmt).then(function(response){
        $('section').attr('display','none');
           CKEDITOR.instances['OurServicesText'].setData(response[0].content_statument);
           $('#serviceidProfessional').val(response[0].content_id);
           $('#MeetOurProfessional').show();
           if(status=='yes'){
            $('#ourserviceContainer').hide();
           $('#imageourserviceContainer').show();
           }else{
            $('#ourserviceContainer').show();
           $('#imageourserviceContainer').hide();
           }
          
    })
  }
</script>



<script type="text/javascript">
  function ContainerServiceUpdate1(id,status){
    const parmt={
      id:id,
      _token:"{{csrf_token()}}"
    }
    $.post('{{route("GetSearvicesDetails")}}',parmt).then(function(response){
        $('section').attr('display','none');
           CKEDITOR.instances['PortfoliosText'].setData(response[0].content_statument);
           $('#serviceidOurPortfolio').val(response[0].content_id);
           $('#OurPortfolio').show();
           if(status=='yes'){
            $('#displayNew1').show();
           $('#displayNew').hide();
           }else{
            $('#displayNew1').hide();
           $('#displayNew').show();
           }
          
    })
  }
</script>



<script type="text/javascript">
  function GalleryImagesDelete(id){
  swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this records!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
      const parmt={
      id:id,
      _token:"{{csrf_token()}}"
    }
    $.post('{{route("DeleteOurProfination")}}',parmt).then(function(response){
      $('#hide_'+id).hide();
    })

    swal("Poof! Your records has been deleted!", {
    icon: "success",
    });
  } else {
    swal("Your records file is safe!");
  }
});


  }
</script>

<script type="text/javascript">
  $(document).ready(function(){
    const parmt={
      _token:"{{csrf_token()}}",
    }
    $.post('{{route("GetCategoryAdmin")}}',parmt).then(function(response){
      console.log(response);
      $('#getall_category').html(response);
    })
  })
</script>
<style type="text/css">
  li{
    cursor: pointer;
  }
</style>
<script type="text/javascript">
  $(document).ready(function(){
    $('#active').click();
  })
</script>

@include('SuperAdmin.default.footer')
@endsection