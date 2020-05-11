@php
use App\Http\Controllers\Vender\VenderController;
$userProfile=VenderController::UserProfile();
@endphp
        <header>
 
            <div class="logo">

               <a href="{{asset('')}}"> <img src="{{asset('heretoparty/dashboard')}}/images/logo-color.png" alt="logo-color.png"></a>

            </div>

            <div class="user-auth-menu">

                <ul>

                    <li class="dropdown">

                        <button type="button" class="profile-dropdown dropdown-toggle" data-toggle="dropdown">

                            
                            @if($userProfile->images=='')
                            <figure style="background-image: url('{{asset('heretoparty/dashboard')}}/images/user-img.jpg');"></figure>
                            @else
                             <figure style="background-image: url('{{asset(@$userProfile->images)}}');"></figure>  
                            @endif
                           {{@$userProfile->first_name}} {{@$userProfile->last_name}}

                        </button>

                        <ul class="dropdown-menu">

                             <li><a class="dropdown-item" href="{{route('userProfile')}}">Profile</a></li>

                            <li><a class="dropdown-item" href="#">Link 2</a></li>

                                <li>

                        <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                       
                        {{ __('Logout') }}
                        </a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                        </form>

                            </li>

                        </ul>

                    </li>

                    <li class="dropdown">

                        <button type="button" class="dropdown-toggle" data-toggle="dropdown">

                            <i class="fa fa-bell-o"></i>

                            <span class="badge">0</span>

                        </button>

                        <ul class="dropdown-menu">

                            <li><a class="dropdown-item" href="{{route('usernotification')}}">More</a></li>

                        </ul>

                    </li>

                    <li class="dropdown">

                        <button type="button" class="dropdown-toggle" data-toggle="dropdown">

                            <i class="fa fa-envelope-o"></i>

                            <span class="badge">0</span>

                        </button>

                        <ul class="dropdown-menu">

                            <li><a class="dropdown-item" href="{{route('usersmessage')}}">More</a></li>

                        </ul>

                    </li>

                </ul>

            </div>

        </header>