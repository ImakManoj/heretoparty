@extends('website.ForUsers.loginLayout.app')
@section('title','Sign-Up')
@section('content')

@if (Session::has('message'))

  <div id="registers" class="alert alert-success">{{ Session::get('message') }}</div>

@endif
 <section class="auth-section">
            <article class="auth-left">
                <figure class="auth-header">
                    <a href="{{asset('/')}}"><img src="{{asset('heretoparty')}}/images/logo-color.png"></a>
                </figure>

                <article class="auth-form-cover">
                    <h2 class="heading">Sign Up</h2>
                    <form id="form" action='{{route("signup")}}' method="post">
                            @csrf
                        <article class="form-group radio-group">
                            <label>
                                <input type="radio" name="LookingFor" value="Users">
                                <span class="custom-radio"></span>
                                Party Maker
                            </label>
                            <label>
                                <input type="radio" name="LookingFor" value="Vendor">
                                <span class="custom-radio"></span>
                                A Vendor
                            </label>
                        </article>

                        <article class="form-group has-icon">
                            <i class="fa fa-user"></i>
                            <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name">
                        </article>
                        <article class="form-group has-icon">
                            <i class="fa fa-user"></i>
                            <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name">
                        </article>
                        <article class="form-group has-icon">
                            <i class="fa fa-envelope-o"></i>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                        </article>
                        <article class="form-group has-icon">
                            <i class="fa fa-lock"></i>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        </article>
                        <article class="form-group has-icon">
                            <i class="fa fa-lock"></i>
                            <input type="password"  name="comfirm_password" id="comfirm_password" class="form-control" placeholder="Confirm Password">
                        </article>
                        <div class="form-group">
                            <select class="form-control" placeholder="Country" name="countries" id="countries" onchange="getCountries(this.value)">
                                <option value="">Select Country</option>
                                @foreach($countries as $ft)
                                        <option value="{{$ft->id}}">{{$ft->country_name}}</option>
                                @endforeach
                             </select>
                           <!--  <input type="password" class="form-control" placeholder="Country"> -->
                        </div>
                        <article class="form-group">
                             <select class="form-control" placeholder="City" name="cities" id="cities">
                                <option value="">Select City</option>
                                 @foreach($cities as $ft)
                                        <option value="{{$ft->id}}">{{$ft->city_name}}</option>
                                @endforeach
                             </select>
                        </article>
                        <article class="form-group checkbox-group">
                            <label>
                                <input type="checkbox">
                                <span class="custom-checkbox"></span>
                                Accept all <a href="{{route('termCondition')}}">terms and conditions.</a>
                            </label>
                        </article>
                        <article class="text-center">
                            <input type="submit" class="btn btn-default" value="Sign Up">
                        </article>
                    </form>
                    <p class="text-center">Already have an account? <a href="{{route('userlogin')}}">Login</a></p>
                </article>

                <a href="#" class="back-btn">
                    <i class="fa fa-angle-left"></i>
                </a>

                <section class="auth-footer">
                    <p>COPYRIGHTS &copy; 2020 - ALL RIGHTS RESERVED</p>
                </section>
            </article>
            <aside style="background-image: url('{{asset('heretoparty')}}/images/auth-bg-img.jpg');"></aside>
        </section>



<script type="text/javascript">
    function getCountries(id){
        var option='';
        option+='<option value="">Select City</option>';
        const parmt={
            _token:"{{csrf_token()}}",
            id:id
        }
        $.post('{{route("getCities")}}',parmt).then(function(response){
               var obj=JSON.parse(response);
               for(var i=0;i<obj.length;i++){
                    option+='<option value="'+obj[i].id+'">'+obj[i].city_name+'</option>';
               }
             //  $('#cities').html(option);
        })
    }
</script>

@endsection