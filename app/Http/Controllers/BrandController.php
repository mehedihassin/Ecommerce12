<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\BrandImage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::with('images')->paginate(10);
        return view('admin.brand.index', compact('brands'));
    } //End of index method

    public function create()
    {
        return view('admin.brand.create');
    } //End of create method

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:brands,slug',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate each image
        ]);

        // Create the brand first
        $brand = Brand::create([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
        ]);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->getSize() > 2 * 1024 * 1024) {
                    continue;
                }

                $imageData = file_get_contents($image);

                BrandImage::create([
                    'brand_id' => $brand->id,
                    'image' => $imageData,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Brand and images created successfully!');
    } //End of store method


    public function edit($id)
    {
        $brands = Brand::with('images')->findOrFail($id);
        return view('admin.brand.edit', compact('brands'));
    } //End of edit method


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:brands,slug,' . $id,
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // each image
        ]);

        $brand = Brand::findOrFail($id);
        $brand->update([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
        ]);

        $brand->images()->delete();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid() && $image->getSize() <= 2 * 1024 * 1024) {
                    $imageData = file_get_contents($image);

                    BrandImage::create([
                        'brand_id' => $brand->id,
                        'image' => $imageData,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Brand updated successfully!');
    }


    public function delete($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->images()->delete();
        $brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully!');
    } //End of delete method


 
}
