  @extends('layouts.layout')


  @section('content')
  @if ($flash = session('uploadvideo'))
  <div class="alert alert-success">
    {{ $flash }}
  </div>
  @endif

  <section class="section68 uploadFilms">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-9">
          <div class="up-film">
            <h3 class="txtWWW">UPLOAD FILMS</h3>
            <form method="POST" action="/uploadtest" enctype="multipart/form-data" id="upload_form">
             <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <div class="uploading">
              <div class="row">
                <div class="col-sm-5">
                  <div class="up-down">

                    <div class="file-upload{{ $errors->has('film') ? ' has-error' : '' }}">
                      <input type="file" name="film" id="film" class="inputfile" data-multiple-caption="{count} files selected" />
                      <label for="film">
                        <p>Attach Movie File</p>   
                        <span></span>
                      </label>

                    </div>
                  </div>
                </div>
      </div>
    </div>
    <div class="text-center">
    <button type="submit" class="s-mit"  >Submit Film</button>
    </div>
  </div>
</div>
</div>
  @endsection