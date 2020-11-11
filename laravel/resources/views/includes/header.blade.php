<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{route('dashboard')}}">2DR2DR</a>


    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" >
        <ul class="nav navbar-nav navbar-right" style="display: inline-block">
        @if(Auth::user() != null)
            <li><div class="profile-image" style="position: relative;width: 50px;height: 50px;overflow: hidden;border-radius: 85%;">
                @if(Storage::disk('local')->has(Auth::user()->first_name . '-' . Auth::user()->username . '.jpg'))
                    <img src="{{ route('account.image' , ['filename'=> Auth::user()->first_name . '-' . Auth::user()->username . '.jpg']) }}"  alt="" class="img-responsive" style="width: 100%;height: auto;">
                @elseif(Auth::user()->gender == 'Woman')
                    <img src="https://i.pinimg.com/564x/88/99/1a/88991a9373f566d112912c8452fbc045.jpg" alt="" class="img-responsive"style="width: 100%;height: auto;">
                @elseif(Auth::user()->gender == 'Man')
                    <img src="https://i.pinimg.com/564x/08/60/22/086022f21959c28084458586cf09eebb.jpg" alt="" class="img-responsive"style="width: 100%;height: auto;">    
                @endif
            </div></li>
            <li><a href="{{route('profile')}}">Profile</a></li>
            <li><a href="{{route('account')}}">Account</a></li>
            <li><a href="{{route('logout')}}">Logout</a></li>
        @endif
        </ul>
    </div>
    </nav>
</header>