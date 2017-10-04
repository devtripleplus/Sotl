@extends("layouts.layout")

@section('content')
<h2>Update this Post</h2>
<hr>
<form action="/post/{{$post->id}}/update" method="POST">
	{{ csrf_field() }}
  <div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control" id="title" name="title" placeholder="" value="{{$post->title}}">
  </div>
  <div class="form-group">
    <label for="body">Body</label>
    <textarea class="form-control" id="body" name="body">{{$post->body}}</textarea>
  </div>
 
  <button type="submit" class="btn btn-primary">Update</button>
</form>
@if(count($errors))
<div class="alert-danger">
	
	<ul>
		@foreach($errors->all() as $error)
			<li>{{$error}}<li>
		@endforeach

	</ul>

</div>
@endif

@endsection('content')