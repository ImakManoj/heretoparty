@extends('VendorPanel.Userslayouts.apps')
@section('title','Business')
@section('content')
@php
  use App\Http\Controllers\Vender\VenderController;
@endphp

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>


  <div class="dashboard-content-wrap"> 
                <div class="dashboard-content-inner"> 

                <div class="white-box-shadow">
                    <div class="row-wrap">
                        <div class="d-title ">
                            <h3>My Business</h3>
                       </div>

                       <div class="bussiness-wrap">
                           <form action="{{route('createBusinessProfile')}}" method="post" enctype="multipart/form-data">
                           	@csrf
                                <div class="row">
                                    <div class="col-lg-6 form-group">
                                        <select class="form-control arrow-down" id="categories" name="categories" onchange="getSubCategory(this.value)">
                                            <option selected>Choose Category</option>
                                           	@foreach($Category as $ft)
                                           		<option value="{{$ft->id}}" @if($ft->id==@$vendor->category_id) {{'selected'}} @endif>{{$ft->category_name}}</option>
                                           	@endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <input id="bussiness_name" name="bussiness_name" type="text" class="form-control" placeholder="Business Name" value="{{@$vendor->vendor_name}}" />
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <div class="custom-file-upload form-control textarea-control">
                                            <!--<label for="file">File: </label>--> 
                                            <img src="{{@$vendor->vendor_logo}}"  class="custom-file-upload form-control textarea-control">
                                            <input type="file"  name="logo" id="logo" />
                                            <div class="overlay-uplaod">
                                                <a href="javascript:void(0);" class="plus-icon"></a>
                                                <p>Upload Company Logo</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <div class="custom-file-upload form-control textarea-control">
                                            <!--<label for="file">File: </label>--> 
                                              <img src="{{@$vendor->vendor_coverphoto}}"  class="custom-file-upload form-control textarea-control">
                                            <input type="file"  name="cover" id="cover" />
                                            <div class="overlay-uplaod">
                                                <a href="javascript:void(0);" class="plus-icon"></a>
                                                <p>Upload Cover Photo</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <input type="text" class="form-control" name="address" id="address" placeholder="Address"  value="{{@$vendor->vendor_address}}" />
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Contact Number"  value="{{@$vendor->vendor_contact}}"  />
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <input type="text" name="facebook" id="facebook" class="form-control facebook" placeholder="http://heretoparty.com/" value="{{@$vendor->facebook_url}}" />
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <input type="text" name="witter" id="witter" class="form-control twiter" placeholder="http://heretoparty.com/" value="{{@$vendor->vendor_twitter}}" />
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <input type="text" class="form-control insta" name="instragram" id="instragram" placeholder="http://heretoparty.com/" value="{{@$vendor->vendor_instragram}}" />
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <input type="text" name="websitelinks" id="websitelinks" class="form-control" placeholder="Website Link" value="{{@$vendor->vendor_website}}"  />
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <input type="text" name="videolink" id="videolink" class="form-control" placeholder="Video Link" value="{{@$vendor->vendor_video}}" />
                                    </div>
                                    
                                    <div class="col-lg-6 form-group">
                                        
                                             <select class="form-control" style="width:400px;" multiple="" name="taglist[]">
                                                  <option>Select Tags</option>
                                                  @foreach($tag as $ft)
                                                  @php
                                                  $tid=array();
                                                  if($taglist->tags_id!=''){
                                                    @$tid=explode(',',$taglist->tags_id);
                                                  }
                                                  @endphp

                                                 <option value="{{@$ft->id}}" @if(in_array($ft->id,$tid)) {{'selected'}} @endif>{{@$ft->tag_name}} </option>
                                                 @endforeach
                                                  </select>



                                  
                                        	<!-- @foreach($tag as $ft)
                                            <span class="tag">{{$ft->tag_name}} <a href="#"></a></span>
                                            <input type="hidden" name="taglist[]"  value="{{$ft->id}}">
                                            @endforeach -->
                                       
                                   
                                </div>
                                @php
                                  $i=0;
                                @endphp
                                @if(!$serviveNames->isEmpty())
                                @foreach($serviveNames as $serviveName)
                                @php
                                  $i++;
                                @endphp
                                <div id="shift_service_1">
                                <div class="bussness-list-wrap">
                                    <div class="row form-row">
                                        <div class="col-lg-3 form-group">
                                          <select  class="form-control" id="serviceName1" name="serviceName[]">
                                            <option value="">Select Service</option>
                                            @foreach($SubCategory as $row)
                                              <option value="{{$row->subid}}" @if($row->subid==$serviveName->service_name) {{'selected'}} @endif>{{$row->name}}</option>
                                            @endforeach
                                          </select>
                                            <input type="hidden" class="form-control"  name="serviceNamepdate[]" placeholder="Service Name" value="{{@$serviveName->id}}" />
                                         </div>
                                        <div class="col-lg-3 form-group">
                                            <input type="text" class="form-control" id="duration" name="duration[]" placeholder="Duration" value="{{@$serviveName->duration}}"  />
                                         </div>
                                        <div class="col-lg-3 form-group">
                                            <input type="text" class="form-control" id="hours" name="hours[]" placeholder="Operating Hours" value="{{@$serviveName->hours}}"  />
                                         </div>
                                        <div class="col-lg-3 form-group">
                                            <input type="text" class="form-control" id="price" name="price[]" placeholder="Price" value="{{@$serviveName->price}}" />
                                         </div>
                                          
                                        <div class="col-lg-12 form-group">
                                            <textarea class="form-control textarea-control"  placeholder="Description"  id="discription" name="discription[]"  >{{@$serviveName->description}}</textarea>
                                         </div>
                                          <input type="hidden" name="numberofservice[]" value="1">
                                         <div class="col-lg-12 multiple-upload-wrap">
                                             <p>Upload Images</p> 
                                             <div class="multiple">
                                               
                                                
                                                <div class="preview-images-zone">
                                                    <fieldset class="add-more">
                                                        <a href="javascript:void(0)" class="add-more-btn" onclick="$('#proimage{{$i}}').click()"></a>
                                                        <input type="file" id="proimage{{$i}}" name="proimage{{$i}}[]" class="form-control" style="display: none;" multiple>
                                                    </fieldset>
                                                    @php 
                                                      $serviceImages=VenderController::ServiceImages($serviveName->id);

                                                    @endphp
                                                    @if(!$serviceImages->isEmpty())
                                                      @foreach($serviceImages as $ft)
                                                    <div class="preview-image preview-show-1">
                                                        <div class="image-cancel" data-no="1"></div>
                                                        <div class="image-zone"><img id="pro-img-1" src="{{asset($ft->images)}}" /></div>
                                                        <div class="tools-edit-image"><a href="javascript:void(0)" data-no="1" class="btn btn-light btn-edit-image">edit</a></div>
                                                    </div>
                                                      @endforeach
                                                    @else
                                                    <div class="preview-image preview-show-1">
                                                        <div class="image-cancel" data-no="1"></div>
                                                        <div class="image-zone"><img id="pro-img-1" src="../images/upload-img-1.jpg" alt="uplaod-img-jpg" /></div>
                                                        <div class="tools-edit-image"><a href="javascript:void(0)" data-no="1" class="btn btn-light btn-edit-image">edit</a></div>
                                                    </div>
                                                    @endif
                                                </div>
                                             </div>
                                         </div>
                                        <!--  <div class="col-lg-12 form-group multiple-upload-wrap">
                                            <p>Upload Images</p>
                                            <div class="multiple">
                                               
                                                
                                                <div class="preview-images-zone">
                                                    <fieldset class="add-more">
                                                        <a href="javascript:void(0)" class="add-more-btn" onclick="$('#pro-image-2').click()"></a>
                                                        <input type="file" id="pro-image-2" name="pro-image-2" style="display: none;" class="form-control" multiple>
                                                    </fieldset>
                                                    <div class="preview-image preview-show-2">
                                                        <div class="image-cancel" data-no="1"></div>
                                                        <div class="image-zone"><img id="pro-img-2" src="../images/upload-img-1.jpg" alt="uplaod-img-jpg" /></div>
                                                        <div class="tools-edit-image"><a href="javascript:void(0)" data-no="1" class="btn btn-light btn-edit-image">edit</a></div>
                                                    </div>
                                                    
                                                </div>
                                             </div>
                                        </div> -->

                                       
                                    </div>
                                    <span id="buttonClose_1">
                                    <a class="add-more-box"  onclick="AppendDiv()"></a>
                                    </span>
                                </div>
                              </div>
                              @endforeach
                              @else

                              <div id="shift_service_1">
                                <div class="bussness-list-wrap">
                                    <div class="row form-row">
                                        <div class="col-lg-3 form-group" id="replace">
                                            <select  class="form-control" id="serviceName" name="serviceName[]">
                                            <option value="">Select Service</option>
                                          </select>


                                            <!-- <input type="text" class="form-control" id="serviceName" name="serviceName[]" placeholder="Service Name" value="{{@$serviveName->service_name}}" /> -->
                                         </div>
                                        <div class="col-lg-3 form-group">
                                            <input type="text" class="form-control" id="duration" name="duration[]" placeholder="Duration" value="{{@$serviveName->duration}}"  />
                                         </div>
                                        <div class="col-lg-3 form-group">
                                            <input type="text" class="form-control" id="hours" name="hours[]" placeholder="Operating Hours" value="{{@$serviveName->hours}}"  />
                                         </div>
                                        <div class="col-lg-3 form-group">
                                            <input type="text" class="form-control" id="price" name="price[]" placeholder="Price" value="{{@$serviveName->price}}" />
                                         </div>
                                          
                                        <div class="col-lg-12 form-group">
                                            <textarea class="form-control textarea-control"  placeholder="Description"  id="discription" name="discription[]" ></textarea>
                                         </div>
                                          <input type="hidden" name="numberofservice[]" value="1">
                                         <div class="col-lg-12 multiple-upload-wrap">
                                             <p>Upload Images</p> 
                                             <div class="multiple">
                                               
                                                
                                                <div class="preview-images-zone">
                                                    <fieldset class="add-more">
                                                        <a href="javascript:void(0)" class="add-more-btn" onclick="$('#proimage').click()"></a>
                                                        <input type="file" id="proimage" name="proimage1[]" class="form-control" style="display: none;" multiple>
                                                    </fieldset>
                                                    <div class="preview-image preview-show-1">
                                                        <div class="image-cancel" data-no="1"></div>
                                                        <div class="image-zone"><img id="pro-img-1" src="../images/upload-img-1.jpg" alt="uplaod-img-jpg" /></div>
                                                        <div class="tools-edit-image"><a href="javascript:void(0)" data-no="1" class="btn btn-light btn-edit-image">edit</a></div>
                                                    </div>
                                                    
                                                </div>
                                             </div>
                                         </div>
                                       <!--   <div class="col-lg-12 form-group multiple-upload-wrap">
                                            <p>Upload Images</p>
                                            <div class="multiple">
                                               
                                                
                                                <div class="preview-images-zone">
                                                    <fieldset class="add-more">
                                                        <a href="javascript:void(0)" class="add-more-btn" onclick="$('#pro-image-2').click()"></a>
                                                        <input type="file" id="pro-image-2" name="pro-image-2" style="display: none;" class="form-control" multiple>
                                                    </fieldset>
                                                    <div class="preview-image preview-show-2">
                                                        <div class="image-cancel" data-no="1"></div>
                                                        <div class="image-zone"><img id="pro-img-2" src="../images/upload-img-1.jpg" alt="uplaod-img-jpg" /></div>
                                                        <div class="tools-edit-image"><a href="javascript:void(0)" data-no="1" class="btn btn-light btn-edit-image">edit</a></div>
                                                    </div>
                                                    
                                                </div>
                                             </div>
                                        </div> -->

                                       
                                    </div>
                                   <span id="buttonClose_1">
                                    <a class="add-more-box"  onclick="AppendDiv()"></a>
                                    </span>
                                </div>
                              </div>


                              @endif
                                <div id="divappends" > </div>
                                 <div class="col-lg-12 button-wrap" style="margin-top: 1em;">
                                          <input type="submit" name="submit" class="btn btn-default btn-capitalize" value="Submit">
                                 </div>
                           </form>
                       </div>
                   </div>
                </div> 
                </div>   <!-- dashboard-content-inn  -->
             </div>    <!-- dashboard-content-wrap  -->

 <script type="text/javascript">
      $(".livesearch").chosen();
</script>
<script type="text/javascript">
  var i=1;
function AppendDiv(){
  $('#buttonClose_'+i).html('<a class="closeservice add-more-box" onclick="removeDiv('+i+')">X<a>');
  i++;
  const parmt={
    i:i,
    cat:$('#categories').val()
  }
  $.get('pages',parmt).then(function(response){
    $('#divappends').append('<div id="shift_service_'+i+'">'+response+'</div>');
  })
  
}

function removeDiv(i){
   $('#shift_service_'+i).remove();
   $('#buttonClose_'+i).html('<a class="add-more-box"  onclick="AppendDiv()"></a>');
     console.log(i);
 
}
</script>
<script type="text/javascript">
  function getSubCategory(id){
    const parmt={
      id:id,
      _token:"{{csrf_token()}}"
    }
    $.post('{{route("getSubCategory")}}',parmt).then(function(response){
      $('#replace').html(response);
      
    })
  }
</script>
<style type="text/css">
  .closeservice.add-more-box:after {
    content: '';
    width: 24px;
    height: 2px;
     background: none !important;
}
.closeservice.add-more-box:before {
    content: '';
    width: 24px;
      height: 24px;
     background: none !important;
    position: relative;
    left: 13px;
}
</style>
@endsection