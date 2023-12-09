<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function comment(Request $request)
    {
        $data = $request->all();

        if (Comment::create($data)) {
            // comment created successfully

            // lấy toàn bộ comment (bao gồm comment chính và phản hồi)
            $userComments = Comment::join("users", "users.id", "=", "comments.user_id")
                ->where("blog_id", $data["blog_id"])
                ->select(
                    'comments.*',
                    'users.*',
                    'users.created_at as user_created_at', // chưa dùng user_created_at
                    'comments.created_at as comments_created_at',
                )
                ->get();


            // $output = $this->getComments($userComments);

            // Chuyển đổi dữ liệu thành dạng JSON
            $userCommentsJson = json_encode($userComments);

            // Gửi dữ liệu JSON về Ajax
            return $userCommentsJson;
        } else {
            echo "Comment created failed";
        }
    }


    // Not using
    function getComments($userComments)
    {
        $output = "";

        foreach ($userComments as $userComment) {
            if ($userComment->parent_comment_id == null) {

                $output .= '<li class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="' . asset('upload/user/avatar/' . $userComment->avatar) . '"
                        alt="" width="100" height="120">
                </a>
                <div class="media-body">
                    <ul class="sinlge-post-meta">
                        <li><i class="fa fa-user"></i>' . $userComment->name . '</li>
                        <li><i class="fa fa-clock-o"></i>' . Carbon::parse($userComment->comments_created_at)->format('H:i:s A') . '</li>
                        <li><i class="fa fa-calendar"></i>' . Carbon::parse($userComment->comments_created_at)->format('Y-m-d') . '</li>
                    </ul>
                    <p>' . $userComment->content . '</p>
                    <a class="btn btn-primary btn-reply"><i class="fa fa-reply"></i>&nbsp;&nbsp;Reply</a>
                    <div class="reply-textarea" style="display: none">
                        <textarea placeholder="Type your reply here..."></textarea>
                        <button class="btn btn-success btn-submit-reply" value="' . $userComment->comment_id . '">Submit Reply</button>
                    </div>
                </div>';

                // comments replies
                foreach ($userComments as $userComment_reply) {
                    if ($userComment_reply->parent_comment_id != null && $userComment_reply->parent_comment_id == $userComment->comment_id) {
                        $output .= '<div class="media second-media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="' . asset('upload/user/avatar/' . $userComment_reply->avatar) . '"
                                alt="" width="100" height="120">
                        </a>
                        <div class="media-body">
                            <ul class="sinlge-post-meta">
                                <li><i class="fa fa-user"></i>' . $userComment_reply->name . '</li>
                                <li><i class="fa fa-clock-o"></i>' . Carbon::parse($userComment_reply->comments_created_at)->format('H:i:s A') . '</li>
                                <li><i class="fa fa-calendar"></i>' . Carbon::parse($userComment_reply->comments_created_at)->format('Y-m-d') . '</li>
                            </ul>
                            <p><span style="color: green; ">' . '@' . $userComment->name . '</span>&nbsp;' . $userComment_reply->content . '</p>
                            <a class="btn btn-primary btn-reply"><i class="fa fa-reply"></i>&nbsp;&nbsp;Reply</a>
                            <div class="reply-textarea" style="display: none">
                                <textarea placeholder="Type your reply here..."></textarea>
                                <button class="btn btn-success btn-submit-reply" value="' . $userComment_reply->comment_id . '">Submit Reply</button>
                            </div>
                        </div>
                    </div>';
                    }
                }

                $output .= '</li>';
            }
        }

        return $output;
    }
}
