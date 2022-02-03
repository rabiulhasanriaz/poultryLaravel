<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      
      <!-- Navbar Search -->
      

      <!-- Messages Dropdown Menu -->
     
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="margin-top: -50px;">
            <img src="
            @if(Auth::user()->logo == '')
            {{ asset('/assets/image/default.png') }}
            @else
                {{ asset('/assets/image/')}}/{{ Auth::user()->logo }}
            @endif
            " class="user-image" alt="User Image">
            <span class="hidden-xs">{{ Auth::user()->name }}</span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="
              @if(Auth::user()->logo == '')
            {{ asset('/assets/image/default.png') }}
            @else
                {{ asset('/assets/image/')}}/{{ Auth::user()->logo }}
            @endif
              " class="img-circle" alt="User Image">
  
              <p>
                {{ Auth::user()->name }}
                <small>Member since {{ Auth::user()->created_at }}</small>
              </p>
            </li>
            <!-- Menu Body -->
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="float-left">
                <a href="" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="float-right" >
                <a href="javascript:void(0);" class="btn btn-default btn-flat" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
      </li>
      
     
    </ul>
  </nav>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>