<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo()
    {
        // Check the user's role and redirect accordingly
        $user = Auth::user();
        if ($user->role == "Client") {
            return '/my-transfers';
        } elseif ($user->role == "Admin") {
            return '/admin';
        }

        // Default redirection if the user's role is not specified
        return RouteServiceProvider::HOME;
    }

    /**
     * Get the post logout redirect path.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    protected function loggedOut(Request $request)
    {
        // Redirect to /login after logout
        return view('auth.login');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
