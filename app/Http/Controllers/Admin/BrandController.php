<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::latest()->paginate(10);

        return view(
            'admin.brands.index',
            compact('brands')
        );
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
    public function store(BrandRequest $request)
    {
        Brand::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name['en']),
        ]);
    
        return back()->with(
            'success',
            'Brand created successfully'
        );
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
    public function update(BrandRequest $request, Brand $brand)
    {
        $brand->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name['en']),
        ]);
    
        return back()->with(
            'success',
            'Brand updated successfully'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return back()->with(
            'success',
            'Brand deleted successfully'
        );
    }
}
