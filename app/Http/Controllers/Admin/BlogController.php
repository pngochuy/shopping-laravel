<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddBlogRequest;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    // hàm khởi tạo của hướng đối tượng 
    public function __construct()
    {
        // kiểm tra có quyền để vào không?. Có thể đặt trong Controller hoặc Route khi user vào (Protecting Routes)
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogList = Blog::all();
        return view("admin.blog.blog_list", compact("blogList"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.blog.add_blog");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddBlogRequest $request)
    {
        $data = $request->all();
        $file = $request->blogImage;

        $blog = new Blog();
        $blog->title = $data['blogTitle'];
        $blog->description = $data['blogDescription'];

        if (!empty($file)) {
            $data["blogImage"] = $file->getClientOriginalName(); //  lưu tên tệp ảnh của file Object
            $blog->image = $data["blogImage"];
        }

        $blog->content = $data['blogContent'];
        $success = $blog->save();

        if ($success) {
            $directory = "upload/user/files";
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            $file->move("upload/user/files", $file->getClientOriginalName());

            return redirect()->back()->with('success', __("Upload blog successfully"));
        } else {
            return redirect()->back()->with('failed', __("Blog upload failed"));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view("admin.blog.add_blog");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Lưu ý: ko còn dùng 'string $id' làm tham số đầu vào nữa.
        $currentBlog = Blog::find($id);

        return view("admin.blog.edit_blog", compact("currentBlog"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AddBlogRequest $request, string $id)
    {
        $currentBlog = Blog::findOrFail($id);

        $data = $request->all();
        $file = $request->blogImage;



        if (!empty($file)) {
            $data["blogImage"] = $file->getClientOriginalName();

            $currentBlog->update([
                'title' => $data['blogTitle'],
                'description' => $data['blogDescription'],
                'image' => $data['blogImage'],
                'content' => $data['blogContent'],
            ]);

            // Thực hiện lưu tệp ảnh
            $directory = "upload/user/files";
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            $file->move($directory, $file->getClientOriginalName());

            return redirect()->back()->with('success', __("Edit blog successfully"));
        } else {
            return redirect()->back()->with('failed', __("Edit blog failed"));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $success = Blog::where("id", $id)->delete();

        if ($success) {
            return redirect()->route('blogList');
        } else {
            return back()->with("error", "Delete country failed!");
        }
    }
}
