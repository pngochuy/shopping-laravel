@extends('admin.layouts.app')

@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Country List</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Country List</li>
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
                            <a href="{{ route('addCountry') }}" class="btn btn-success" style="color: white">Add more</a>
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
                                @if ($countryList->isempty())
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <h2>No country available!</h2>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($countryList as $country)
                                        <tr>
                                            <th scope="row">{{ $country->id }}</th>
                                            <td>{{ $country->country }}</td>
                                            <td>
                                                {{-- <a href="{{ route('editCountry', ['id' => $country->id]) }}" type="btn">
                                                <span style="color: blue;">
                                                    <i class="mdi mdi-lead-pencil"></i> Edit
                                                </span>
                                            </a> --}}
                                                &nbsp;
                                                <a href="{{ route('deleteCountry', ['id' => $country->id]) }}"
                                                    type="btn">
                                                    <span style="color: blue;">
                                                        <i class="mdi mdi-garage"></i> Delete
                                                    </span>
                                                </a>


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
