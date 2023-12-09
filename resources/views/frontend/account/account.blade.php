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

    {{-- Cho bên rating stars của blog --}}
    <link type="text/css" rel="stylesheet" href="{{ asset('css/rate.css') }}">
    <script src="{{ asset('js/jquery-1.9.1.min.js') }}"></script>

    <!-- CSRF Token: có cái này mới sử dụng được AJAX trong Laravel -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head><!--/head-->

<body>
    <!-- ============================================================== -->
    <!-- Header -->
    <!-- ============================================================== -->
    @include('frontend.layouts.header')
    <!-- ============================================================== -->
    <!-- End Header -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- Section Content -->
    <!-- ============================================================== -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Account</h2>
                        <div class="panel-group category-products" id="accordian"><!--category-productsr-->

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a href="{{ route('account.edit') }}">
                                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                            Account
                                        </a>
                                    </h4>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a href="{{ route('product.show_list') }}">
                                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                            My product
                                        </a>
                                    </h4>
                                </div>
                            </div>

                        </div><!--/category-products-->


                    </div>
                </div>
                <div class="col-sm-9">
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('account.edit') }}" method="POST"
                                    class="form-horizontal form-material" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label class="col-md-12">Full Name</label>
                                        <div class="col-md-12">
                                            {{-- <input type="text" name="name" placeholder="Johnathan Doe"
                                                class="form-control form-control-line"
                                                value="{{ old('name', $currentUser->name) }}"> --}}
                                            <input type="text" name="name" placeholder="Johnathan Doe"
                                                class="form-control form-control-line"
                                                value="{{ old('name', $currentUser->name) }}">
                                            @error('name')
                                                <b style="color: red">{{ $message }}</b>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="example-email" class="col-md-12">Email</label>
                                        <div class="col-md-12">
                                            <input type="email" name="email" placeholder="johnathan@admin.com"
                                                class="form-control form-control-line" name="example-email"
                                                id="example-email" value="{{ old('email', $currentUser->email) }}"
                                                readonly>
                                            @error('email')
                                                <b style="color: red">{{ $message }}</b>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Password</label>
                                        <div class="col-md-12">
                                            <input type="password" name="password" value="{{ old('password') }}"
                                                class="form-control form-control-line" autocomplete="off"
                                                placeholder="{{ $passwordFormat }}">
                                            @error('password')
                                                <b style="color: red">{{ $message }}</b>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Avatar Upload</label>
                                        <div class="col-md-12">
                                            @if ($currentUser->avatar)
                                                <img src="{{ asset('upload/user/avatar/' . $currentUser->avatar) }}"
                                                    alt="User Avatar">
                                            @endif
                                            <input type="file" name="avatar" class="form-control"
                                                accept="image/*" value="{{ old('avatar', $currentUser->avatar) }}">
                                            @error('avatar')
                                                <b style="color: red">{{ $message }}</b>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Phone No</label>
                                        <div class="col-md-12">
                                            <input type="text" name="phone" placeholder="123 456 7890"
                                                class="form-control form-control-line"
                                                value="{{ old('phone', $currentUser->phone) }}">
                                            @error('phone')
                                                <b style="color: red">{{ $message }}</b>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Message</label>
                                        <div class="col-md-12">
                                            <textarea rows="5" name="message" class="form-control form-control-line">{{ old('message', $currentUser->message) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12">Select Country</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line" name="id_country">
                                                <option selected disabled>Select country</option>
                                                @foreach ($countryList as $country)
                                                    <option
                                                        {{ $country->id == $currentUser->id_country ? 'selected' : '' }}
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
                                            <button type="submit" class="btn btn-success">Update</button>
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
            </div>
        </div>
    </section><!--/slider-->
    <!-- ============================================================== -->
    <!-- End Section Content -->
    <!-- ============================================================== -->


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
