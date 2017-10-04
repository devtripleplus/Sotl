@extends('layouts.layout')


@section('content')

<div class="group-form">
	
<h2><a href="{{$post->id}}">{{$post->title}}</a></h2>
<p>{{$post->body}}</p>
</div>

<div class="card">
	<div class="card-block">
		<div class="form-group">
			<h2>Comment for this post:</h2>
			<hr>
			
				<ul class="lists">
					@foreach($post->comments as $comment)
						<li class="list-items"><strong>{{$comment->user->name}} on {{$comment->created_at->diffForHumans()}}</strong>  {{$comment->body}}</li>
					@endforeach

				</ul>	
		</div>
	</div>

</div>


@include('posts.comment')

@endsection