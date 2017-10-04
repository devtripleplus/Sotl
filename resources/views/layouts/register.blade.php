@extends('layouts.layout')


@section('content')
   

<section class="sotlLogin">
    <div class="container-fluid">
        <div class="logForm">
            <h1 class="registerHead">Please Register Here</h1>
            <form method="POST" action="/register">
                {{ csrf_field() }}
                <input type="hidden" name="role" value="non-student">

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name">Full Name</label>
                    <input id="name" type="text" class="form-control" name="name" placeholder="Full Name" value="{{ old('name') }}" required autofocus>
                    @if ($errors->has('name'))
                      <span class="help-block">
                          <strong>{{ $errors->first('name') }}</strong>
                      </span>
                    @endif  
                </div>


                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Email">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" class="form-control location" name="location" id="location" placeholder="Location">
                    @if ($errors->has('location'))
                        <span class="help-block">
                            <strong>{{ $errors->first('location') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation" id="cpassword" placeholder="Confirm Password">
                </div>
                <button type="submit" class="s-mit">Register</button>
                <div class="form-group editButton">
                  <a href="/login" class="s-mit">Already have an account?</a>
                </div>
                <!-- <div class="form-group editButton fbButton">
                     <a href="/login/facebook" class="s-mit">Login With Facebook</a>
                  </div>
                  <div class="form-group editButton linkedButton">
                     <a href="/login/linkedin" class="s-mit">Login With Linkedin</a>
                  </div> -->
            </form>
        </div>  
    </div>
</section>   



<script type="text/javascript">
      //* ajax script for cast and crew
jQuery(".location").keyup(function(e) {
  var $this=$(this);
   $( ".location" ).autocomplete({
    source: "/search/autocompleteLocation",
    dataType: 'json',
    minLength: 1,
    type: 'GET',
    select: function(event, ui) {
      $this.parents('p').next('.location').val(ui.item.value);
    }
  });
});
</script>

@endsection


        
   
