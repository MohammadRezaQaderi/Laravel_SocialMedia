<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
class UserController extends Controller
{

    public function postSignUp(Request $request)
    {
        $this->validate($request , [
            'email' => 'required|email|unique:users',
            'id' => 'required|unique:users',
            'first_name' => 'required|max:120',
            'first_name' => 'required|max:120',
            'age' => 'required',
            'password' => 'required|min:8'
        ]);
        
        $user = new User();
        $user->email =  request('email');
        $user->id = request('id');
        $user->first_name = request('first_name');
        $user->last_name = request('last_name');
        $user->age = request('age');
        $user->password = bcrypt( request('password'));

        $user->save();
        Auth::login($user);
        
        return redirect()->route('dashboard');
    }

    public function postSignIn(Request $request){
        $this->validate($request , [
            'email' => 'required',
            'id' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt(['email'=>request('email') , 'id' => request('id'), 'password'=>request('password')])){
            return redirect()->route('dashboard');
        }
        return redirect()->back();
    }

    public function getLogout(){
        Auth::logout();
        return redirect()->route('home');
    }

    public function getAccount()
    {
        return view('account' , ['user' => Auth::user()]);
    }

    public function postSaveAccount(Request $request)
    {
        $this->validate($request , [
            'first_name' => 'required|max:120',
            'first_name' => 'required|max:120',
            'age' => 'required'
        ]);
        $user = Auth::user();
        $user->first_name = $request['first_name'];
        $user->update();
        $file = $request->file('image');
        $filename = $request['first_name'] . '-' . $user->id . '.jpg';
        
        if($file){
            Storage::disk('local')->put($filename , File::get($file));
        }
        return redirect()->route('account');
    }

    public function getUserImage($filename)
    {
        $file = Storage::disk('local')->get($filename);
        return new Response($file , 200);
    }
}
