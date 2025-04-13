<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomLoginController extends Controller
{

    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role_as == '1') {
                return redirect()->route('dashboard'); // Admin dashboard
            } else {
                return redirect()->route('dashboard.guest'); // Non-admin dashboard
            }
        }
        return view('auth.login');
    }
}
