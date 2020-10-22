<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function postSignUp(Request $request)
    {
        $this->validate($request , [
            'email' => 'required|email|unique:users',
            'first_name' => 'required|max:120',
            'password' => 'required|min:8'
        ]);
        
        $user = new User();
        $user->email =  request('email');
        $user->first_name = request('first_name');;
        $user->password = bcrypt( request('password'));;

        $user->save();
        Auth::login($user);
        
        return redirect()->route('dashboard');
    }

    public function postSignIn(Request $request){
        $this->validate($request , [
            'email' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt(['email'=>request('email'), 'password'=>request('password')])){
            return redirect()->route('dashboard');
        }
        return redirect()->back();
    }
}
