<?php
// app/Http/Controllers/Mobile/AuthController.php
namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('mobile.dashboard');
        }
        return view('mobile.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nrp' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('mobile.dashboard')
                ]);
            }

            return redirect()->intended(route('mobile.dashboard'));
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'NRP atau password salah'
            ], 422);
        }

        return back()->withErrors([
            'nrp' => 'NRP atau password salah',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('mobile.login');
    }
}
