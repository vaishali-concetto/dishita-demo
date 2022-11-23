<!doctype html>
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}

{{--    <title>{{ config('app.name', 'Laravel') }}</title>--}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @notifyCss
    <style type="text/css">
        .error{
            color: red;
        }
    </style>
</head>
<body>
{{--@include('notify::messages')--}}
{{--@include('notify::components.notify')--}}
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                {{--<a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>--}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @if (\Illuminate\Support\Facades\Auth::guest())

                        @else
                            <li class="nav-item dropdown">
                                <a class="dropdown-item" href="{{ $logout }}">
                                    {{ __('Logout') }}
                                </a>
                            </li>
                        @endif
                        {{--@if(\Illuminate\Support\Facades\Auth::check())
                            <li class="nav-item dropdown">
                                <a class="dropdown-item" href="{{ $logout }}">
                                    {{ __('Logout') }}
                                </a>
                            </li>
                        @endif--}}
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <x:notify-messages />
            @yield('content')
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    @notifyJs
    @yield('js')
</body>
</html>
