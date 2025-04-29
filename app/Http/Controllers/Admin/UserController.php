<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nrp' => 'required|unique:users,nrp',
            'nama' => 'required',
            'password' => 'required|min:6',
            'pangkat' => 'required',
            'divisi' => 'required',
            'role' => 'required|in:admin,user',
        ]);

        try {
            User::create([
                'nrp' => $request->nrp,
                'nama' => $request->nama,
                'password' => Hash::make($request->password),
                'pangkat' => $request->pangkat,
                'divisi' => $request->divisi,
                'role' => $request->role,
                'status' => true,
                'profile_image' => null,
                'office_latitude' => null,
                'office_longitude' => null,
                'office_radius' => 100 // default value
            ]);

            return redirect()
                ->route('admin.users')
                ->with('success', 'Pengguna berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nrp' => 'required|unique:users,nrp,' . $user->id,
            'nama' => 'required',
            'password' => 'nullable|confirmed|min:6',
            'pangkat' => 'required',
            'divisi' => 'required',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users')
            ->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus user'
            ], 500);
        }
    }

    public function index()
    {
        // Ambil semua user termasuk admin
        $users = User::all();
        
        // Untuk debugging
        // dd($users->toArray());
        
        return view('admin.users.index', compact('users'));
    }

    public function updatePhoto(Request $request)
    {
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            
            // Simpan ke folder profile_images
            $path = $photo->storeAs('public/profile_images', $filename);
            
            // Update user
            $user = auth()->user();
            $user->profile_image = $filename;
            $user->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil diperbarui',
                'path' => asset('storage/profile_images/' . $filename)
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Tidak ada file yang diunggah'
        ]);
    }
}
