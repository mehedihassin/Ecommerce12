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
        return view('admin.brand.index');
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
                    continue; // Skip images larger than 2MB
                }

                $imageData = file_get_contents($image);

                BrandImage::create([
                    'brand_id' => $brand->id,
                    'image' => $imageData, // Store as BLOB
                ]);
            }
        }

        return redirect()->back()->with('success', 'Brand and images created successfully!');
    }//End of store method
}
