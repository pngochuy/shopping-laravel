<?php
use Carbon\Carbon;
?>

@extends('frontend.layouts.app')

@section('content')
    <div class="blog-post-area">
        <h2 class="title text-center">Latest From our Blog</h2>

        @foreach ($blogList as $blog)
            <div class="single-blog-post">
                <h3>{{ $blog->title }}</h3>
                <div class="post-meta">
                    <ul>
                        {{-- CHƯA BIẾT TÁC GIẢ TẠO BLOG NÊN DÙNG ADMIN --}}
                        <li><i class="fa fa-user"></i> Admin</li>
                        <li><i class="fa fa-clock-o"></i> {{ Carbon::parse($blog->created_at)->format('H:i:s A') }}</li>
                        <li><i class="fa fa-calendar"></i> {{ Carbon::parse($blog->created_at)->format('Y-m-d') }}</li>
                    </ul>
                    <span>
                        @for ($i = 1; $i <= 5; $i++)
                            <i
                                class="fa fa-star{{ $rateAverages[$blog->id] ? ($rateAverages[$blog->id] >= $i ? '' : '-o') : '-o' }}"></i>
                        @endfor
                        {{-- Nếu bạn muốn hiển thị một nửa sao --}}
                        {{-- <i class="fa fa-star-half-o"></i> --}}
                    </span>
                </div>
                <a href="">
                    <img src="{{ asset('upload/user/files/' . $blog->image) }}" alt="" width="250px" height="250px">
                </a>
                <p>{{ $blog->description }}</p>
                <a class="btn btn-primary" href="{{ route('blogDetails', ['blogID' => $blog->id]) }}">Read More</a>
            </div>
        @endforeach

        <div class="pagination-area">
            {{-- <ul class="pagination">
                <li><a href="" class="active">1</a></li>
                <li><a href="">2</a></li>
                <li><a href="">3</a></li>
                <li><a href=""><i class="fa fa-angle-double-right"></i></a></li>
            </ul> --}}

            {{-- Mặc định cái phân trang có CSS mặc định hơi xấu --}}
            {{-- {{ $blogList->links() }} --}}

            {{-- Phân trang có CSS đẹp --}}
            {{ $blogList->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
