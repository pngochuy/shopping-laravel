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
                    <div class="blog-post-area">
                        <h2 class="title text-center">Edit Product</h2>
                        <div class="signup-form" style="margin-bottom: 30px;"><!--add product form-->

                            <form action="{{ route('product.edit', ['id' => $currentProduct->id]) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                {{-- name, price, detail, image (tối đa 3 ảnh), category_id, brand_id, user_id, status, sale_price, company_profile --}}

                                <input type="text" name="name" placeholder="Name"
                                    value="{{ old('name', $currentProduct->name) }}" />
                                @error('name')
                                    <b style="color: red">{{ $message }}</b>
                                @enderror

                                <input type="number" name="price" placeholder="Price"
                                    value="{{ old('price', $currentProduct->price) }}" />
                                @error('price')
                                    <b style="color: red">{{ $message }}</b>
                                @enderror

                                {{-- với thẻ input file, không thể sử dụng old() trực tiếp để giữ giá trị file trước đó vì lý do bảo mật. Xử lý các trường hợp này một cách riêng biệt trong controller nếu có lỗi. --}}
                                <div class="image-container">
                                    @foreach (json_decode($currentProduct->image) as $image)
                                        <div class="image-item">
                                            <img class="image"
                                                src="{{ asset('upload/product/' . $currentProduct->user_id . '/' . $image) }}"
                                                alt="">
                                            <p>{{ $image }}</p>
                                            <input class="image-checkbox" type="checkbox" name="selected_images[]"
                                                value="{{ $image }}" style="width: 20px;">
                                        </div>
                                    @endforeach
                                </div>
                                <input type="file" name="image[]" accept="image/*" multiple />
                                @error('image.*')
                                    @foreach ($errors->get('image.*') as $error)
                                        <b style="color: orange">{{ $error[0] }}</b><br>
                                    @endforeach
                                @enderror
                                @error('image')
                                    <b style="color: red">{{ $message }}</b><br>
                                @enderror
                                @if (session('upload-failed'))
                                    <div class="mt-4 alert alert-danger">
                                        {{ session('upload-failed') }}
                                    </div>
                                @endif

                                <select name="category_id" id="">
                                    <option selected disabled>Select category</option>
                                    @if ($categoryList->isempty())
                                        <option selected disabled>N/A</option>
                                    @else
                                        @foreach ($categoryList as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $currentProduct->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('category_id')
                                    <b style="color: red">{{ $message }}</b>
                                @enderror

                                <select name="brand_id" id="">
                                    <option selected disabled>Select brand</option>
                                    @if ($brandList->isempty())
                                        <option selected disabled>N/A</option>
                                    @else
                                        @foreach ($brandList as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ old('brand_id', $currentProduct->brand_id) == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('brand_id')
                                    <b style="color: red">{{ $message }}</b>
                                @enderror

                                <select name="status">
                                    <option value="0"
                                        {{ old('status', $currentProduct->status) == 0 ? 'selected' : '' }}>
                                        New
                                    </option>
                                    <option value="1"
                                        {{ old('status', $currentProduct->status) == 1 ? 'selected' : '' }}>
                                        Sale
                                    </option>
                                </select>
                                @error('status')
                                    <b style="color: red">{{ $message }}</b>
                                @enderror

                                @if ($currentProduct->status === 1)
                                    <div class="percentage-input-container sale-price-container"
                                        style="display: flex; align-items: center;">
                                        <input type="number" name="sale_price" placeholder="0"
                                            style="width: 30%; margin-right: 5px;"
                                            value="{{ old('sale_price', $currentProduct->sale_price) }}">
                                        %

                                    </div>
                                @endif


                                <input type="text" name="company_profile" placeholder="Company profile"
                                    value="{{ old('company_profile', $currentProduct->company_profile) }}">
                                @error('company_profile')
                                    <b style="color: red">{{ $message }}</b>
                                @enderror

                                <textarea name="detail" id="" cols="30" rows="10" placeholder="Detail">{{ old('detail', $currentProduct->detail) }}</textarea>
                                @error('detail')
                                    <b style="color: red">{{ $message }}</b>
                                @enderror

                                <button type="submit" class="btn btn-default">Update</button>
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
                            </form>
                        </div>
                    </div>
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

    <script>
        $(document).ready(function() {

            // $('.sale-price-container').hide();

            // xử lí hiện ô sale_price
            $('select[name="status"]').change(function() {
                if ($(this).val() === '1') {
                    $('.sale-price-container').show();
                } else {
                    $('.sale-price-container').hide();
                    $('input[name="sale_price"]').val("")
                }
            });

        })
    </script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('js/price-range.js') }}"></script>
    <script src="{{ asset('js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
