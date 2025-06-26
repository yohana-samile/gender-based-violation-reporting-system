<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!Auth::check()) {
            return view('auth.login');
        }
        $user = user();
        $dashboardRoute = $user->is_reporter ? '/frontend/layouts/dashboard' : '/backend/layouts/dashboard';
        return redirect($dashboardRoute);
    }

    public function landing(){
        return view('index');
    }
}
