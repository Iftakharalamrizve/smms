<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="ccpro | integrated software application for network solutions"/>
    <meta name="keywords" content="mominriyadh, gulp, boilerplate, gulp boilerplate, live reload">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/images/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/images/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/images/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/images/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/images/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/images/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/images/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/images/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/images/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/images/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/images/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('assets/images/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <title>@hasSection('template_title')@yield('template_title') | @endif {{ config('app.name', Lang::get('titles.app')) }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendors.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
</head>

<body>

<div class="g-main-login-area">
    <div class="g-main-login-form">
        <div class="g-main-login-form-main">
            <div class="g-login-p-logo mb-4 text-center" style="width: 180px">
                <img class="img-fluid" src="{{ asset('assets/images/login/login-logo.svg') }}" alt="ccpro">
            </div>
            <div class="text-center mb-4">
                <h5 class="text-white g-login-title">CCPRO Sign In</h5>
            </div>
            @if (session('success'))
                <div class="alert alert-danger" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('login') }}" class="g-signin-form" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="g-user-name" class="form-label">Username</label>
                    @if ($errors->has('username'))
                        <small class="g-input-error invisible">{{ $errors->first('username') }}</small>
                    @endif
                    <input type="text" name="username" id="g-user-name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="g-user-password" class="form-label">Password</label>
                    @if ($errors->has('password'))
                        <small class="g-input-error invisible">{{ $errors->first('password') }}</small>
                    @endif
                    <input type="password" name="password" id="g-user-password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <div class="g-form-meta">
                        <label for="g-remember-me">
                            <input type="checkbox" name="remember" id="g-remember-me">
                            Remember me
                        </label>
                        <small class="g-f-password">
                            Forgot Password?
                        </small>
                    </div>
                </div>

                <div class="text-center mb-3">
                    <button type="submit" class="btn btn-sm btn-primary p-2 btn-block w-100">
                        Log in
                    </button>
                </div>
            </form>


            <!--            Password Reset Link-->
            <form action="" class="g-password-redirect">
                <div class="form-group mb-3">
                    <label for="g-your-email">Your Email Address</label>
                    <input type="email" name="" id="g-your-email" class="form-control" placeholder="Email Address" required>
                </div>

                <button id="button" class="btn btn-primary w-100 mb-3" type="submit">SEND</button>
                <div class="text-center">
                    <small id="redirect" class="redirect bi bi-arrow-left-short">Back to log in</small>
                </div>
            </form>
            <!--            End Password Reset Link-->
        </div>
        <small class="g-powered-by text-white">Powered by &nbsp; <strong class=""> g</strong>Plex</small>
    </div>

    <!--**********************************
                 Right Parts
     ***********************************-->
    <div class="g-main-login-right">
        <div class="g-login-brand-logo">
            <a href="">
                <img class="img-fluid" src="{{ asset('assets/images/login/gplex-bottom.svg') }}" alt="ccpro">
            </a>
        </div>
    </div>
</div>

<!-- Scripts -->
<script defer src="{{ asset('/assets/js/vendors.min.js') }}"></script>
<script defer src="{{ asset('/assets/js/app.min.js') }}"></script>
</body>

</html>
