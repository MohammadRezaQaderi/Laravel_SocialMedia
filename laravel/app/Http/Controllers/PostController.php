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

        $message = 'There is an Error';

        if($request->user()->posts()->save($post)){
            $message = 'Post Create Successfully';
        }

        return redirect()->route('dashboard')->with(['message'=>$message]);
    }    

    public function getDeletePost($post_id){
        $post = Post::where('id' , $post_id)->first();
        $post->delete();
        return redirect()->route('dashboard')->with(['message' => 'Post Delete Successfuly!']);
    }
}
