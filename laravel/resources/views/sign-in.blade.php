@extends('layouts.master')

@section('title')
    Login
@endsection

@section('content')
@include('includes.message-block')
        <div class="col-md-6">
            <h3>Sign In</h3>
            <form action="{{ route('signin') }}" method="post">
                <div class="form-group ">
                    <label for="emailoruserName">Enter Your Email or UserName</label>
                    <input class="form-control" type="text" name="emailoruserName" id="emailoruserName">
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

    <div style="font-size: 17px;line-height: 1.47059;font-weight: 400;letter-spacing: -.022em;font-family: SF Pro Text,SF Pro Icons,AOS Icons,Helvetica Neue,Helvetica,Arial,sans-serif;margin-top: 7px;margin-left:108px;display: block;"><a href="{{route('sign-up')}}" >Don't have an 2r2r ID? Create one now.</a></div>
    
@endsection
