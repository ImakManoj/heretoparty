 @php
use App\Http\Controllers\Vender\VenderController;
$userProfile=VenderController::UserProfile();
@endphp
            <aside>

                <div class="profile-name">
                    @if($userProfile->images=='')  
                    <figure style="background-image: url('{{asset('heretoparty/dashboard')}}/images/user-big-img.jpg');"></figure>
                     @else
                             <figure style="background-image: url('{{asset(@$userProfile->images)}}');"></figure>  
                    @endif
                          

                    <h4><small>Welcome,</small> {{@$userProfile->first_name}} {{@$userProfile->last_name}}</h4>

                </div>

    

                <div class="dashboard-menu">

                    <ul>

                        <li>

                            <a href="{{route('usersdashboard')}}" class="active">

                                <figure><i class="fa fa-th-large"></i></figure>

                                Dashboard

                            </a>

                        </li>

                        <li>

                            <a href="{{route('query')}}">

                                <figure><i class="fa fa-quote-left"></i></figure>

                                My Quotes

                            </a>

                        </li>

                        <!-- <li>

                            <a href="{{route('business')}}">

                                <figure><i class="fa fa-briefcase"></i></figure>

                                My Business

                            </a>

                        </li> -->

                        <li>
                            <a href="{{route('myevents')}}">
                                <figure><i class="fa fa-calendar" aria-hidden="true"></i></figure>
                                My Events
                            </a>
                        </li>
                          <li>  
                            <a href="{{route('mybudgeter')}}" >
                                <figure><i class="fa fa-usd" aria-hidden="true"></i></figure>
                                Budgeter
                            </a>
                        </li>
                        <li>
                            <a href="{{route('mygestlist')}}" >
                                <figure><i class="fa fa-file-text-o" aria-hidden="true"></i></figure>
                                Guest List
                            </a>
                        </li>

                        <li class="nav-item">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <figure><i class="fa fa-sign-out"></i></figure>
                        {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                        </form>
                        </li>

                    </ul>

 


                </div>

    

            </aside>
