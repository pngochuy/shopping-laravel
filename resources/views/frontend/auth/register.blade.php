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
        <!-- Column -->
        <div class="col-lg-8 col-xlg-9 col-md-7">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('registerMember') }}" method="POST" class="form-horizontal form-material"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="col-md-12">Full Name</label>
                            <div class="col-md-12">
                                <input type="text" name="name" placeholder="Johnathan Doe"
                                    class="form-control form-control-line" value="{{ old('name') }}">
                                @error('name')
                                    <b style="color: red">{{ $message }}</b>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="example-email" class="col-md-12">Email</label>
                            <div class="col-md-12">
                                <input type="email" name="email" placeholder="johnathan@admin.com"
                                    class="form-control form-control-line" name="example-email" id="example-email"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <b style="color: red">{{ $message }}</b>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Password</label>
                            <div class="col-md-12">
                                <input type="password" name="password" value="{{ old('password') }}"
                                    class="form-control form-control-line" autocomplete="off" placeholder="">
                                @error('password')
                                    <b style="color: red">{{ $message }}</b>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Avatar Upload</label>
                            <div class="col-md-12">
                                <input type="file" name="avatar" class="form-control" accept="image/*"
                                    value="{{ old('avatar') }}">
                                @error('avatar')
                                    <b style="color: red">{{ $message }}</b>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Phone No</label>
                            <div class="col-md-12">
                                <input type="text" name="phone" placeholder="123 456 7890"
                                    class="form-control form-control-line" value="{{ old('phone') }}">
                                @error('phone')
                                    <b style="color: red">{{ $message }}</b>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Message</label>
                            <div class="col-md-12">
                                <textarea rows="5" name="message" class="form-control form-control-line">{{ old('message') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Select Country</label>
                            <div class="col-sm-12">
                                <select class="form-control form-control-line" name="id_country">
                                    <option selected disabled>Select country</option>
                                    @foreach ($countryList as $country)
                                        <option @if ($country->id == old('id_country')) {{ 'selected' }} @endif
                                            value="{{ $country->id }}">
                                            {{ $country->country }}
                                        </option>
                                    @endforeach
                                    {{-- <option value="1">London</option>
                                    <option value="2">India</option>
                                    <option value="3">USA</option>
                                    <option value="4">Canada</option>
                                    <option value="5">Thailand</option> --}}
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success">Register</button>
                                @if (session('success'))
                                    <div class="mt-4 alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('failed'))
                                    <div class="mt-4 alert alert-danger">
                                        {{ session('failed') }}
                                    </div>
                                @endif
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Column -->
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
