@extends('layouts.login')

@section('content')

<body>
    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page" data-color="red" data-image="{{ asset('img/admin/background/background-2.jpg') }}">
        <!--   you can change the color of the filter page using: data-color="blue | azure | green | orange | red | purple" -->
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                            <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                             @csrf
                                <div class="card" data-background="color" data-color="blue">
                                    <div class="card-header">
                                        <h3 class="card-title">Login</h3>
                                    </div>
                                    <div class="card-content">
                                        <div class="form-group">
                                            <label>Email address</label>
                                            <!-- <input type="email" placeholder="Enter email" class="form-control input-no-border"> -->
                                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong style="color:red;">{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong style="color:red;">{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-footer text-center">
                                        <button type="submit" class="btn btn-fill btn-wd">
                                            {{ __('Login') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
