<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'transfer.create';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
        ]);

        
    }

    /**
     * The user has been registered.
     *
     * @param  Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        if ($user->role === 'Account') {
            Alert::success('تم انشاء المحاسب بنجاح');
        }
    }

    /**
     * Get the redirect path based on the user's role after registration.
     *
     * @return string
     */
    protected function redirectTo()
    {
        // Check the user's role and redirect accordingly
        if (Auth::user()->role === 'Client') {
            return '/my-transfers';
        } elseif (auth()->user()->role === 'Account') {
            Alert::success('تم انشاء المحاسب بنجاح');
            return '/admin';
            
        }elseif (auth()->user()->role === 'Admin') {
            return '/admin';
            
        }
        

        // Default redirection if the user's role is not specified
        return RouteServiceProvider::HOME;
    }
}
