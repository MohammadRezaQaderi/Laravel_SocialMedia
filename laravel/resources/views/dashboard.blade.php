@extends('layouts.master')

@section('content')
@include('includes.message-block')
<head>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
    <!-- The Create Post Section -->
    <section class="row new-post">
        <div class="col-md-6 col-md-offset-3">
            <header><h3>What do You have To say?</h3></header>
            <form action="{{route('post.create')}}" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <textarea class="form-control" name="body" id="new-post"  rows="7" placeholder="Your Post"></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Image Only .Jpg</label>
                    <input type="file" name="image" class="form-control" id="image">
                </div>
                <button type="submit" class="btn btn-primary">Create Post</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>
    </section>
    <!-- The Other Post Show -->
    <section class="new posts">
        <div class="col-md-6 col-md-offset-3">
            <header><h3>What Other People Say...</h3></header>
            @foreach($posts as $post)
                <article class="post" data-postid="{{ $post->id }}">
                @if(Storage::disk('public')->has($post->user->first_name.'_' . 'Post' . '-' . $post->id . '.jpg'))
					<img href="{{route('post.view' , ['post_id' => $post->id ] )}}" src="{{ route('post.image' , ['filename'=> $post->user->first_name.'_' . 'Post'. '-' . $post->id . '.jpg']) }}"  alt="" class="gallery-image">
                @endif
                    <p>{{$post->body}}</p>
                    <div class="info">
                        Posted By {{$post->user->username}} on {{$post->updated_at}}
                    </div>
                    <div class="interaction">
                        <a href="" class="like">{{Auth::user()->likes()->where('post_id' ,$post->id)->first() ? Auth::user()->likes()->where('post_id' ,$post->id)->first()->like == 1 ? 'You Like This Post' : 'Like' : 'Like'}}</a> |
                        <a href="" class="like">{{Auth::user()->likes()->where('post_id' ,$post->id)->first() ? Auth::user()->likes()->where('post_id' ,$post->id)->first()->like == 0 ? 'You Don\'t Like This Post' : 'DisLike' : 'DisLike'}}</a> 
                        |
                        <a href="" class="comment"><i class="material-icons">comment</i></a>
                        @if(Auth::user() == $post->user)
                        |
                            <a href="{{route('editPosts' , ['post_id'=>$post->id])}}" class="edit-post"><i class="material-icons">edit</i></a> |
                            <a href="{{route('post.delete' , ['post_id'=>$post->id])}}"><i class="material-icons">delete</i></a>
                        @endif
                        <br>
                        @foreach($comments->take(2) as $comment)
                            @if($comment->post_id == $post->id)
                                {{ $comment->comment}} <span style="color:#A0A0A0"> {{$comment->user_id}}</span><br>
                            @endif
                        @endforeach
                    </div>
                </article>
            @endforeach
            </div>
        </section>


<!-- This Is For Comment Box-->
<div class="modal fade" tabindex="-1" role="dialog" id="comment-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Comment Post </h4>
      </div>
      <div class="modal-body">
            <form action="{{route('comment')}}" method="post" enctype="multipart/form-data" >
                <div class="form-group">
                    <label for="comment-body">Comment For Post</label>
                    <textarea class="form-control" name="comment-body" id="comment-body" rows="5"></textarea>
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save-modal-Comment">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    var token = '{{Session::token()}}';
    var urlLike = '{{route('like')}}' ;
    var urlComment = '{{route('comment')}}';
</script>
@endsection