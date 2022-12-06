<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Post Module Admin Panel</title>

    <!-- Scripts -->
    <!--  <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    @yield('stylesheet')
    <!-- Bootstrap Bundle with Popper -->
    <script src="{{asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Styles -->
    <!--   <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <style>
        .wave-errect {
            margin-left: 15px;
        }

        .text-right {
            text-align: right;
        }
    </style>
    @yield('stylesheet')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('admin/admin-user') }}">
                    Post Module Admin Panel
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @if(Auth::guard('admin')->user())
                      
                        <li>
                            <a href="{{route('admin-post')}}" class="wave-errect"><i class="fa fa-sticky-note-o" aria-hidden="true"></i> {{ __('Post')}}</a>
                        </li>

                        <li>
                            <a href="{{route('admin-user')}}" class="wave-errect"><i class="fa fa-user" aria-hidden="true"></i> {{ __('Users')}}</a>
                        </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @if(Auth::guard('admin')->user())

                        <li>
                            <a href="{{ route('admin.logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i>{{ __('Logout') }}</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>