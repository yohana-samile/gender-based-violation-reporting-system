<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!Auth::check()) {
            return view('auth.login');
        }
        $user = user();
        $dashboardRoute = $user->is_super_admin ? '/backend/layouts/dashboard' : '/frontend/layouts/dashboard';
        return redirect($dashboardRoute);
    }

    public function landing(){
        return view('index');
    }
}
