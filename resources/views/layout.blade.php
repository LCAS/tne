<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.0.6/dist/vue-multiselect.min.css">
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="tne_base_path" content="{{ route('home') }}">
        <title>Transnational Programmes</title>
    </head>
    <body>
        <div v-cloak class="main-content" id="app">
            <section class="hero is-primary is-bold">
                <div class="hero-body">
                    <div class="container">
                        <h1 class="title">Transnational Programme Matcher</h1>
                        <h2 class="subtitle">@yield('subtitle','Please select your module')</h2>
                        <div class="field is-grouped is-grouped-right">
                            @if(auth()->check())
                            @if(auth()->user()->is_admin)
                            @if(Route::current()->getName() !== 'dashboard')
                            <p class="control">
                                <a class="button is-primary" href="{{ route('dashboard') }}">
                                    <span class="icon"><i class="fa fa-dashboard" aria-hidden="true"></i></span>
                                    <span>Dashboard</span>
                                </a>
                            </p>
                            @else
                            <p class="control">
                                <a class="button is-primary" href="{{ route('home') }}">
                                    <span class="icon"><i class="fa fa-home" aria-hidden="true"></i></span>
                                    <span>Home Page</span>
                                </a>
                            </p>
                            @endif
                            @endif
                            <p class="control">
                                <a class="button is-primary" href="{{ route('logout') }}">
                                    <span class="icon"><i class="fa fa-sign-out" aria-hidden="true"></i></span>
                                    <span>Logout</span>
                                </a>
                            </p>
                            @else
                            <p class="control">
                                <a class="button is-primary" href="{{ route('login') }}">
                                    <span class="icon"><i class="fa fa-sign-in" aria-hidden="true"></i></span>
                                    <span>Admin Login</span>
                                </a>
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
            @yield('content')
            <flash message="{{ session('flash') }}" :display-icons="true"></flash>
        </div>
        <footer v-cloak class="hero is-light">
            <div class="level">
                <div class="level-left">
                    <div class="level-item">
                        Developed&nbsp;by&nbsp;<a href="https://plightbody.com/" target="_blank">&nbsp;Peter&nbsp;Lightbody&nbsp;</a>&nbsp;&copy;&nbsp;{{ date("Y") }}
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        <a href="https://m.do.co/c/e827a0190785" target="_blank" rel="noopener noreferrer">Proudly hosted on Digital Ocean</a>
                    </div>
                </div>
            </div>
        </footer>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>