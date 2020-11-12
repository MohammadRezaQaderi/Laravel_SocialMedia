@extends('layouts.master')

@section('title')
    Login
@endsection

@section('content')
@include('includes.message-block')
        <div class="col-md-6">
            <h3>Sign In</h3>
            <form action="{{ route('signin') }}" method="post">
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">Enter Your Email</label>
                    <input class="form-control" type="text" name="email" id="email" value="{{Request::old('email')}}">
                </div>
                <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                    <label for="username">Enter Your UserName</label>
                    <input class="form-control" type="text" name="username" id="username" value="{{Request::old('username')}}">
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">Enter Your Password</label>
                    <input class="form-control" type="password" name="password" id="password" value="{{Request::old('password')}}">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <input type="hidden" name="_token" value="{{ Session::token()}}">
            </form>
        </div>
    </div> 

    <div class="as-signin-accountcreation" style="font-size: 17px;line-height: 1.47059;font-weight: 400;letter-spacing: -.022em;font-family: SF Pro Text,SF Pro Icons,AOS Icons,Helvetica Neue,Helvetica,Arial,sans-serif;margin-top: 7px;display: block;"><a href="{{route('sign-up')}}" class="as-buttonlink" target="_blank"><span aria-hidden="true">Don't have an 2r2r ID? Create one now.</span></a></div>
    
@endsection
