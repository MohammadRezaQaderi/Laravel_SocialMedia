@extends('layouts.master') 

@section('titel')
    Account
@endsection

@section('content')
    <section class="row new-post">
        <div class="col-md-6 col-md-offset-3">
            <header><h3>Your Account</h3></header>
            <form action="{{route('account.save')}}" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{$user->first_name}}">
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="{{$user->last_name}}">
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="text" name="age" class="form-control" value="{{$user->age}}">
                </div>
                <div class="form-group">
                    <label for="phone">Phone number</label>
                    <input type="text" name="phone" class="form-control" value="{{$user->phone}}">
                </div>
                <div class="form-group">
                    <label for="discription">Discription</label>
                    <input type="text" name="discription" class="form-control" value="{{$user->discription}}">
                </div>
                <div class="form-group">
                    <label for="image">Image Only .Jpg</label>
                    <input type="file" name="image" class="form-control" id="image">
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <input type="hidden" value="{{ Session::token() }}" name="_token">
            </form>
        </div>
    </section>
    @if(Storage::disk('local')->has($user->first_name . '-' . $user->username . '.jpg'))
        <div class="profile-image" style="position: relative;width: 200px;height: 200px;overflow: hidden;border-radius: 50%;">
            <img src="{{ route('account.image' , ['filename'=> $user->first_name . '-' . $user->username . '.jpg']) }}"  alt="" class="img-responsive" style="width: 100%;height: auto;">
		</div>
    @endif
@endsection

