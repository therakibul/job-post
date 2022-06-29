<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //Show registration form

     public function create(){
        return view('user.register');
    }

    // Add new user
    public function store(Request $request){
        $formFields = $request->validate([
           'name' => ['required', 'min:3'],
           'email' => ['required', 'email', Rule::unique('users', 'email')],
           'password' => 'required|confirmed|min:6'
        ]);
        $formFields['password'] = bcrypt($formFields['password']);
        // Create user
        $user = User::create($formFields);
        // Login
        auth()->login($user);

        return redirect('/')->with('message', 'User created and logged in.');

    }


    // Logout user

    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('message', 'You have been logged out!');
    }

    // Uer login form

    public function login(){
        return view('user.login');
    }


    // User login

    public function authenticate(Request $request){
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);
        if(auth()->attempt($formFields)){
            $request->session()->regenerate();
            return redirect('/')->with('message', 'You are logged in.');
        }
        return back()->withErrors(['email' => 'Invalid Credential'])->onlyInput('email');
    }

}