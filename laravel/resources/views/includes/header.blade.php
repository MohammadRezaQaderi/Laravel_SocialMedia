<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{route('dashboard')}}">2DR2DR</a>


    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" >
        <ul class="nav navbar-nav navbar-right" style="display: inline-block">
        @if(Auth::user() != null)
            <li><a href="{{route('welcome')}}"><img src="https://img.icons8.com/material-sharp/28/000000/home.png"/></a></li>
            <!-- <li><a href="{{route('account')}}">Account</a></li> -->
            <li><a href="{{route('chatPage')}}"><img src="https://img.icons8.com/ios-filled/24/000000/telegram-app.png"/></a></li>
            <li><a href="{{route('logout')}}"><img src="https://img.icons8.com/ios/22/000000/export.png"/></a></li>
            <li><div class="profile-image" style="position: relative;margin-top:7px; width: 35px;height: 35px;overflow: hidden;border-radius: 100%;">
                @if(Storage::disk('local')->has(Auth::user()->first_name . '-' . Auth::user()->username . '.jpg'))
                    <a href="{{route('profile')}}">
                        <img src="{{ route('account.image' , ['filename'=> Auth::user()->first_name . '-' . Auth::user()->username . '.jpg']) }}"  alt="" class="img-responsive" style="width: 100%;height: auto; herf">
                    </a>
                @elseif(Auth::user()->gender == 'Woman')
                    <a href="{{route('profile')}}">
                        <img src="https://i.pinimg.com/564x/88/99/1a/88991a9373f566d112912c8452fbc045.jpg" alt="" class="img-responsive"style="width: 100%;height: auto;">
                    </a>
                @elseif(Auth::user()->gender == 'Man')
                    <a href="{{route('profile')}}">
                        <img src="https://i.pinimg.com/564x/08/60/22/086022f21959c28084458586cf09eebb.jpg" alt="" class="img-responsive"style="width: 100%;height: auto;">    
                    </a>
                @endif
            </div></li>
        @endif
        @if((Auth::user() == null) and !(\Request::is('sign-in')))
            <li><a href="{{route('sign-in')}}">Login</a></li>
        @endif
        @if(\Request::is('sign-in'))
            <li><a href="{{route('sign-up')}}">SignUp</a></li>
        @endif 
        </ul>
    </div>
    </nav>
</header>