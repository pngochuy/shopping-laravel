<?php
use Carbon\Carbon;
?>

@auth

    <?php
    
    $userId = Auth::id();
    // But to retrieve user's data other than id, you use: $email = Auth::user()->email;
    // ở đây chưa cần dùng currentUser cho lắm!
    $currentUser = \App\Models\User::findorFail($userId); // dùng Namespace cho Model
    
    // Auth::user() => DÙNG CÂU LỆNH NÀY ĐỂ LẤY TOÀN BỘ THÔNG TIN CỦA USER ĐÃ LOGIN

    // if (!$currentUser) {
    //     return redirect()->back();
    //     exit();
    // }
    
    ?>
@endauth

@extends('frontend.layouts.app')


@section('content')
    <div class="blog-post-area">
        <h2 class="title text-center">Latest From our Blog</h2>
        <div class="single-blog-post">
            <h3>{{ $currentBlog->title }}</h3>
            <div class="post-meta">
                <ul>
                    {{-- CHƯA BIẾT TÁC GIẢ TẠO BLOG LÀ AI NÊN ĐĂT TÊN LÀ "ADMIN" --}}
                    <li><i class="fa fa-user"></i> Admin</li>
                    <li><i class="fa fa-clock-o"></i> {{ Carbon::parse($currentBlog->created_at)->format('H:i:s A') }}</li>
                    <li><i class="fa fa-calendar"></i> {{ Carbon::parse($currentBlog->created_at)->format('Y-m-d') }}</li>
                </ul>
                <span>
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa fa-star{{ $rateAverage ? ($rateAverage >= $i ? '' : '-o') : '-o' }}"></i>
                    @endfor
                    {{-- Nếu bạn muốn hiển thị một nửa sao --}}
                    {{-- <i class="fa fa-star-half-o"></i> --}}
                </span>
            </div>
            <a href="">
                <img src="{{ asset('upload/user/files/' . $currentBlog->image) }}" alt="">
            </a>
            <p>{{ $currentBlog->description }}</p>
            <div class="pager-area">
                <ul class="pager pull-right">
                    <li><a href="#">Pre</a></li>
                    <li><a href="#">Next</a></li>
                </ul>
            </div>
        </div>
    </div><!--/blog-post-area-->

    <div class="rating-area">
        {{-- <ul class="ratings">
            <li class="rate-this">Rate this item:</li>
            <li>
                <i class="fa fa-star color"></i>
                <i class="fa fa-star color"></i>
                <i class="fa fa-star color"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
            </li>
            <li class="color">(6 votes)</li>
        </ul> --}}

        <div class="d-flex justify-content-start align-items-center rate">
            <span class="rate-this">Rate this item:</span>
            <div class="vote">
                @for ($i = 1; $i <= 5; $i++)
                    <div
                        class="star_{{ $i }} ratings_stars {{ $rateAverage ? ($rateAverage >= $i ? 'ratings_over' : '') : '' }}">
                        <input value="{{ $i }}" type="hidden">
                    </div>
                @endfor

                <span class="rate-np">{{ $rateAverage ? $rateAverage : '0.0' }}</span>
                <span
                    class="rate-np">({{ $rateCount ? ($rateCount > 1 ? $rateCount . ' votes' : $rateCount . ' vote') : '0 vote' }})</span>
            </div>


        </div>
        <ul class="tag">
            <li>TAG:</li>
            <li><a class="color" href="">Pink <span>/</span></a></li>
            <li><a class="color" href="">T-Shirt <span>/</span></a></li>
            <li><a class="color" href="">Girls</a></li>
        </ul>
    </div><!--/rating-area-->

    <div class="socials-share">
        <a href=""><img src="{{ asset('images/blog/socials.png') }}" alt=""></a>
    </div><!--/socials-share-->

    {{-- <div class="media commnets">
        <a class="pull-left" href="#">
            <img class="media-object" src="images/blog/man-one.jpg" alt="">
        </a>
        <div class="media-body">
            <h4 class="media-heading">Annie Davis</h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
                ea commodo consequat.</p>
            <div class="blog-socials">
                <ul>
                    <li><a href=""><i class="fa fa-facebook"></i></a></li>
                    <li><a href=""><i class="fa fa-twitter"></i></a></li>
                    <li><a href=""><i class="fa fa-dribbble"></i></a></li>
                    <li><a href=""><i class="fa fa-google-plus"></i></a></li>
                </ul>
                <a class="btn btn-primary" href="">Other Posts</a>
            </div>
        </div>
    </div> <!--Comments--> --}}
    <div class="response-area">
        <h2>{{ $commentCount ? $commentCount : '0' }} RESPONSES</h2>
        <ul class="media-list">
            {{-- userComments: join table 'users' and 'comments' --}}
            @foreach ($userComments as $userComment)
                @if ($userComment->parent_comment_id == null)
                    <li class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="{{ asset('upload/user/avatar/' . $userComment->avatar) }}"
                                alt="" width="100" height="120">
                        </a>
                        <div class="media-body">
                            <ul class="sinlge-post-meta">
                                <li><i class="fa fa-user"></i>{{ $userComment->name }}</li>
                                {{-- <li><i class="fa fa-clock-o"></i> 1:33 pm</li>
                        <li><i class="fa fa-calendar"></i> DEC 5, 2013</li> --}}
                                <li><i class="fa fa-clock-o"></i>
                                    {{ Carbon::parse($userComment->comments_created_at)->format('H:i:s A') }}</li>
                                <li><i class="fa fa-calendar"></i>
                                    {{ Carbon::parse($userComment->comments_created_at)->format('Y-m-d') }}</li>
                            </ul>
                            <p>{{ $userComment->content }}</p>
                            <a class="btn btn-primary btn-reply"><i class="fa fa-reply"></i>&nbsp;&nbsp;Reply</a>
                            {{-- Ajax show/hide --}}
                            <div class="reply-textarea" style="display: none">
                                <textarea placeholder="Type your reply here..."></textarea>
                                <button class="btn btn-success btn-submit-reply"
                                    value="{{ $userComment->comment_id }}">Submit
                                    Reply</button>
                            </div>
                        </div>

                        {{-- comments replies --}}
                        @foreach ($userComments as $userComment_reply)
                            @if ($userComment_reply->parent_comment_id != null && $userComment_reply->parent_comment_id == $userComment->comment_id)
                                <div class="media second-media">
                                    <a class="pull-left" href="#">
                                        <img class="media-object"
                                            src="{{ asset('upload/user/avatar/' . $userComment_reply->avatar) }}"
                                            alt="" width="100" height="120">
                                    </a>
                                    <div class="media-body">
                                        <ul class="sinlge-post-meta">
                                            <li><i class="fa fa-user"></i>{{ $userComment_reply->name }}</li>
                                            {{-- <li><i class="fa fa-clock-o"></i> 1:33 pm</li>
                                            <li><i class="fa fa-calendar"></i> DEC 5, 2013</li> --}}
                                            <li><i class="fa fa-clock-o"></i>
                                                {{ Carbon::parse($userComment_reply->comments_created_at)->format('H:i:s A') }}
                                            </li>
                                            <li><i class="fa fa-calendar"></i>
                                                {{ Carbon::parse($userComment_reply->comments_created_at)->format('Y-m-d') }}
                                            </li>
                                        </ul>
                                        <p><span style="color: green; ">{{ '@' }}{{ $userComment->name }}</span>
                                            {{ $userComment_reply->content }}</p>

                                        <a class="btn btn-primary btn-reply"><i
                                                class="fa fa-reply"></i>&nbsp;&nbsp;Reply</a>
                                        {{-- Ajax show/hide --}}
                                        <div class="reply-textarea" style="display: none">
                                            <textarea placeholder="Type your reply here..."></textarea>
                                            <button class="btn btn-success btn-submit-reply"
                                                value="{{ $userComment_reply->comment_id }}">Submit
                                                Reply</button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </li>
                @endif
            @endforeach



        </ul>
    </div><!--/Response-area-->
    <div class="replay-box">
        <div class="row">
            <div class="col-sm-12">

                @if (Auth::check())
                    <h2>Leave a reply</h2>

                    <div class="text-area">
                        <div class="blank-arrow">
                            <label>Your Name</label>
                        </div>
                        <span>*</span>
                        <textarea class="myContent" name="content" rows="11"></textarea>
                        <button class="btn btn-primary" id="post-comment">Post comment</button>
                    </div>
                @else
                    <div class="alert alert-danger alert-dismissible show " role="alert"
                        style="background-color: #fff3cd">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        You must<a href="{{ route('loginMember') }}">&nbsp;login&nbsp;</a>to post your comment
                        here!
                    </div>
                @endif
            </div>
        </div>
    </div><!--/Repaly Box-->

    <!-- Scripts -->
    {{-- https://laracasts.com/discuss/channels/laravel/is-mixing-javascript-with-blade-syntax-a-bad-practice --}}
    <script>
        $(document).ready(function() {

            /* -------------------- SET UP AJAX -------------------- */
            // dán link bên header: <meta name="csrf-token" content="{{ csrf_token() }}">
            // thế này Ajax mới hoạt động
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /* -------------------- VOTE -------------------- */
            $('.ratings_stars').hover(
                // Handles the mouseover
                function() {
                    $(this).prevAll().andSelf().addClass('ratings_hover');
                    // $(this).nextAll().removeClass('ratings_vote'); 
                },
                function() {
                    $(this).prevAll().andSelf().removeClass('ratings_hover');
                    // set_votes($(this).parent());
                }
            );

            $('.ratings_stars').click(function() {

                // goi php vao thì dùng dấu như dưới
                var checkLogin = "{{ Auth::check() }}";
                // alert(checkLogin) => Trả về giá trị là 1 nếu đã login, và 0 thì chưa login

                if (checkLogin) {

                    let userID = "{{ Auth::id() }}";
                    let blogID = "{{ $blogID }}";
                    var rate = $(this).find("input").val();
                    // alert(rate);
                    if ($(this).hasClass('ratings_over')) {
                        $('.ratings_stars').removeClass('ratings_over');
                        $(this).prevAll().andSelf().addClass('ratings_over');
                    } else {
                        $(this).prevAll().andSelf().addClass('ratings_over');
                    }

                    // phan tich xem rate co gi? de tao table co đung?
                    // id, rate, id_blog, id_user
                    // dung ajax gui qua controller va insert table rate

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('rateBlog') }}',
                        data: {
                            userID: userID,
                            blogID: blogID,
                            rate: rate,
                        },
                        success: function(data) {
                            console.log(data);

                            // $(".rate").html(data);
                        }
                    });


                } else {
                    alert("vui long login de rate");
                }

            });


            /* -------------------- COMMENT -------------------- */
            $("#post-comment").click(function() {

                let checkLogin = "{{ Auth::check() }}";

                if (checkLogin) {

                    let userID = "{{ Auth::id() }}";
                    let blogID = "{{ $blogID }}";
                    let myContent = $(".myContent").val();

                    if (myContent.trim() !== "") {
                        // userID, blogID, content, parent_comment_id
                        ajaxComment(userID, blogID, myContent, null);

                    } else {
                        alert("You haven't entered the comment yet!");
                    }
                }
            });


            /* -------------------- REPLY COMMENT -------------------- */
            // Ẩn tất cả các ô textarea khi trang tải lên
            // $('.reply-textarea').hide();

            $(document).on('click', '.btn-reply', function() {
                // $(".btn-reply").click(function() { // not working with jQuery (ajax)
                // // Ẩn tất cả các ô textarea khác trước khi hiện ô mới
                $('.reply-textarea').hide();

                $(this).closest(".media-body").find(".reply-textarea").show().css({
                    "margin-top": "60px"
                });
                $(this).closest(".media-body").find(".btn-submit-reply").css({
                    "margin-top": "10px"
                });

                // Xử lý sự kiện khi nhấn ra ngoài ô textarea khi user nhấn ra ngoài bất kỳ nơi nào trên trang
                $(document).mouseup(function(e) {
                    var container = $(".reply-textarea");
                    var input = container.find("textarea"); // tìm thẻ textarea
                    if (!container.is(e.target) && container.has(e.target).length ===
                        0) {
                        container.hide();
                        input.val("");
                    }
                });
            });
            $(document).on('click', '.btn-submit-reply', function() {
                // $(".btn-submit-reply").click(function() { // not working with jQuery (ajax)

                let checkLogin = "{{ Auth::check() }}";

                if (checkLogin) {

                    let userID = "{{ Auth::id() }}";
                    let blogID = "{{ $blogID }}";
                    let myContent = $(this).closest(".reply-textarea").find("textarea").val();
                    let parentCommentID = $(this).val();

                    if (myContent.trim() !== "") {
                        // console.log(myContent)
                        // console.log(" --- " + parentCommentID)

                        // userID, blogID, content, parent_comment_id
                        ajaxComment(userID, blogID, myContent, parentCommentID);

                    } else {
                        alert("You haven't entered the comment yet!");
                    }
                }

            });

        });

        function ajaxComment(userID, blogID, myContent, parent_comment_id) {
            // userID, blogID, content, parent_comment_id

            $.ajax({
                type: "POST",
                url: '{{ route('commentBlog') }}',
                data: {
                    user_id: userID,
                    blog_id: blogID,
                    content: myContent,
                    parent_comment_id: parent_comment_id
                },
                dataType: 'json', // Cho biết dữ liệu trả về là JSON, và tự động chuyển đổi dữ liệu JSON nhận được từ backend thành một đối tượng JavaScript
                success: function(data) {
                    // console.log("data: " + typeof data); => Object

                    // Chuyển đổi JSON thành mảng JavaScript => ko cần vì có dataType: 'json'
                    // let userComments = JSON.parse(data);
                    let userComments = data;

                    // Thực hiện cập nhật giao diện người dùng với mảng object userComments
                    updateCommentUI(userComments);

                    // Xóa nội dung textarea sau khi gửi comment thành công
                    $(".myContent").val("");

                },
                error: function(xhr, status, error) {
                    var err = JSON.parse(xhr.responseText);
                    console.log(err.message); // In thông báo lỗi từ backend
                }
            })

        }

        function updateCommentUI(userComments) {
            // Là một hàm Blade trong Laravel giúp xây dựng đường dẫn đầy đủ tới thư mục public của ứng dụng. Trong trường hợp này, khi truyền một chuỗi rỗng '' vào hàm asset, nó trả về đường dẫn cơ sở của tất cả các tài nguyên.
            const assetBaseUrl = "{{ asset('') }}";
            let htmlUserComments = '';

            userComments.forEach((userComment) => {
                if (userComment.parent_comment_id === null) {
                    htmlUserComments += `<li class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="${assetBaseUrl}upload/user/avatar/${userComment.avatar}" alt="" width="100" height="120">
                </a>
                <div class="media-body">
                    <ul class="sinlge-post-meta">
                        <li><i class="fa fa-user"></i>${userComment.name}</li>
                        <li><i class="fa fa-clock-o"></i>${userComment.comments_created_at}</li>
                        <li><i class="fa fa-calendar"></i>${userComment.comments_created_at}</li>
                    </ul>
                    <p>${userComment.content}</p>
                    <a class="btn btn-primary btn-reply"><i class="fa fa-reply"></i>&nbsp;&nbsp;Reply</a>
                    <div class="reply-textarea" style="display: none">
                        <textarea placeholder="Type your reply here..."></textarea>
                        <button class="btn btn-success btn-submit-reply" value="${userComment.comment_id}">Submit Reply</button>
                    </div>
                </div>
            </li>`;

                    // comments replies
                    userComments.forEach((userComment_reply) => {
                        if (userComment_reply.parent_comment_id !== null && userComment_reply
                            .parent_comment_id === userComment.comment_id) {
                            htmlUserComments += `<div class="media second-media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="${assetBaseUrl}upload/user/avatar/${userComment_reply.avatar}" alt="" width="100" height="120">
                        </a>
                        <div class="media-body">
                            <ul class="sinlge-post-meta">
                                <li><i class="fa fa-user"></i>${userComment_reply.name}</li>
                                <li><i class="fa fa-clock-o"></i>${userComment_reply.comments_created_at}</li>
                                <li><i class="fa fa-calendar"></i>${userComment_reply.comments_created_at}</li>
                            </ul>
                            <p><span style="color: green;">@${userComment.name}</span>&nbsp;${userComment_reply.content}</p>
                            <a class="btn btn-primary btn-reply"><i class="fa fa-reply"></i>&nbsp;&nbsp;Reply</a>
                            <div class="reply-textarea" style="display: none">
                                <textarea placeholder="Type your reply here..."></textarea>
                                <button class="btn btn-success btn-submit-reply" value="${userComment_reply.comment_id}">Submit Reply</button>
                            </div>
                        </div>
                    </div>`;
                        }
                    });
                }
            });

            // Append the HTML to the container
            $('.media-list').html(htmlUserComments);
        }
    </script>
@endsection
