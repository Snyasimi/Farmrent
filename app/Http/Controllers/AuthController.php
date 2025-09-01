<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\{AuthService};
class AuthController extends Controller
{
    //
    protected $authservice;


    public function __construct(AuthService $authservice)
    {

        $this->authservice = $authservice;
    }



    public function authenticate(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);

        $user = $this->authservice->authenticate($validated);

        if($user)
        {
            return to_route('homepage');
        }

        return redirect()->back()->withErrors($validated)->withInput();

    }


    public function login()
    {
        return view('auth.login');

    }

    public function register()
    {
        return view('auth.signUp');
    }

    public function signup(Request $request)
    {
        //validation
        $validated = $request->validate([
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'phone' => ['required'],
            'role' => ['required'] 
        ]);

       
        $user = $this->authservice->add_user($validated);
       
        if($user)
        {
            Auth::login($user);

            return to_route('homepage');
        }

        return redirect()->back()->withErrors($validator)->withInput();

    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');

    }
}
