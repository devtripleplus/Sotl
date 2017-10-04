
@if(count($errors)) 
<div class="alert-danger alert">
  <ul>
    @foreach($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
  </ul>

</div>
@endif