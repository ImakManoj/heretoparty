@extends('UserDashboard.Userslayouts.apps')
@section('title','My Business')
@section('content')

               <div class="dashboard-content-wrap"> 
                <div class="dashboard-content-inner"> 

                <div class="white-box-shadow">
                    <div class="row-wrap">
                        <div class="d-title ">
                            <h3>My Business</h3>
                       </div>

                       <div class="bussiness-wrap">
                           <form>
                                <div class="row">
                                    <div class="col-lg-6 form-group">
                                        <select class="form-control arrow-down">
                                            <option selected>Choose Category</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <input type="text" class="form-control" placeholder="Business Name" />
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <div class="custom-file-upload form-control textarea-control">
                                            <!--<label for="file">File: </label>--> 
                                            <input type="file"  name="file" />
                                            <div class="overlay-uplaod">
                                                <a href="javascript:void(0);" class="plus-icon"></a>
                                                <p>Upload Company Logo</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <div class="custom-file-upload form-control textarea-control">
                                            <!--<label for="file">File: </label>--> 
                                            <input type="file"  name="file" />
                                            <div class="overlay-uplaod">
                                                <a href="javascript:void(0);" class="plus-icon"></a>
                                                <p>Upload Cover Photo</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <input type="text" class="form-control" placeholder="Address" />
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <input type="text" class="form-control" placeholder="Contact Number" />
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <input type="text" class="form-control facebook" placeholder="http://heretoparty.com/" />
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <input type="text" class="form-control twiter" placeholder="http://heretoparty.com/" />
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <input type="text" class="form-control insta" placeholder="http://heretoparty.com/" />
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <input type="text" class="form-control" placeholder="Website Link" />
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <input type="text" class="form-control" placeholder="Video Link" />
                                    </div>
                                    
                                    <div class="col-lg-6 form-group">
                                        <div class="form-control form-tags-wrap">
                                            <span class="tag">Wedding <a href="#"></a></span>
                                            <span class="tag">Wedding <a href="#"></a></span>
                                            <span class="tag">Wedding <a href="#"></a></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bussness-list-wrap">
                                    <div class="row form-row">
                                        <div class="col-lg-3 form-group">
                                            <input type="text" class="form-control" placeholder="Service Name" />
                                         </div>
                                        <div class="col-lg-3 form-group">
                                            <input type="text" class="form-control" placeholder="Duration" />
                                         </div>
                                        <div class="col-lg-3 form-group">
                                            <input type="text" class="form-control" placeholder="Operating Hours" />
                                         </div>
                                        <div class="col-lg-3 form-group">
                                            <input type="text" class="form-control" placeholder="Price" />
                                         </div>
                                          
                                        <div class="col-lg-12 form-group">
                                            <textarea class="form-control textarea-control"  placeholder="Description"  ></textarea>
                                         </div>

                                         <div class="col-lg-12 multiple-upload-wrap">
                                             <p>Upload Images</p> 
                                             <div class="multiple">
                                               
                                                
                                                <div class="preview-images-zone">
                                                    <fieldset class="add-more">
                                                        <a href="javascript:void(0)" class="add-more-btn" onclick="$('#pro-image').click()"></a>
                                                        <input type="file" id="pro-image" name="pro-image" style="display: none;" class="form-control" multiple>
                                                    </fieldset>
                                                    <div class="preview-image preview-show-1">
                                                        <div class="image-cancel" data-no="1"></div>
                                                        <div class="image-zone"><img id="pro-img-1" src="../images/upload-img-1.jpg" alt="uplaod-img-jpg" /></div>
                                                        <div class="tools-edit-image"><a href="javascript:void(0)" data-no="1" class="btn btn-light btn-edit-image">edit</a></div>
                                                    </div>
                                                    
                                                </div>
                                             </div>
                                         </div>
                                         <div class="col-lg-12 form-group multiple-upload-wrap">
                                            <p>Upload Images</p>
                                            <div class="multiple">
                                               
                                                
                                                <div class="preview-images-zone">
                                                    <fieldset class="add-more">
                                                        <a href="javascript:void(0)" class="add-more-btn" onclick="$('#pro-image-2').click()"></a>
                                                        <input type="file" id="pro-image-2" name="pro-image-2" style="display: none;" class="form-control" multiple>
                                                    </fieldset>
                                                    <div class="preview-image preview-show-1">
                                                        <div class="image-cancel" data-no="1"></div>
                                                        <div class="image-zone"><img id="pro-img-2" src="../images/upload-img-1.jpg" alt="uplaod-img-jpg" /></div>
                                                        <div class="tools-edit-image"><a href="javascript:void(0)" data-no="1" class="btn btn-light btn-edit-image">edit</a></div>
                                                    </div>
                                                    
                                                </div>
                                             </div>
                                        </div>

                                        <div class="col-lg-12 button-wrap">
                                            <a href="#" class="btn btn-default btn-capitalize ">Submit</a>
                                        </div>
                                    </div>

                                    <a href="#" class="add-more-box"></a>
                                </div>
                           </form>
                       </div>
                   </div>
                </div> 
                </div>   <!-- dashboard-content-inn  -->
             </div>    <!-- dashboard-content-wrap  -->


            <!-- dashboard-content-wrap  -->
@endsection
    

  