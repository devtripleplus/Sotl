@if(!empty($Users))
<ul id="country-list">
@foreach($Users as $User)
<li>{{$User['name']}}</li>
@endforeach
</ul>
@endif

  