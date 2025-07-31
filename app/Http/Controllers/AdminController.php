<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.index', compact('user'));
    } //End Method

    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    } //End Method



    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => [
                'nullable',
                'regex:/^\+?[0-9]{10,15}$/',
                'max:20'
            ],
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,

            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB

            'old_password' => 'nullable|required_with:new_password,new_password_confirmation',
            'new_password' => 'nullable|required_with:old_password|confirmed|min:6',
        ], [
            'phone.regex' => 'The phone number must be between 10 to 15 digits and may start with a +.',
        ]);

        // Update user basic info
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // Handle password update if requested
        if ($request->filled('old_password') && $request->filled('new_password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'Old password does not match.'])->withInput();
            }
            $user->password = Hash::make($request->new_password);
        }

        // Handle image upload and store as BLOB
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageData = file_get_contents($request->file('image')->getRealPath());
            $user->image = $imageData;  // Assuming `image` column is BLOB type
        }

        try {
            $user->save();
        } catch (\Exception $e) {
            return back()->withErrors(['save_error' => $e->getMessage()])->withInput();
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
