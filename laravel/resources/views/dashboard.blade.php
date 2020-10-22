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
            <article class="post">
                <p>Lorem ipsum dolor sit amet, at iriure docendi vel. Soleat persequeris ea quo. Populo placerat has te, vis ut iuvaret volumus volutpat, ius et aeterno partiendo. Viris periculis adolescens ei has, his in fastidii elaboraret. Lorem graece prompta id est, nisl graecis intellegebat ut his, in facer errem sea.
</p>
                <div class="info">
                </div>
                <div class="interaction">
                    <a href="">Like</a> |
                    <a href="">Dislike</a> |
                    <a href="">Edit</a> |
                    <a href="">Delete</a> |
                </div>
            </article>      
        </div>
    </section>
@endsection