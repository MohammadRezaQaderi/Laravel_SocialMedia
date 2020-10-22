<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;


class PostController extends Controller
{

    public function getDashboard(){
        $posts = Post::all();
        return view('dashboard' , ['posts'=>$posts]);
    }

    public function postCreatePost(Request $request)
    {
        //Validation
        $this->validate($request , [
            'body' => 'required|max:1000'
        ]);
        $post = new Post();
        $post->body = $request['body'];

        $massage = 'There is an Error';

        if($request->user()->posts()->save($post)){
            $massage = 'Post Create Successfully';
        }

        return redirect()->route('dashboard')->with(['massage'=>$massage]);
    }    
}
