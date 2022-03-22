<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
</head>
<body>
    <div id="app">
        <div class="row navbar-row" style="background-color: #131516; color:white">
            <div class="col-6 logo">Expense Tracker</div>
            <div class="col-6 menu">
                @guest
                    <div class="row logo">
                        <div class="col-6 text-center" style="line-height: 75px;">
                            @if (Route::has('login'))
                                <a class="text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @endif
                        </div>
                        <div class="col-6 text-center" style="line-height: 75px;">
                            @if (Route::has('register'))
                                <a class="text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="row logo">
                        <div class="col-6 text-center">
                            @if (Route::has('register'))
                                    {{ Auth::user()->name }}
                            @endif
                        </div>
                        <div class="col-6 text-center">
                            <a href="{{ route('logout') }}" class="text-white"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none" hidden>
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>


        <main class="wrap">
            @yield('content')
        </main>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
