@extends('layouts.master')

@section('content')
@include('includes.message-block')
    @if(Storage::disk('local')->has($user->first_name . '-' . $user->id . '.jpg'))
        <section class="row new-post">
            <div class="col-md-6 col-md-offset-3">
                <img src="{{ route('account.image' , ['filename'=> $user->first_name . '-' . $user->id . '.jpg']) }}"  alt="" class="img-responsive">
            </div>
        </section>
    @endif
    <section class="row new-post">
        <div class="col-md-6 col-md-offset-3">
            <header><h3>What do You have To say?</h3></header>
            <form action="{{route('post.create')}}" method="post">
                <div class="form-group">
                    <textarea class="form-control" name="body" id="new-post"  rows="7" placeholder="Your Post"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Create Post</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>
    </section>
    <section class="new posts">
        <div class="col-md-6 col-md-offset-3">
            <header><h3>What Other People Say...</h3></header>
            @foreach($posts as $post)
            <article class="post" data-postid="{{ $post->id }}">
                <p>{{$post->body}}</p>
                <div class="info">
                    Posted By {{$post->user->first_name}} on {{$post->updated_at}}
                </div>
                <div class="interaction">
                    <a href="">Like</a> |
                    <a href="">Dislike</a> 
                    @if(Auth::user() == $post->user)
                    |
                    <a href="" class="edit">Edit</a> |
                    <a href="{{route('post.delete' , ['post_id'=>$post->id])}}">Delete</a> 
                    @endif
                </div>
            </article>
            @endforeach
        </div>
    </section>
<div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Post </h4>
      </div>
      <div class="modal-body">
            <form >
                <div class="form-group">
                    <label for="post-body">Edit The Post</label>
                    <textarea class="form-control" name="post-body" id="post-body" rows="5"></textarea>
                </div>
            </form>
      </div>
      <div cla  ss="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save-modal">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    var token = '{{Session::token()}}';
    var url = '{{route('edit')}}' ;  
</script>
@endsection