@extends('layouts.layout')

@section('content')

<table class="table table-bordered table-hover table-condensed table-responsive"><tr class="danger"><td>Title</td><td>Body</td><td>Edit</td><td>Delete</td></td></tr>

@foreach($posts as $post)
<tr class="info">
<td><a href='/posts/{{$post->id}}'>{{$post->title}}</a></td>							

<td>{{$post->body}}</td>
<td><a href='/post/{{$post->id}}/edit'>Edit</a></td>
<td><a href='/post/{{$post->id}}/delete'>X</a></td>
</tr>
@endforeach

</table>
@endsection