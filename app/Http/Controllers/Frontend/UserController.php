<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\updateProfileRequest;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function editAccount()
    {
        if (Auth::check()) {
            $currentUser = Auth::user(); // or Auth::getUser()
            $countryList = Country::all();

            $passwordFormat = "";
            for ($i = 1; $i <= strlen($currentUser->password); $i++) {
                # code...
                $passwordFormat .= '*';
            }
            // dd($currentUser);

            return view("frontend.account.account", compact("currentUser", "countryList", "passwordFormat"));
        } else {
            return redirect("/frontend/login");
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function updateAccount(updateProfileRequest $request)
    {
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
    }
}
