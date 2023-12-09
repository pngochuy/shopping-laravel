<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\LoginMemberRequest;
use App\Http\Requests\Frontend\RegisterRequest;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function viewRegisterForm()
    {
        $countryList = Country::all();
        return view('frontend.auth.register', compact('countryList'));
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->all();
        $file = $request->avatar;
        // dd: chuyên dùng debug, hiển thị dưới dạng mảng
        // dd($request);
        // ĐÃ CHECK DUPLICATE CHO "name" VÀ "email" BÊN RegisterRequest

        $newUser = new User();
        $newUser->name = $data['name'];
        $newUser->email = $data['email'];
        $newUser->password = bcrypt($data['password']);

        if (!empty($file)) {
            $data['avatar'] = $file->getClientOriginalName();
            $newUser->avatar = $data['avatar'];
        }


        if (!empty($data['phone'])) {
            $newUser->phone = $data['phone'];
        }
        if (!empty($data['message'])) {
            $newUser->message = $data['message'];
        }
        if (!empty($data['id_country'])) {
            $newUser->id_country = $data['id_country'];
        }

        $newUser->level = 0; // for only member registered!
        $success = $newUser->save();

        if ($success) {
            $directory = "upload/user/avatar";

            if (!empty($file)) {
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }

                $file->move($directory, $file->getClientOriginalName());
            }

            return redirect()->back()->with("success", __("Register successfully!"));
        } else {
            return redirect()->back()->with("failed", __("Register failed!"));
        }
    }


    public function viewLoginForm()
    {
        return view('frontend.auth.login');
    }

    public function login(LoginMemberRequest $request)
    {
        // dd($request->all());
        // login dành cho MEMBER
        // Bạn không nên động password của request đến vì Laravel sẽ tự động xử lý phần đó trước khi so sánh nó với password đã qua xử lý trong cơ sở dữ liệu.
        // https://hoclaravel.vn/chi-tiet/authentication-trong-laravel-la-gi-hoat-dong-cua-no-nhu-the-nao
        $credentials = [
            'email' => $request->emailLogin,
            'password' => $request->passwordLogin, // passwordLogin ko cần mã hóa khi so sánh trong database
            'level' => 0
        ];

        // do model User có extends Authenticatable!!!
        $remember = false;

        if ($request->remember_me) {
            $remember = true;
        }
        // dd($credentials);

        // $credentials = [], $remember = boolean
        // chỉ dành cho LOGIN trong laravel
        if (Auth::attempt($credentials, $remember)) {
            return redirect("/frontend/home");
        } else {
            return redirect()->back()->with("failed", __("Email or password is incorrect!"));
        }
    }

    /**

     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect("/frontend/login");
    }
}
