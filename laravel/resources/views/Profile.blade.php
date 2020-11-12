@extends('layouts.master')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="src/css/profile.css">
</head>

	<div class="container">
		<div class="profile">
			<div class="profile-image">
				@if(Storage::disk('local')->has($user->first_name . '-' . $user->username . '.jpg'))
					<img src="{{ route('account.image' , ['filename'=> $user->first_name . '-' . $user->username . '.jpg']) }}"  alt="" class="img-responsive">
				@elseif(Auth::user()->gender == 'Woman')
					<img src="https://i.pinimg.com/564x/88/99/1a/88991a9373f566d112912c8452fbc045.jpg" alt="" class="img-responsive"style="width: 100%;height: auto;">
				@elseif(Auth::user()->gender == 'Man')
					<img src="https://i.pinimg.com/564x/08/60/22/086022f21959c28084458586cf09eebb.jpg" alt="" class="img-responsive"style="width: 100%;height: auto;"> 
				@endif
			</div>
			<div class="profile-user-settings">
				<h5 class="profile-user-name" >{{$user->username}}</h5>
				<button class="btn profile-edit-btn"><a href="{{route('account')}}">Edit Profile</a></button>
				<button class="btn profile-settings-btn" aria-label="profile settings"><i class="fas fa-cog" aria-hidden="true"></i></button>
			</div>
			<div class="profile-stats">
				<ul>
                <?php $post_count = 0; ?>
                    @foreach($posts as $post)
                        @if($post->user_id == $user->id)
                            <?php $post_count++; ?> 
                        @endif
                    @endforeach
					<li><span class="profile-stat-count">{{$post_count}}</span> posts</li>
					<li><span class="profile-stat-count">188</span> followers</li>
					<li><span class="profile-stat-count">206</span> following</li>
				</ul>
			</div>
			<div class="profile-bio">
				<p><span class="profile-real-name">{{$user->first_name}} {{$user->last_name}}  </span> {{$user->discription}}</p>
			</div>
		</div>
		<!-- End of profile section -->
	</div>
	<!-- End of container -->
</header>

<main>
	<div class="container">

		<div class="gallery">
			@foreach($posts as $post)
				@if($user->id == $post->user_id)
					<div class="gallery-item" tabindex="0">
					@if(Storage::disk('public')->has($post->user->first_name.'_' . 'Post' . '-' . $post->id . '.jpg'))
					   	<img href="{{route('post.view' , ['post_id' => $post->id ] )}}" src="{{ route('post.image' , ['filename'=> $post->user->first_name.'_' . 'Post'. '-' . $post->id . '.jpg']) }}"  alt="" class="gallery-image">
                	@endif
					<?php $post_like = 0; ?>
                    @foreach($likes as $like)
                        @if(($post->id == $like->post_id)&($like->like == 1))
                            <?php $post_like++; ?> 
                        @endif
                    @endforeach
					<?php $post_comment = 0; ?>
                    @foreach($comments as $comment)
                        @if(($post->id == $comment->post_id))
                            <?php $post_comment++; ?> 
                        @endif
                    @endforeach
						<div class="gallery-item-info">
							<ul>
								<li class="gallery-item-likes"><i class="material-icons">favorite</i> {{$post_like}}</li>
								<li class="gallery-item-comments"><i class="material-icons">comment</i> {{$post_comment}}</li>
							</ul>
						</div>
					</div>
				@endif
			@endforeach
		<!-- <div class="loader"></div> -->
	</div>
	<!-- End of container -->
</main>
@endsection
