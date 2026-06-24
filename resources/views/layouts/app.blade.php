<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.8/css/dataTables.dataTables.min.css">

    <style>
        @media (min-width: 768px) {
            .sidebar-fixed {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                z-index: 1030;
            }
            .main-content-offset {
                margin-left: 25%; 
            }
        }
        @media (min-width: 992px) {
            .main-content-offset {
                margin-left: 16.666667%; 
            }
        }
    </style>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        @guest
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm mb-4">
                <div class="container">
                    <a class="navbar-brand fw-bold" href="{{ url('/') }}">SIEKA</a>
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navHorizontalContent" aria-controls="navHorizontalContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navHorizontalContent">
                        <ul class="navbar-nav ms-auto">
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>

        @else
            <div class="container-fluid p-0">
                <div class="row g-0">

                    <div class="col-md-3 col-lg-2 bg-white shadow-sm border-end sidebar-fixed">
                        <nav class="navbar navbar-expand-md navbar-light align-items-md-start flex-md-column p-3 h-100">

                            <div class="d-flex flex-md-column w-100 justify-content-between align-items-center align-items-md-start">
                                @if (Auth::user()->role === 'admin')
                                    <a class="navbar-brand fw-bold fs-4 mb-md-4" href="{{ url('/admin/dashboard') }}">SIEKA</a>
                                @elseif (Auth::user()->role === 'panitia')
                                    <a class="navbar-brand fw-bold fs-4 mb-md-4" href="{{ url('/panitia/dashboard') }}">SIEKA</a>
                                @elseif (Auth::user()->role === 'user')
                                    <a class="navbar-brand fw-bold fs-4 mb-md-4" href="{{ url('/user/dashboard') }}">SIEKA</a>
                                @endif

                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#sidebarContent" aria-controls="sidebarContent" aria-expanded="false"
                                    aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                            </div>

                            <div class="collapse navbar-collapse w-100 mt-md-3" id="sidebarContent">
                                <div class="d-flex flex-column justify-content-between w-100 h-100">

                                    <ul class="navbar-nav flex-column w-100 mb-4 gap-1">
                                        @if (Auth::user()->role === 'admin')
                                            <li class="nav-item">
                                                <a class="nav-link px-2 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link px-2 rounded {{ request()->routeIs('admin.user.*') ? 'bg-primary text-white' : '' }}" href="{{ route('admin.user.index') }}">Data User</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link px-2 rounded {{ request()->routeIs('admin.event.*') ? 'bg-primary text-white' : '' }}" href="{{ route('admin.event.index') }}">Data Event</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link px-2 rounded {{ request()->routeIs('admin.transaksi.*') ? 'bg-primary text-white' : '' }}" href="{{ route('admin.transaksi.index') }}">Data Transaksi</a>
                                            </li>
                                        @elseif (Auth::user()->role === 'panitia')
                                            <li class="nav-item">
                                                <a class="nav-link px-2 rounded {{ request()->routeIs('panitia.dashboard') ? 'bg-primary text-white' : '' }}" href="{{ route('panitia.dashboard') }}">Dashboard</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link px-2 rounded {{ request()->routeIs('panitia.transaksi.*') ? 'bg-primary text-white' : '' }}" href="{{ route('panitia.transaksi.masuk') }}">Transaksi Masuk</a>
                                            </li>
                                        @elseif (Auth::user()->role === 'user')
                                            <li class="nav-item">
                                                <a class="nav-link px-2 rounded {{ request()->routeIs('user.dashboard') ? 'bg-primary text-white' : '' }}" href="{{ route('user.dashboard') }}">Dashboard</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link px-2 rounded {{ request()->routeIs('user.transaksi.*') ? 'bg-primary text-white' : '' }}" href="{{ route('user.transaksi.index') }}">Tiket Saya</a>
                                            </li>
                                        @endif
                                    </ul>

                                    <ul class="navbar-nav flex-column w-100 gap-1">
                                        <li class="nav-item dropup w-100">
                                            <hr class="text-muted mb-2">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle px-2 fw-bold text-dark"
                                                href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false" v-pre>
                                                <i class="fa-solid fa-user"></i>
                                                {{ Auth::user()->nama }}
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-md-start dropdown-menu-end w-100" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    {{ __('Logout') }}
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            </div>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </nav>
                    </div>

                    <div class="col-md-9 col-lg-10 bg-light main-content-offset">
                        <main class="py-4 px-3" style="min-height: 100vh;">
                            @yield('content')
                        </main>
                    </div>

                </div>
            </div>
        @endguest
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.datatables.net/2.3.8/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            if ($('#table').length) {
                new DataTable('#table');
            }
        });
    </script>
</body>

</html>