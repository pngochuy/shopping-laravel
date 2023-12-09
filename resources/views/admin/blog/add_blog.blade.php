@extends('admin.layouts.app')

@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Add Blog</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('blogList') }}">Blog
                                    List</a></li>
                            <li class="breadcrumb-item" aria-current="page">Add Blog</li>
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
            <div class="col-lg-8 col-xlg-9 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('addBlog') }}" method="POST" class="form-horizontal form-material"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="col-md-12">Title <span style="font-weight: bold; color:red">(*)</span></label>
                                <div class="col-md-12">
                                    <input type="text" name="blogTitle" placeholder="title..."
                                        class="form-control form-control-line" value="{{ old('blogTitle') }}">
                                    @error('blogTitle')
                                        <b style="color: red">{{ $message }}</b>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Image </label>
                                <div class="col-md-12">
                                    <input type="file" name="blogImage" id="" accept="image/*">
                                    <br>
                                    @error('blogImage')
                                        <b style="color: red">{{ $message }}</b>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Description</label>
                                <textarea name="blogDescription" class="form-control" rows="5">{{ old('blogDescription') }}</textarea>
                                @error('blogDescription')
                                    <b style="color: red">{{ $message }}</b>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label>Content</label>
                                <textarea name="blogContent" class="form-control" id="editor1_blog_content">{{ old('blogContent') }}</textarea>
                                @error('blogContent')
                                    <b style="color: red">{{ $message }}</b>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success">Add Blog</button>
                                </div>
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if (session('failed'))
                                    <div class="alert alert-danger">
                                        {{ session('failed') }}
                                    </div>
                                @endif
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
