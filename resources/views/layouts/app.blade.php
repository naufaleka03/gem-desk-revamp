<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{config('app.name')}}</title>
    <link rel="icon" href="{{ asset('img/gd-logo.png') }}" type="image/png"/>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"/>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{asset('css/app.css')}}"/>

</head>
<body>
<div class="kontainer">
    <aside>
        <div class="top">
            <div class="logo">
                <img src="{{asset('img/gd-logo.png')}}"/>
                <h2 class="text-muted">GEM-DESK</h2>
            </div>
            <div class="close" id="close-btn">
                <span class="material-symbols-outlined">close</span>
            </div>
        </div>

        <div class="asidebar">
            <a href="{{route('userManagements.index')}}"
               class="{{ request()->routeIs('userManagements**') ? 'active' : '' }}">
                <span class="material-symbols-outlined">person</span>
                <h3>User</h3>
            </a>
            {{-- <a href="{{route('leaveTypes.index')}}" class="{{ request()->routeIs('leaveTypes**') ? 'active' : '' }}">
                <span class="material-symbols-outlined">
                person_off
                </span>
                <h3>Leave Type</h3>
            </a> --}}
            <a href="{{route('organizations.index')}}"
               class="{{ request()->routeIs('organizations**') ? 'active' : '' }}">
                <span class="material-symbols-outlined">location_home</span>
                <h3>Organization</h3>
            </a>
            <a href="{{route('assetManagement.index')}}"
               class="{{ request()->routeIs(['assetManagement**', 'productTypes**']) ? 'active' : '' }}">
                <span class="material-symbols-outlined">inventory_2</span>
                <h3>Asset Management</h3>
            </a>
            <a href="{{route('services.index')}}" class="{{ request()->routeIs('services**') ? 'active' : '' }}">
                <span class="material-symbols-outlined">support_agent</span>
                <h3>Service Catalog</h3>
            </a>

            <a href="{{route('incidents.index')}}" class="{{ request()->routeIs('incidents**') ? 'active' : '' }}">
                <span class="material-symbols-outlined">emergency_home</span>
                <h3>Incident Management</h3>
            </a>

            {{-- <a href="{{route('incidentTemps.index')}}" class="{{ request()->routeIs('incidentTemps**') ? 'active' : '' }}">
                <span class="material-symbols-outlined">notification_important</span>
                <h3>Incident Temporary</h3>
            </a> --}}

            <a style="text-decoration: none" href="{{route('tickets.index')}}"
               class="{{ request()->routeIs('tickets**') ? 'active' : '' }}">
                <span class="material-symbols-outlined">confirmation_number</span>
                <h3>Ticketing</h3>
            </a>

            <form action="{{route('logout')}}" method="POST">
                @csrf
                <a href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();">
                    <span class="material-symbols-outlined">logout</span>
                    <h3>Logout</h3>
                </a>
            </form>


        </div>
    </aside>
    <!-- ============================END OF ASIDE================== -->
    <main>
        <div class="main-top">
            <h1>Dashboard</h1>

            <div class="top">
                <button class="material-symbols-outlined" id="menu-btn">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div class="profile">
                    <div class="info">
                        @if(Auth::check())
                            <p style="white-space: pre-line">Hey, <b>{{ Auth::user()->name }}</b>
                                <b>{{Auth::user()->roles}}</b>
                            </p>
                        @endif
                    </div>
                    <div class="profile-photo">
                        @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="photo-profile"/>
                        @else
                            <img src="{{ asset('img/default-avatar.png') }}" alt="default-photo-profile"/>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fitur">
            @yield('content')
        </div>
    </main>
    <!-- ============================END OF MAIN================== -->

</div>
@stack('script')
<script>
    $("#alert").fadeTo(1500, 300).slideUp(300, function () {
        $('#alert').slideUp(300);
    });
</script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
</body>
</html>




