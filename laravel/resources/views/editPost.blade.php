@extends('layouts.master')

@section('content')

<!-- this is for edit -->
<section class="row new-post">
        <div class="col-md-6 col-md-offset-3">
            <header><h3>Edit Your Post</h3></header>
            @if($post->id != null)
            <form action="{{route('edit-post' , ['post_id'=>$post->id])}}" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <textarea class="form-control" name="post-body" id="new-post"  rows="7" placeholder="{{$post->body}}">{{$post->body}}</textarea>
                </div>  
                <div class="form-group">
                    <label for="image">Image Only .Jpg</label>
                    <input type="file" name="image" class="form-control" id="image">
                </div>
                <button type="submit" class="btn btn-primary">Edit Post</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
            @endif
        </div>
    </section>

@endsection

