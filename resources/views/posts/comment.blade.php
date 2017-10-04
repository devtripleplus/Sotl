<form method="POST" action="/posts/{{$post->id}}/comment">
  {{ csrf_field() }}
  <div class="form-group">
   <textarea id="body" name="body" class="form-control" placeholder="Enter your comment here"></textarea>
  </div>
  
  
  <button type="submit" class="btn btn-primary">Post Comment</button>

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
  
</form>