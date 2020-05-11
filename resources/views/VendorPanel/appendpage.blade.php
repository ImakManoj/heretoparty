                                <div class="bussness-list-wrap" style="margin-top: 1em">
                                    <div class="row form-row">
                                        <div class="col-lg-3 form-group">
                                            <select  class="form-control" id="serviceName" name="serviceName[]">
                                                <option value="">Select Service</option>
                                                <?php foreach($Services as $ft){ ?>
                                                    <option value="<?php echo $ft->id; ?>"><?php echo $ft->name; ?></option>
                                                <?php } ?>
                                                </select>
                                         </div>
                                        <div class="col-lg-3 form-group">
                                            <input type="text" class="form-control" name="duration[]" placeholder="Duration" value="{{@$serviveName->duration}}"  />
                                         </div>
                                        <div class="col-lg-3 form-group">
                                            <input type="text" class="form-control"  name="hours[]" placeholder="Operating Hours" value="{{@$serviveName->hours}}"  />
                                         </div>
                                        <div class="col-lg-3 form-group">
                                            <input type="text" class="form-control"  name="price[]" placeholder="Price" value="{{@$serviveName->price}}" />
                                         </div>
                                          
                                        <div class="col-lg-12 form-group">
                                            <textarea class="form-control textarea-control"  placeholder="Description"   name="discription[]" value="{{@$serviveName->description}}" ></textarea>
                                         </div>

                                         <div class="col-lg-12 multiple-upload-wrap">
                                             <p>Upload Images</p> 
                                             <div class="multiple">
                                               <input type="hidden" name="numberofservice[]" value="{{ Request::get('i') }}">
                                                
                                                <div class="preview-images-zone">
                                                    <fieldset class="add-more">
                                                        <a href="javascript:void(0)" class="add-more-btn" onclick="$('#proimage_{{ Request::get('i') }}').click()"></a>
                                                        <input type="file" id="proimage_{{ Request::get('i') }}" name="proimage{{ Request::get('i') }}[]" class="form-control" style="display: none;" multiple>
                                                    </fieldset>
                                                    <div class="preview-image preview-show-1">
                                                        <div class="image-cancel" data-no="1"></div>
                                                        <div class="image-zone"><img id="pro-img-1" src="../images/upload-img-1.jpg" alt="uplaod-img-jpg" /></div>
                                                        <div class="tools-edit-image"><a href="javascript:void(0)" data-no="1" class="btn btn-light btn-edit-image">edit</a></div>
                                                    </div>
                                                    
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

                                   <span id="buttonClose_{{ Request::get('i') }}">
                                    <a class="add-more-box"  onclick="AppendDiv()"></a>
                                    </span>
                                </div>