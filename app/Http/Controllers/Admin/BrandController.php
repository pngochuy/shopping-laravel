<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();

        return view('admin.brand.brand-list', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.add-brand');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddBrandRequest $request)
    {
        $data = $request->all();

        // Kiểm tra xem brand đã tồn tại hay chưa
        $existingBrand = Brand::where('name', $data['name'])->first();

        if ($existingBrand) {
            return redirect()->back()->with('error', __("Brand: " . $existingBrand->name . " already exists"));
        }

        if (Brand::create($data)) {

            return redirect()->back()->with('success', __("Brand added successfully"));
        } else {
            return redirect()->back()->with('error', __("Brand added failed"));
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
        $success = Brand::where("id", $id)->delete();

        if ($success) {
            return redirect()->route('brand.show_list');
        } else {
            return back()->with("error", "Delete brand failed!");
        }
    }
}
