<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | E-Shopper</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="{{ asset('images/ico/apple-touch-icon-144-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="{{ asset('images/ico/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="{{ asset('images/ico/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/ico/apple-touch-icon-57-precomposed.png') }}">
</head><!--/head-->

<body>
    <!-- ============================================================== -->
    <!-- Header -->
    <!-- ============================================================== -->
    @include('frontend.layouts.header')
    <!-- ============================================================== -->
    <!-- End Header -->
    <!-- ============================================================== -->

    <div class="container" style="margin-bottom: 30px">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form"><!--login form-->
                    <h2>Login to your account</h2>
                    <form action="{{ route('loginMember') }}" method="post">
                        @csrf
                        <input name="emailLogin" value="{{ old('emailLogin') }}" type="text"
                            placeholder="Email..." />
                        @error('emailLogin')
                            <b style="color: red">{{ $message }}</b>
                        @enderror
                        <input name="passwordLogin" value="{{ old('passwordLogin') }}" type="password"
                            placeholder="Password..." />
                        @error('passwordLogin')
                            <b style="color: red">{{ $message }}</b>
                            <br><br>
                        @enderror

                        <span>
                            <input name="remember_me" type="checkbox" class="checkbox">
                            Keep me signed in
                            <br>
                            @error('remember_me')
                                <b style="color: red">{{ $message }}</b>
                            @enderror
                        </span>
                        <button type="submit" class="btn btn-default">Login</button>
                        @if (session('failed'))
                            <div class="mt-4 alert alert-danger">
                                {{ session('failed') }}
                            </div>
                        @endif
                    </form>
                </div><!--/login form-->
            </div>

        </div>
    </div>


    <!-- ============================================================== -->
    <!-- Footer -->
    <!-- ============================================================== -->
    @include('frontend.layouts.footer')
    <!-- ============================================================== -->
    <!-- End Footer -->
    <!-- ============================================================== -->


    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('js/price-range.js') }}"></script>
    <script src="{{ asset('js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
