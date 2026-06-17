<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Servicies\BrandService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    protected $services;

    public function __construct(BrandService $services)
    {
        $this->services=$services;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands=$this->services->getBrands();
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

        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        $validated=$request->validated();
        $this->services->createBrand($validated);
        return redirect()->route('admin.brands.index')->with(
            'success',
            'Brand created successfully'
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand=$this->services->getBrandById($id);
        return view('admin.brands.edit',compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, int $id)
    {
        $validated=$request->validated();
        $brand=$this->services->updateBrand($id,$validated);

        return redirect()->route('admin.brands.index')->with(
            'success',
            'Brand updated successfully'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->services->deleteBrand($id);
        return redirect()->back()->with(
            'success',
            'Brand deleted successfully'
        );
    }
}
