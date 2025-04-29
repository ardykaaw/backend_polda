<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        return response()->json([
            'user' => $user,
            'message' => 'Welcome to Admin Dashboard'
        ]);
    }
}