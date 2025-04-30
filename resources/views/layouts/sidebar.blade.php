<div class="pb-3 sidebar pe-4">
    <nav class="navbar bg-light navbar-light">
        <a href="{{url('/')}}" class="mx-4 mb-3 navbar-brand">
            {{-- <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>MaxFit</h3> --}}
            <img src="{{asset('assets/images/logo.png')}}" class="img-fluid" alt="">
        </a>
        <div class="mb-4 d-flex align-items-center ms-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ Auth::user()->image}}" alt="" style="width: 40px; height: 40px;">
                <div class="bottom-0 p-1 border border-2 border-white bg-success rounded-circle position-absolute end-0"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{Auth::user()->name}}</h6>
                <span>Admin</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="{{url('/')}}" class="nav-item nav-link {{ Route::is('dashboard') ? 'active' : ''}}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <div class="nav-item dropdown d-none">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Elements</a>
                <div class="bg-transparent border-0 dropdown-menu">
                    <a href="button.html" class="dropdown-item">Buttons</a>
                    <a href="typography.html" class="dropdown-item">Typography</a>
                    <a href="element.html" class="dropdown-item">Other Elements</a>
                </div>
            </div>
            <a href="{{route('users.index')}}" class="nav-item nav-link"><i class="fa fa-user me-2"></i>Users</a>
            <a href="{{route('organisation-types.index')}}" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Org. Types</a>
            <a href="{{route('organisations.index')}}" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Organisations</a>
            <a href="{{route('medical-assessment-questions.index')}}" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Medical Assessment Ques.</a>
            <a href="table.html" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Tables</a>
            <a href="chart.html" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Charts</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Pages</a>
                <div class="bg-transparent border-0 dropdown-menu">
                    <a href="signin.html" class="dropdown-item">Sign In</a>
                    <a href="signup.html" class="dropdown-item">Sign Up</a>
                    <a href="404.html" class="dropdown-item">404 Error</a>
                    <a href="blank.html" class="dropdown-item">Blank Page</a>
                </div>
            </div>
        </div>
    </nav>
</div>
