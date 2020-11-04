<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;




class PostController extends Controller
{

    public function getDashboard(){
        $posts = Post::orderBy('updated_at' , 'desc')->get();
        $comments = Comment::orderBy('updated_at' , 'desc')->get();
        return view('dashboard' , ['posts'=>$posts , 'comments'=>$comments]);
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
        $user = Auth::user();
        
        if($request->user()->posts()->save($post)){
            $message = 'Post Create Successfully';
        }

        $file = $request->file('image');
        $filename = $user->first_name .'_'. 'Post' . '-' . $post->id . '.jpg';
        
        if($file){
            Storage::disk('public')->put($filename , File::get($file));
        }
        $request->user()->posts()->save($post);
        
        return redirect()->route('dashboard')->with(['message'=>$message]);
    }    

    public function getDeletePost($post_id){
        $post = Post::where('id' , $post_id)->first();
        if(Auth::user() != $post->user){
            return redirect()->back();
        }
        $post->delete();
        $comments = Comment::All();
        foreach($comments as $comment){
            if($comment->post_id == $post_id){
                $comment->delete();
            }
        }
        $likes = Like::All();
        foreach($likes as $like){
            if($like->post_id == $post_id){
                $like->delete();
            }
        }
        return redirect()->route('dashboard')->with(['message' => 'Post Delete Successfuly!']);
    }

    public function postEditPost(Request $request){
        $this->validate($request , [
            'body' => 'required'
        ]);

        $post = Post::find($request['postId']);
        if(Auth::user() != $post->user){
            return redirect()->back();
        }
        $post->body = $request['body'];
        $user = Auth::user();
        $file = $request->file('image');
        $filename = $user->first_name .'_'. 'Post' . '-' . $post->id . '.jpg';
        
        if($file){
            Storage::disk('public')->put($filename , File::get($file));
        }
        $post->update();
        return response()->json(['new_body' => $post->body] , 200);
    }

    public function postLikePost(Request $request)
    {
        $post_id = $request['postId'];
        $is_like = $request['isLike'] === 'true';
        $update  = false;
        $post = Post::find($post_id);
        if(!$post){
            return null;
        }
        $user = Auth::user();
        $like = $user->likes()->where('post_id' , $post_id)->first();
        if($like){
            $already_like = $like->like;
            $update = true;
            if($already_like == $is_like){
                $like->delete();
                return null;
            }
        }else{
                $like = new Like();
            }
            $like->like = $is_like;
            $like->user_id = $user->id;
            $like->post_id = $post->id;
            
            if($update){
                $like->update();
            }else{
                $like->save();
            }
            return null;
    }

    public function postCommentPost(Request $request)
    {
        $this->validate($request , [
            'comment_body' => 'required|max:1000'
        ]);
        $comment = new Comment();
        $comment->post_id = $request['postId'];
        $comment->comment = $request['comment_body'];
        $user = Auth::user();
        $comment->user_id = $user->id;
        $comment->save();
        return null;
    }

    public function getPostImage($filename)
    {
        $file = Storage::disk('public')->get($filename);
        return new Response($file , 200);
    }
}
