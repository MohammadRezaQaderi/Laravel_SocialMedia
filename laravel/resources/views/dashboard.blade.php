@extends('layouts.master')

@section('content')
@include('includes.message-block')
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
                    <section class="row new-post">
                        <div class="col-md-6 col-md-offset-3">
                            <img src="{{ route('post.image' , ['filename'=> $post->user->first_name.'_' . 'Post'. '-' . $post->id . '.jpg']) }}"  alt="" class="img-responsive">
                        </div>
                    </section>
                @endif
                    <p>{{$post->body}}</p>
                    <div class="info">
                        Posted By {{$post->user->first_name}} on {{$post->updated_at}}
                    </div>
                    <div class="interaction">
                        <a href="" class="like">{{Auth::user()->likes()->where('post_id' ,$post->id)->first() ? Auth::user()->likes()->where('post_id' ,$post->id)->first()->like == 1 ? 'You Like This Post' : 'Like' : 'Like'}}</a> |
                        <a href="" class="like">{{Auth::user()->likes()->where('post_id' ,$post->id)->first() ? Auth::user()->likes()->where('post_id' ,$post->id)->first()->like == 0 ? 'You Don\'t Like This Post' : 'DisLike' : 'DisLike'}}</a> 
                        @if(Auth::user() == $post->user)
                        |
                        <a href="" class="edit">Edit</a> |
                        <a href="{{route('post.delete' , ['post_id'=>$post->id])}}">Delete</a>  |
                        <a href="" class="comment">Comment</a>
                        @endif
                        <br>
                        @foreach($comments->take(2) as $comment)
                            @if($comment->post_id == $post->id)
                                {{ $comment->comment}}{{ $post->user->id}}<br>
                            @endif
                        @endforeach
                    </div>
                </article>
            @endforeach
            </div>
        </section>
<!-- This Is For Edit Box-->
<div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Post </h4>
      </div>
      <div class="modal-body">
            <form  action="{{route('edit')}}" method="post" enctype="multipart/form-data" >
                <div class="form-group">
                    <label for="post-body">Edit The Post</label>
                    <textarea class="form-control" name="post-body" id="post-body" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Image Only .Jpg</label>
                    <input type="file" name="image" class="form-control" id="image">
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save-modal">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- This Is For Comment Box-->
<div class="modal fade" tabindex="-1" role="dialog" id="comment-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Comment Post </h4>
      </div>
      <div class="modal-body">
            <form  action="{{route('comment')}}" method="post" enctype="multipart/form-data" >
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
    var urlEdit = '{{route('edit')}}' ;
    var urlLike = '{{route('like')}}' ;
    var urlComment = '{{route('comment')}}';
</script>
@endsection