<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AddCountryRequest;
use App\Models\Country;

class CountryController extends Controller
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
        $countryList = Country::all();
        return view('admin.country.country-list', compact('countryList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.country.add-country');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddCountryRequest $request)
    {
        $data = $request->all();

        $country = new Country();
        $country->country = $data["countryName"];
        $success = $country->save();

        if ($success) {
            // return redirect()->route('addCountry');
            return redirect()->route('countryList');
        } else {
            return back()->with('error', 'Error adding country!!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $success = Country::where("id", $id)->delete();

        if ($success) {
            return redirect()->route('countryList');
        } else {
            return back()->with("error", "Delete country failed!");
        }
    }
}
