<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        return response()->json([
            'user' => $user,
            'message' => 'Welcome to User Dashboard'
        ]);
    }

    public function updateProfileImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = User::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            
            // Simpan gambar di storage/app/public/profiles
            $path = $image->storeAs('public/profiles', $filename);
            
            // Update path gambar di database
            $user->profile_image = 'profiles/' . $filename;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile image updated successfully',
                'image_url' => asset('storage/' . $user->profile_image)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No image file uploaded'
        ], 400);
    }
}