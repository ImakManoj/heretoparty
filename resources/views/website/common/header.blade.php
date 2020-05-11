  <header>
    <nav class="navbar navbar-expand-md container">

      <!-- Brand -->
      <a class="navbar-brand" href="{{asset('/')}}">
        <img src="{{asset('heretoparty')}}/images/logo.png" alt="Logo">
        <img src="{{asset('heretoparty')}}/images/logo-color.png" alt="Logo Color">
      </a>

      <!-- Toggler/collapsibe Button -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar links -->
      <aside class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="#">Browse Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Inspiration</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Find Vendors</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Planning Tools</a>
          </li>
        </ul>
        <ul class="auth-links"> 
          @if(Auth::check())
            @if(Auth::User()->role=="Admin")
            <li>
                <a href="{{route('admndashboard')}}" class="btn btn-sm btn-default"><i class="fa fa-user"></i> Account</a>
            </li>
            <li>
                <a class="btn btn-sm btn-transparent" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="fa fa-lock"></i>
                {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
                </form>
            </li>
            @elseif(Auth::User()->role=="Vendor")
            <li>
                <a href="{{route('vendordashboard')}}" class="btn btn-sm btn-default"><i class="fa fa-user"></i> Account</a>
            </li>
            <li>
                <a class="btn btn-sm btn-transparent" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="fa fa-lock"></i>
                {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
                </form>
            </li>
            @else
            <li>
                <a href="{{route('usersdashboard')}}" class="btn btn-sm btn-default"><i class="fa fa-user"></i> Account</a>
            </li>
            <li>
                <a class="btn btn-sm btn-transparent" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="fa fa-lock"></i>
                {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
                </form>
            </li>
            @endif
          
          @else
          <li>
            <a href="{{route('signup')}}" class="btn btn-sm btn-default"><i class="fa fa-lock"></i> Sign up</a>
          </li>
          <li>
            <a href="{{route('userlogin')}}" class="btn btn-sm btn-transparent"><i class="fa fa-user"></i> Login</a>
          </li>
          @endif
          
        </ul>
      </aside>

    </nav>
  </header>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  

