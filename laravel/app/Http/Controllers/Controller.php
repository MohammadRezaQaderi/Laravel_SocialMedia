<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Pusher\Pusher;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){
      
        
        return view('welcome' , ['users' => $users]);
    }

    public function getMessage($user_id){
        $my_id = Auth::id();
        Message::where(['from'=> $user_id , 'to'=>$my_id])->update(['is_read' =>1]);
        $messages = Message::where(function ($query) use($user_id , $my_id){
            $query->where('from', $my_id)->where('to' ,$user_id);
        })->orWhere(function ($query) use($user_id , $my_id){
            $query->where('from', $user_id)->where('to' ,$my_id);
        })->get();

        return view('messages.index' , ['messages'=>$messages]);
    }

    public function postSendMessage(Request $requset){
        $from = Auth::id();
        $to = $requset->receiver_id;
        $message = $requset->message;

        $data = new Message();
        $data->from =$from;
        $data->to = $to;
        $data->message = $message;
        $data->is_read = 0;
        $data->save();

        $options = array(
            'cluster' => 'ap2',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
        $data = ['from'=> $from ,'to'=> $to];
        $pusher->trigger('my_channel' , 'my_event' , $data);
    }
}
