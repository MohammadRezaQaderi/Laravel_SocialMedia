@extends('layouts.master')

@section('title')
    Signup
@endsection

@section('content')
@include('includes.message-block')
    <div class="row">
        <div class="col-md-6">
            <h3>Sign Up</h3>
            <form action="{{route('signup')}}" method="post">
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">Your Email</label>
                    <input class="form-control" type="text" name="email" id="email" value="{{Request::old('email')}}">
                </div>
                <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                    <label for="username">Your UserName</label>
                    <input class="form-control" type="text" name="username" id="username" value="{{Request::old('username')}}">
                </div>
                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                    <label for="first_name">Your First Name</label>
                    <input class="form-control" type="text" name="first_name" id="first_name" value="{{Request::old('first_name')}}">
                </div>
                <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                    <label for="last_name">Your Last Name</label>
                    <input class="form-control" type="text" name="last_name" id="last_name" value="{{Request::old('last_name')}}">
                </div>
                <div class="form-group {{ $errors->has('age') ? 'has-error' : '' }}">
                    <label for="age">Your Age</label>
                    <input class="form-control" type="integer" name="age" id="age" value="{{Request::old('age')}}">
                </div>
                <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                    <label for="phone">Your Phone Number</label>
                    <input class="form-control" type="text" name="phone" id="phone" value="{{Request::old('phone')}}">
                </div>
                <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
                    <label for="gender">Man/Woman</label>
                    <input class="form-control" type="text" name="gender" id="gender" value="{{Request::old('gender')}}">
                </div>
                <div class="form-group {{ $errors->has('discription') ? 'has-error' : '' }}">
                    <label for="discription">Discription</label>
                    <input class="form-control" type="text" name="discription" id="discription" value="{{Request::old('discription')}}">
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">Your Password</label>
                    <input class="form-control" type="password" name="password" id="password" value="{{Request::old('password')}}">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <input type="hidden" name="_token" value="{{ Session::token()}}">
            </form>
        </div>
@endsection