<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
        } elseif ($user->role == "Admin"||$user->role == "Account") {
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
    public function logout(Request $request)
    {
        Auth::logout();

        // Default redirect route after logout
        return redirect('/login');
    }
}
