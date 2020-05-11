@extends('website.ForUsers.loginLayout.app')
@section('title','Login')
@section('content')


<!-- html login -->

       <section class="auth-section">
            <article class="auth-left">
                <figure class="auth-header">
                    <a href="{{asset('/')}}"><img src="{{asset('heretoparty')}}/images/logo-color.png"></a>
                </figure>

                <article class="auth-form-cover">
                    <h2 class="heading">Login</h2>
                    <form action="{{route('loginUsers')}}" method="post">
                        @csrf
                        <article class="form-group has-icon">
                            <i class="fa fa-envelope-o"></i>
                            <input type="email" class="form-control" placeholder="Email" name="email">
                        </article>
                        <article class="form-group has-icon">
                            <i class="fa fa-lock"></i>
                            <input type="password" class="form-control" placeholder="Password" name="password">
                        </article>
                        <article class="form-group checkbox-group">
                            <label>
                                <input type="checkbox">
                                <span class="custom-checkbox"></span>
                                Remember me
                            </label>
                        </article>
                        <article class="text-center">
                            <input type="submit" class="btn btn-default" value="Login">
                        </article>
                    </form>
                    <p class="text-center"><a href="{{route('forgot')}}">Forgot Password?</a></p>
                    <p class="text-center">Not a member? <a href="{{route('signup')}}">Sign up</a></p>
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

<!--  End  -->
@endsection