<?php
// app/Http/Controllers/Mobile/ProfileController.php
namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('mobile.user.profile');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            // Generate a unique, safe filename
            $fileName = time() . '_' . uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
            
            // Store the file directly to public disk
            $path = $request->file('photo')->storeAs(
                'profile-photos',  // without 'public/' prefix
                $fileName,
                'public'          // specify the public disk
            );

            // Delete old profile image if exists
            if (auth()->user()->profile_image) {
                Storage::disk('public')->delete(auth()->user()->profile_image);
            }
            
            // Update user profile
            $user = auth()->user();
            $user->profile_image = $path; // Store the path without 'public/' prefix
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Photo updated successfully',
                'path' => Storage::disk('public')->url($path)
            ]);
        } catch (\Exception $e) {
            \Log::error('Profile photo update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating photo: ' . $e->getMessage()
            ], 500);
        }
    }
}
