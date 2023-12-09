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
                        <a href="{{ route('product.add') }}">
                            <h2 class="title text-center">Click Add Product</h2>
                        </a>
                    </div>
                    <div class="table-responsive cart_info">
                        <table class="table table-condensed border">
                            <thead>
                                {{-- name, price, detail, image (tối đa 3 ảnh), category_id, brand_id, user_id, status, sale_price, company_profile --}}
                                <tr class="cart_menu">
                                    <th class="id">ID</th>
                                    <th class="name">Name</th>
                                    <th class="price">Price</th>
                                    <th class="price">Detail</th>
                                    <th class="image">Image</th>
                                    <th class="category">Category</th>
                                    <th class="brand">Brand</th>
                                    {{-- <td class="image">Image</td> --}}
                                    <th class="status">Status</th>
                                    <th class="sale_price">Sale Price</th>
                                    <th class="company_profile">Company Profile</th>

                                    <th class="image">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($productList->isempty())
                                    <tr>
                                        <td colspan="12" class="text-center" style="color: red;">
                                            <h2 class="">No product available!</h2>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($productList as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>{{ $product->detail }}</td>
                                            <td>
                                                @foreach (json_decode($product->image) as $image)
                                                    <img width="50"
                                                        src="{{ asset('upload/product/' . $product->user_id . '/' . $image) }}"
                                                        alt="">
                                                @endforeach
                                            </td>
                                            <td>{{ $product->category_name }}</td>
                                            <td>{{ $product->brand_name }}</td>
                                            <td>{{ $product->status === 0 ? 'New' : 'Sale' }}</td>
                                            <td>{{ $product->sale_price }}</td>
                                            <td>{{ $product->company_profile }}</td>
                                            <td class='cart_delete'>
                                                <a class='cart_quantity_delete'
                                                    href="{{ route('product.edit', ['id' => $product->id]) }}"><i
                                                        class='fa fa-pencil'></i></a>
                                                <a class='cart_quantity_delete'
                                                    href='php/product/deleteProduct.php?id=" . $value["id"] . "'><i
                                                        class='fa fa-times'></i></a>
                                            </td>

                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

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


    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('js/price-range.js') }}"></script>
    <script src="{{ asset('js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
