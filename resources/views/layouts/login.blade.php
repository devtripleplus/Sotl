@extends('layouts.layout')


@section('content')
       


  <section class="sotlLogin">
    <div class="container-fluid">
        <div class="logForm">
              <h1 class="registerHead">Please Login Here</h1>
               <form method="POST" action="/login">
               {{ csrf_field() }}
                  <div class="form-group">
                    <label for="email">User Email</label>
                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Email" required>
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                  </div>
                  <button type="submit" class="s-mit">Login</button>
                  <div class="form-group editButton">
                     <a href="/register" class="s-mit">Not have an accout?</a>
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


@endsection


        
   
