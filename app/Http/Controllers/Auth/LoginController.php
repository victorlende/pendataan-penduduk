<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectTo()
    {
        if (auth()->user()->role == 'masyarakat') {
            if (auth()->user()->status == 'pending') {
                return route('verification.notice');
            }
            return route('surat.my');
        }
        return route('dashboard');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        if ($user->role == 'admin') {
            auth()->logout();
            return redirect()->route('login')->withErrors(['email' => 'Halaman ini khusus untuk login Warga. Admin silakan ke halaman login admin.']);
        }
    }
}
