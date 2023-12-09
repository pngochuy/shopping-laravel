<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/* 16/10/2023: Tạo Dashboard cho Admin */

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\BlogController as FrontendBlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Frontend\CommentController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\RateController;
use App\Http\Controllers\Frontend\UserController as FrontendUserController;
use App\Http\Controllers\Frontend\ProductController;


// Laravel Auth (version Bootstrap) Routes sẽ được gọi ở trong file routes/web.php
// sau khi cài Auth Bootstrap thì nó tự có 2 dòng (34, 36)
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(["prefix" => "admin"], function () {
    // NÊN ĐẶT TÊN `Route names should always be unique.`

    Route::get("/dashboard", [DashboardController::class, "index"])->name('dashboard');

    // User profile
    Route::get("/profile", [UserController::class, "edit"])->name('profile');
    Route::post("/profile", [UserController::class, "update"]);

    // Country
    Route::get("/country/list", [CountryController::class, "index"])->name('countryList');
    Route::get("/country/create", [CountryController::class, "create"])->name('addCountry');
    Route::post("/country/create", [CountryController::class, "store"]);
    Route::get("/country/delete/{id}", [CountryController::class, "destroy"])->name("deleteCountry");

    // Blog
    Route::get("/blog/list", [BlogController::class, "index"])->name('blogList');
    Route::get("/blog/create", [BlogController::class, "create"])->name('addBlog');
    Route::post("/blog/create", [BlogController::class, "store"]);
    Route::get("/blog/edit/{id}", [BlogController::class, "edit"])->name('editBlog');
    Route::post("/blog/edit/{id}", [BlogController::class, "update"]);
    Route::get("/blog/delete/{id}", [BlogController::class, "destroy"])->name('deleteBlog');

    // Category
    Route::get("/category/list", [CategoryController::class, "index"])->name('category.show_list');
    Route::get("category/create", [CategoryController::class, "create"])->name('category.create');
    Route::post("category/create", [CategoryController::class, "store"]);
    Route::get("category/delete/{id}", [CategoryController::class, "destroy"])->name('category.delete');

    // Brand
    Route::get("/brand/list", [BrandController::class, "index"])->name('brand.show_list');
    Route::get("brand/create", [BrandController::class, "create"])->name('brand.create');
    Route::post("brand/create", [BrandController::class, "store"]);
    Route::get("brand/delete/{id}", [BrandController::class, "destroy"])->name('brand.delete');
});

Route::group(["prefix" => "frontend"], function () {

    Route::get("/home", [HomeController::class, "index"])->name('homepage');

    Route::get("/register", [AuthController::class, "viewRegisterForm"])->name('registerMember');
    Route::post("/register", [AuthController::class, "register"]);
    Route::get("/login", [AuthController::class, "viewLoginForm"])->name("loginMember");
    Route::post("/login", [AuthController::class, "login"]);
    Route::get("/logout", [AuthController::class, "logout"])->name("logoutMember");

    Route::get("/blog", [FrontendBlogController::class, "viewBlogList"])->name('blog');
    Route::get("/blog/{blogID}", [FrontendBlogController::class, "viewBlogDetails"])->name('blogDetails');

    Route::post("/rate", [RateController::class, "rate"])->name('rateBlog'); // using Ajax for rate
    Route::post("/comment", [CommentController::class, "comment"])->name('commentBlog'); // using Ajax for comment

    Route::get("/account/update", [FrontendUserController::class, "editAccount"])->name('account.edit');
    Route::post("/account/update", [FrontendUserController::class, "updateAccount"]);


    // My Product ProductController@index
    Route::get("/account/my-product", [ProductController::class, 'index'])->name("product.show_list");
    Route::get("/account/add-product", [ProductController::class, 'create'])->name("product.add");
    Route::post("/account/add-product", [ProductController::class, 'store']);
    Route::get("acount/edit-product/{id}", [ProductController::class, 'edit'])->name("product.edit");
    Route::post("acount/edit-product/{id}", [ProductController::class, 'update']);
});
