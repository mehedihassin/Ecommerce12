<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view('admin.category.index', compact('categories'));
    } //end method

    public function create()
    {
        return view('admin.category.create');
    } //end method

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageData = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid() && $file->getSize() <= 2 * 1024 * 1024) {
                $imageData = file_get_contents($file);
            }
        }

        Category::create([
            'name'  => $request->name,
            'slug'  => Str::slug($request->slug),
            'image' => $imageData,
        ]);

        return redirect()->back()->with('success', 'Category created successfully!');
    } //End of store method

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    } //end method

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->slug);

        if ($request->hasFile('image')) {
            $category->image = file_get_contents($request->file('image'));
        }

        $category->save();

        return redirect()->route('admin.category.index')->with('success', 'Category updated successfully!');
    } //end method

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully!');
    } //end method
}
