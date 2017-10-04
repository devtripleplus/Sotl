@extends("layouts.layout")

@section("content")
<h1>Create a post</h1>

<hr>
<form method="POST" action="/posts/store">
   {{ csrf_field() }} 
  <div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control" name="title" id="title">
  </div>
  <div class="form-group">
    <label for="body">Body</label>
    <textarea id="body" name="body" class="form-control"></textarea>
  </div>
  
  
  <button type="submit" class="btn btn-primary">Publish</button>
</form>
<hr>
@if(count($errors)) 
<div class="alert-danger alert">
	<ul>
		@foreach($errors->all() as $error)
		<li>{{$error}}</li>
		@endforeach
	</ul>

</div>
@endif

@endsection