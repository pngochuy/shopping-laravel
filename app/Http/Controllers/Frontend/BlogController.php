<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\Rate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BlogController extends Controller
{
    public function viewBlogList()
    {
        // Phân trang cho Blog: https://toidicode.com/pagination-trong-laravel-8-465.html
        // $blogs = Blog::paginate(3);
        // dd($blogs);

        // KO cần dùng $blogList = Blog::all(); nữa mà hãy dùng như phía dưới vừa để dùng foreach vừa phân trang với mỗi trang là 3 blog lun

        $blogList = Blog::paginate(3);

        $rateAverages = [];
        foreach ($blogList as $blog) {
            $rateAverage = round($this->getRateAverageofBlog($blog->id));
            $rateAverages[$blog->id] = $rateAverage;
        }

        // dd($rateAverages);

        return view("frontend.blog.blog", compact("blogList", "rateAverages"));
    }

    public function viewBlogDetails(int $blogID)
    {
        /*--------------------------------------------------------------
        # BLOG DETAILS
        --------------------------------------------------------------*/
        $currentBlog = Blog::findOrFail($blogID);

        /*--------------------------------------------------------------
        # RATE
        --------------------------------------------------------------*/
        $rates = Rate::select("rate")->where("blogID", $blogID)->get();
        // Nếu muốn chuyển Collection sang Array:
        // $rateValues = Rate::where("blogID", $blogID)->pluck("rate")->toArray();
        $rateCount = count($rates);
        $rateAverage = round($this->getRateAverageofBlog($blogID));

        // dd($rates); => collection chứa các đối tượng Rate, mỗi đối tượng chỉ chứa một trường là rate. (ko phải array)


        /*--------------------------------------------------------------
        # COMMENT
        - khi bạn làm việc với Eloquent ORM trong Laravel, bạn sẽ sử dụng :: để gọi các method của model.
        - ->select('comments.*', 'users.name as user_name') chọn tất cả các cột từ bảng comments và thêm cột name từ bảng users với tên alias là user_name.
        --------------------------------------------------------------*/

        // // chỉ lấy các comment chính (không phải là phản hồi)
        // $userComments = Comment::join("users", "users.id", "=", "comments.user_id")
        //     ->where("blog_id", $blogID)
        //     ->whereNull("parent_comment_id") // ->where("parent_comment_id", null)
        //     ->select(
        //         'comments.*',
        //         'users.*',
        //         'users.created_at as user_created_at', // chưa dùng user_created_at
        //         'comments.created_at as comments_created_at',
        //     )
        //     ->get();

        // // chỉ các phản hồi mà không lấy các comment chính
        // $userCommentReplies = Comment::join("users", "users.id", "=", "comments.user_id")
        //     ->where("blog_id", $blogID)
        //     ->whereNotNull("parent_comment_id") // ->where("parent_comment_id", "<>", null)
        //     ->select(
        //         'comments.*',
        //         'users.*',
        //         'users.created_at as user_created_at', // chưa dùng user_created_at
        //         'comments.created_at as comments_created_at',
        //     )
        //     ->get();

        // lấy toàn bộ comment (bao gồm comment chính và phản hồi)
        $userComments = Comment::join("users", "users.id", "=", "comments.user_id")
            ->where("blog_id", $blogID)
            ->select(
                'comments.*',
                'users.*',
                'users.created_at as user_created_at', // chưa dùng user_created_at
                'comments.created_at as comments_created_at',
            )
            ->get();
                
        // dd($userCommentReplies);

        $commentCount = count($userComments);

        return view('frontend.blog.blog_detail', compact("currentBlog", "blogID", "rateCount", "rateAverage", "userComments", "commentCount"));
    }

    function getRateAverageofBlog($blogID)
    {
        $rates = Rate::select("rate")->where("blogID", $blogID)->get();
        // Nếu muốn chuyển Collection sang Array:
        // $rateValues = Rate::where("blogID", $blogID)->pluck("rate")->toArray();

        $rateAverage = 0;

        foreach ($rates as $rate) {
            $rateAverage += $rate->rate;
        }
        $rateCount = count($rates);
        if ($rateCount > 0) {
            $rateAverage /= $rateCount;
        }

        return $rateAverage;
    }
}
