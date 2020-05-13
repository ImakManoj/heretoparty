@php
use App\Http\Controllers\Vender\VenderController;
$userProfile=VenderController::UserProfile();
@endphp
<main>
            <aside>
 
                <div class="profile-name">
                     @if($userProfile->images=='')  
                    <figure style="background-image: url('{{asset('heretoparty/dashboard')}}/images/user-big-img.jpg');"></figure>
                     @else
                             <figure style="background-image: url('{{asset(@$userProfile->images)}}');"></figure>  
                    @endif
                          

                    <h4><small>Administrator,</small> {{@$userProfile->first_name}} {{@$userProfile->last_name}}</h4>

                </div>

    

                <div class="dashboard-menu">

                    <ul>

                        <li>

                                <a href="{{ route('banner')}}">
                                 <figure><i class="fa fa-quote-left"></i></figure>
                                <span>Banner</span>
                                </a>

                        </li>

                        <li>
                               <a href="{{ route('degination')}}">
                                    <figure><i class="fa fa-quote-left"></i></figure>
                                    <span>Deginations</span>
                                </a>
                        </li>

                        <li>
                               <a href="{{ route('iWantToPlan')}}">
                                    <figure><i class="fa fa-quote-left"></i></figure>
                                     <span class="sub-item">I want to plan</span>
                                </a>
                        </li>

                        <li>
                               <a href="{{ route('vendorsRecentlyBooked')}}">
                                    <figure><i class="fa fa-quote-left"></i></figure>
                                    <span class="sub-item">Vendors recently Booked</span>
                                </a>
                        </li>

                         <li>
                               <a href="{{ route('howItWorks')}}">
                                    <figure><i class="fa fa-quote-left"></i></figure>
                                     <span class="sub-item">How it works</span>
                                </a>
                        </li>

                         <li>
                               <a href="{{ route('aboutUs')}}">
                                    <figure><i class="fa fa-quote-left"></i></figure>
                                      <span class="sub-item">About Us</span>
                                </a>
                        </li>

                         <li>
                               <a href="{{ route('ourteam')}}">
                                    <figure><i class="fa fa-quote-left"></i></figure>
                                      <span class="sub-item">Our Team</span>
                                </a>
                        </li>

                         <li>
                               <a href="{{ route('careers')}}">
                                    <figure><i class="fa fa-quote-left"></i></figure>
                                     <span class="sub-item">Careers</span>
                                </a>
                        </li>

                        <li>
                               <a href="{{ route('adminCategory')}}">
                                    <figure><i class="fa fa-quote-left"></i></figure>
                                     <span>Category</span>
                                </a>
                        </li>

                        <li>
                               <a href="{{ route('adminService')}}">
                                    <figure><i class="fa fa-quote-left"></i></figure>
                                    <span>Services</span>
                                </a>
                        </li>

                        <li>
                               <a href="{{ route('tags')}}">
                                    <figure><i class="fa fa-quote-left"></i></figure>
                                    <span>Tags</span>
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
