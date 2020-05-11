@extends('website.layouts.app')
@section('title','Careers')
@section('content')
@php

use App\Http\Controllers\Pages\pageController;
$getTimes=pageController::getTimes();
@endphp
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

  <section class="section">
            <article class="container">
                <h2 class="heading text-left">Requesting Quotes</h2>

                <h6>The User has:</h6>

                <div class="list-item">
                    <ul>
                        <li>Searched for (e.g. "catering) services/categories</li>
                        <li>Viewed profiles of vendors (details, menu</li>
                        <li>Viewed profiles of vendors (details, menu</li>
                        <li>Selected services they want included in their quote (e.g. Menu 2 + Delivery + Waitresses)
                        </li>
                        <li>Selected the vendors they want to receive a quote from</li>
                    </ul>
                </div>

                <div class="create-event-section">

                    <h4>Your Created Event: 
                        <div class="col-sm-3 form-group">
                        <input type="text" name="eventName" id="eventName" class="form-control" placeholder="Enter Event Name " required="">
                    </div>
                    </h4>
                  <form action="{{route('saveQuotes')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="elem-left">
                            <h5>Category:</h5>
                            <ul>
                                @if(!$response->isEmpty())
                                  
                                <li class="form-group checkbox-group">
                                    <label>
                                        <input type="checkbox" checked="">
                                        <span class="custom-checkbox"></span>
                                        {{$response[0]->vendor_name}}
                                    </label>
                                </li>
                                   
                                @endif
                            </ul>

                            <h5>Vendor:</h5>
                            <ul>
                                @if(!$response->isEmpty())
                                    @foreach($response as $ft)
                                <li class="form-group checkbox-group">
                                    <label>
                                        <input type="checkbox" checked=""   name="eventselevted[]" checked="" value="{{$ft->id}}">
                                        <span class="custom-checkbox"></span>
                                        {{$ft->userWiths->first_name}} {{$ft->userWiths->last_name}}
                                    </label>
                                </li>
                                  @endforeach
                                @endif
                            </ul>

                        </div>
                        <div class="elem-right">
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <input type="text" name="orderByUser" id="orderByUser" class="form-control"  placeholder="Liza" required="">
                                </div>
                          <input type="hidden" name="events" id="events">
                              <!--         <input type="hidden" name="vendorid" id="vendorid"> -->
                                <div class="col-sm-6 form-group">
                                    <select class="form-control" name="getEventTime" id="getEventTime" required=""> 
                                        <option value="">Select Time</option>
                                        @foreach($getTimes as $time)
                                            <option value="{{$time}}">{{$time}}</option>
                                        @endforeach
                                    </select>
                                    <!-- <input type="text" class="form-control" placeholder="11:30 AM"> -->
                                </div>
                                <div class="col-sm-6 form-group">
                                    <input type="text" name="orderDate" id="orderDate" class="form-control datepicker" placeholder="25 / March / 2020" required="">
                                </div>

                                <div class="col-sm-6 form-group">
                                    <select class="form-control" placeholder="Birthday Party" name="eventTypes[]" id="eventTypes" multiple="">
                                        <option value="">Select Service</option>
                                        @foreach($services as $ft)
                                            <option value="{{$ft->id}}">{{$ft->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <input type="text" class="form-control" placeholder="Hollywood, CA" name="extraevents" id="extraevents">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <select class="form-control" name="numberofgadring" id="numberofgadring" required="">
                                        <option value="38">38</option>
                                        <option value="39">39</option>
                                        <option value="40">40</option>
                                    </select>
                                </div>

                                <div class="col-sm-12">
                                    <h5>Preferred Contact</h5>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <input type="tel" name="mobile" id="mobile" class="form-control" placeholder="Mobile">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                                </div>
                                <div class="col-sm-12 form-group">
                                    <textarea class="form-control" name="comments" id="comments" placeholder="Other comments"></textarea>
                                </div>
                                <div class="form-group col-sm-12 custom-file-group">
                                    <label for="resumeFile">Upload Images (Max of 5)</label>
                                    <input type="file" name="resumeFile[]" id="resumeFile" multiple="true" maxlength="5">
                                </div>
                            </div>

                            <div class="text-left">
                                
                        
                                <input type="submit" class="btn btn-default" value="Send Request" @if(!Auth::check()) {{'disabled'}} @endif>
                            </div>

                        </div>
                    </form>
                </div>

            </article>
        </section>
      <script type="text/javascript">
            $('#eventName').keyup(function(){
                $('#events').val(this.value);
            })
        </script>
<script type="text/javascript">
      var dateToday = new Date();
      var dates = $('.datepicker').datepicker({
      });
</script>   
<!-- <script type="text/javascript">
    $(document).ready(function(){
        var favorite = [];
            $.each($("input[name='eventselevted']:checked"), function(){
                favorite.push($(this).val());
            });

            $('#vendorid').val(favorite.join(","));
            // console.log();
    })
</script>
<script type="text/javascript">
    function rechecked(){
        var favorite = [];
            $.each($("input[name='eventselevted']:checked"), function(){
                favorite.push($(this).val());
            });
            $('#vendorid').val(favorite.join(","));
            // console.log(favorite.join(","));
    }
</script> -->
@endsection