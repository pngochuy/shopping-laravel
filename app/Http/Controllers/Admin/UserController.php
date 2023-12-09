<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
        //
        return view("admin.user.profile");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        // Lưu ý: ko còn dùng 'string $id' làm tham số đầu vào nữa
        // Mặc dù đã dùng hàm '__construct' để check user login không tồn tại rồi nhưng vẫn phải check tiếp
        // Có thể check trực tiếp trên file blade.php (vd: header.blade.php)
        // Có thể check trực tiếp trên route bằng hàm middleware authentication. (vd: Route::get(...)->middleware('auth');)

        if (Auth::check()) {
            $userId = Auth::id();
            $currentUser = User::findorFail($userId);

            $passwordFormat = "";
            for ($i = 1; $i <= strlen($currentUser->password); $i++) {
                # code...
                $passwordFormat .= '*';
            }
            // echo $passwordFormat;


            // lấy data từ table 'country'
            $countryList = DB::table('country')->get();

            if (!$currentUser) {
                // return redirect()->back()->with("error", "User not found");
                echo "User not found";
                return; // ko chạy view dưới
            }

            return view("admin.user.profile", compact('currentUser', 'countryList', 'passwordFormat'));
        } else {
            $this->middleware('auth');

            // echo "You not logged in!!";
            // return;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request)
    {
        // Lưu ý: ko còn dùng 'string $id' làm tham số đầu vào nữa

        $userId = Auth::id();
        $currentUser = User::findorFail($userId); // check if user found by primary key 'userId'

        $data = $request->all();
        $file = $request->avatar; // img_file.png, ...

        if ($data["password"]) {
            $data["password"] = bcrypt($data["password"]);
        } else {
            $data["password"] = $currentUser->password;
        }

        if (!empty($file)) {
            $data['avatar'] = $file->getClientOriginalName(); //  lưu tên tệp ảnh của file Object
        }

        if ($currentUser->update($data)) {

            // Note: In Laravel $path start from public folder, so if you want to check 'public/assets' folder the $path = 'assets'

            $directory = "upload/user/avatar";

            if (!empty($file)) {
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }

                $file->move("upload/user/avatar", $file->getClientOriginalName());
            }
            return redirect()->back()->with("success", __("Upload profile successfully"));
        } else {
            return redirect()->back()->with("Update profile failed");
        }

        // return $this->index();   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
