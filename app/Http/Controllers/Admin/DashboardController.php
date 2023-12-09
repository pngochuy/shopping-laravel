<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // hàm khởi tạo của hướng đối tượng 
    public function __construct()
    {
        // kiem tra e co quyen vao k?
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return view("admin.dashboard");
    }
}
