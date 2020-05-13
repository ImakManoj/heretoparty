@extends('website.ForUsers.loginLayout.app')
@section('title','Forgot')
@section('content')


      <section class="auth-section">
            <article class="auth-left">
                <figure class="auth-header">
                    <a href="{{asset('/')}}"><img src="{{asset('heretoparty')}}/images/logo-color.png"></a>
                </figure>

                <article class="auth-form-cover">
                    <h2 class="heading">Forgot Password</h2>
                    <form action="{{route('forgotPassword')}}" method="post">
                        @csrf
                        <article class="form-group has-icon">
                            <i class="fa fa-envelope-o"></i>
                            <input type="email" name="forgotEmail" id="forgotEmail" class="form-control" placeholder="Enter Your Email">
                        </article>
                        <article class="text-center">
                            <input type="submit" class="btn btn-default" value="Reset">
                        </article>
                    </form>
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



 @endsection