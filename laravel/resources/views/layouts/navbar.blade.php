<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <div class="user-panel d-flex">
                <div class="image">
                    <img src="{{asset("dist/img/user2-160x160.jpg")}}" alt="User Image" class="img-circle elevation-1 mr-1">
                </div>
                <div class="info">
                {{ Auth::user()->name }}
                </div>
                
                </div>
                
             
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">User Panel</span>
                <div class="dropdown-divider"></div>
                <a href="{{route('ubah_password_admin')}}" class="dropdown-item">
                    <i class="fas fa-user mr-2"></i>Ubah Password
                    <span class="float-right text-muted text-sm"></span>
                </a>

                <div class="dropdown-divider"></div>
                <form action="{{route('logout')}}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt mr-2"></i>Logout</button>
                </form>
            </div>
        </li>



        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

    </ul>
</nav>