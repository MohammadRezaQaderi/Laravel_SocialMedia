@extends('layouts.master')

@section('content')
@include('includes.message-block')
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
            <article class="post">
                <p>{{$post->body}}</p>
                <div class="info">
                    Posted By {{$post->user->first_name}} on {{$post->updated_at}}
                </div>
                <div class="interaction">
                    <a href="">Like</a> |
                    <a href="">Dislike</a> |
                    <a href="">Edit</a> |
                    <a href="{{route('post.delete' , ['post_id'=>$post->id])}}">Delete</a> 
                </div>
            </article>
            @endforeach
        </div>
    </section>
@endsection