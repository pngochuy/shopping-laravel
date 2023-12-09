<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
        $categories = Category::all();

        return view('admin.category.category-list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.add-category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddCategoryRequest $request)
    {
        $data = $request->all();

        // Kiểm tra xem category đã tồn tại hay chưa
        $existingCategory = Category::where('name', $data['name'])->first();

        if ($existingCategory) {
            return redirect()->back()->with('error', __("Category: " . $existingCategory->name . " already exists"));
        }

        if (Category::create($data)) {

            return redirect()->back()->with('success', __("Category added successfully"));
        } else {
            return redirect()->back()->with('error', __("Category added failed"));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $success = Category::where("id", $id)->delete();

        if ($success) {
            return redirect()->route('category.show_list');
        } else {
            return back()->with("error", "Delete category failed!");
        }
    }
}
