<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Servicies\CategorySevice;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function __construct(protected CategorySevice $services){}
    
    public function index()
    {
        $categories=$this->services->getCategories(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories=$this->services->getRootsCategory();
        return view('admin.categories.create',compact('parentCategories'));
    }

    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();

        $this->services->createCategory($validated);
        
        return redirect()
        ->route('admin.categories.index')
        ->with('success', 'Category created successfully');
    }


    public function edit(int $id)
    {
        $category=$this->services->getCategoryById($id);
        $parentCategories=$this->services->getRootsCategory();
        return view('admin.categories.edit', compact('category','parentCategories'));
    }

    public function update(CategoryRequest $request, int $id)
    {
        $validated = $request->validated();
        $category=$this->services->updateCategory($id,$validated);
 
        return redirect()
        ->route('admin.categories.index')
        ->with('success', 'Category Updated successfully');    }

    public function destroy(int $id)
    {
        $this->services->deleteCategory($id);

        return back()->with('success', 'Category deleted successfully');
    }
}