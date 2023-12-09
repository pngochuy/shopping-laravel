@extends('admin.layouts.app')

@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Brand List</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Brand List</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <!-- Row -->
        <div class="row">
            <div class="col-lg-12 col-xlg-9 col-md-12">
                <div class="card">
                    <div class="card-title" style="padding: 1.25rem 0 0 1.25rem;">
                        <div class="col-sm-12">
                            <a href="{{ route('brand.create') }}" class="btn btn-success" style="color: white">Add
                                more</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Default Table -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($brands->isempty())
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <h2>No brands available!</h2>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($brands as $brand)
                                        <tr>
                                            <th scope="row">{{ $brand->id }}</th>
                                            <th>{{ $brand->name }}</th>
                                            <td>
                                                {{-- <a href="{{ route('editCountry', ['id' => $country->id]) }}" type="btn">
                                            <span style="color: blue;">
                                                <i class="mdi mdi-lead-pencil"></i> Edit
                                            </span>
                                        </a> --}}
                                                &nbsp;
                                                <a href="{{ route('brand.delete', ['id' => $brand->id]) }}" type="btn">
                                                    <span style="color: blue;">
                                                        <i class="mdi mdi-garage"></i> Delete
                                                    </span>
                                                </a>

                                                {{-- <form
                                                    action="{{ route('category.confirm-destroy', ['id' => $category_id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <!-- Các trường dữ liệu khác có thể cần cho form xác nhận -->

                                                    <button type="submit" name="confirm_delete">Confirm Delete</button>
                                                </form> --}}


                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <!-- End Default Table Example -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
