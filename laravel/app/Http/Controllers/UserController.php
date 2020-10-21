<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    
    public function getDashboard(){
        return view('dashboard');
    }

    public function postSignUp()
    {
        $email = request('email');
        $first_name = request('first_name');
        $password =bcrypt( request('password'));
        error_log(request('email'));
        error_log(request('first_name'));
        error_log(request('password'));
        $user = new User();
        $user->email = $email;
        $user->first_name = $first_name;
        $user->password = $password;

        $user->save();
        Auth::login($user);
        
        return redirect()->route('dashboard');
    }

    public function postSignIn(){

        if(Auth::attempt(['email'=>request('email'), 'password'=>request('password')])){
            return redirect()->route('dashboard');
        }
        return redirect()->back();
    }
}
