<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
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
            'username' => 'required|unique:users',
            'first_name' => 'required|max:120',
            'last_name' => 'required|max:120',
            'age' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'discription' => 'required',
            'password' => 'required|min:8'
        ]);
        
        $user = new User();
        $user->email =  request('email');
        $user->username = request('username');
        $user->first_name = request('first_name');
        $user->last_name = request('last_name');
        $user->age = request('age');
        $user->gender = request('gender');
        $user->phone = request('phone');
        $user->discription = request('discription');
        $user->password = bcrypt( request('password'));

        $user->save();
        Auth::login($user);
        
        return redirect()->route('dashboard');
    }

    public function postSignIn(Request $request){
        $this->validate($request , [
            'email' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt(['email'=>request('email') , 'username' => request('username'), 'password'=>request('password')])){
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
            'last_name' => 'required|max:120',
            'age' => 'required',
            'phone' => 'required',
            'discription' => 'required|max:120'
        ]);
        $user = Auth::user();
        $user->first_name = request('first_name');
        $user->last_name = request('last_name');
        $user->age = request('age');
        $user->phone = request('phone');
        $user->discription = request('discription');
        $user->update();
        $file = $request->file('image');
        $filename = $request['first_name'] . '-' . $user->username . '.jpg';
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

    public function getUserProfile()
    {
        $user = Auth::user();
        $posts = Post::orderBy('updated_at' , 'desc')->get();
        $likes = Like::orderBy('updated_at' , 'desc')->get();
        $comments = Comment::orderBy('updated_at' , 'desc')->get();
        return view('Profile' , ['user'=> $user, 'likes'=>$likes , 'posts'=>$posts , 'comments'=>$comments]);    }
}
