@extends('layouts.master')

@section('content')
    <div class="card" style="width: 18rem;">
        <img src="{{ route('post.image' , ['filename'=> $post->user->first_name.'_' . 'Post'. '-' . $post->id . '.jpg']) }}"  alt="" class="img-responsive">
    <div class="card-body">
        <p class="card-text">{{$post->body}}</p>
    </div>
    </div>
@endsection