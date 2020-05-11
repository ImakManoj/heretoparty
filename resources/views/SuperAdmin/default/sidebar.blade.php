 <div class="sidebar">

  <div class="sidebar-background"></div>
  <div class="sidebar-wrapper scrollbar-inner">
    <div class="sidebar-content">
      <div class="user">
        <div class="avatar-sm float-left mr-2">
          <img src="{{URL::asset('')}}" alt="..." class="avatar-img rounded-circle">
        </div>
        <div class="info">
          <a href="" >
            <span>
              {{Auth::user()->first_name}}
              <span class="user-level">Administrator</span>

            </span>
          </a>
          <div class="clearfix"></div>


        </div>
      </div>
      <ul class="nav">
         <li class="nav-item">
               <a href="{{ route('banner')}}">
                 <i class="fas fa-home"></i>
                <span>Banner</span>
              </a>
          </li>
          <li class="nav-item">
               <a href="{{ route('degination')}}">
                 <i class="fas fa-home"></i>
                <span>Deginations</span>
              </a>
          </li>
        <li class="nav-item ">
          <a data-toggle="collapse" href="#Pages">
            <i class="fas fa-table"></i>
            <p>Pages</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="Pages">
            <ul class="nav nav-collapse">
            
            <li class="">
               <a href="{{route('iWantToPlan')}}">
                <span class="sub-item">I want to plan</span>
              </a>
            </li>
           
          <li class="">
               <a href="{{route('vendorsRecentlyBooked')}}">
                <span class="sub-item">Vendors recently Booked</span>
              </a>
            </li>
            <li class="">
               <a href="{{route('howItWorks')}}">
                <span class="sub-item">How it works</span>
              </a>
            </li>
          <li>
           <a href="{{route('aboutUs')}}">
            <span class="sub-item">About Us</span>
          </a>
        </li>


        <li>
           <a href="{{route('ourteam')}}">
            <span class="sub-item">Our Team</span>
          </a>
        </li>
         <li>
           <a href="{{route('careers')}}">
            <span class="sub-item">Careers</span>
          </a>
        </li>
    </ul>
     <li class="nav-item">
               <a href="{{ route('adminCategory')}}">
                 <i class="fas fa-home"></i>
                <span>Category</span>
              </a>
          </li>
           <li class="nav-item">
               <a href="{{ route('adminService')}}">
                 <i class="fas fa-home"></i>
                <span>Services</span>
              </a>
          </li>
           <li class="nav-item">
               <a href="{{ route('tags')}}">
                 <i class="fas fa-home"></i>
                <span>Tags</span>
              </a>
          </li>
          <li class="nav-item">
  <a class="dropdown-item" href="{{ route('logout') }}"
  onclick="event.preventDefault();
  document.getElementById('logout-form').submit();">
  <i class="fas fa-home"></i>
  {{ __('Logout') }}
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
  @csrf
</form>
</li>
  </div>
</li>

    </ul>
  </div>
</li>








</ul>
</div>
</div>
</div>
<!-- End Sidebar -->
