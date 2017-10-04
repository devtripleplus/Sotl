@extends('layouts.layout')

@section('content')
<?php
use App\Http\Controllers\FilmsController;
use App\Http\Controllers\UploadsController;
if(isset($_GET['video_uri']) && $_GET['video_uri'] != '' && isset($_GET['ruid']) && $_GET['ruid'] != ''){
  $films = new FilmsController;
  $uploads = new UploadsController;
  
  $video_uri = $_GET['video_uri'];
  $video_uri =  explode('/', $video_uri);
  $vimeo_id = $video_uri[2];
   $ruid = $_GET['ruid'];
  $result = $films->updateFilmMetaData($vimeo_id, $ruid);

  if($result){
 ?>
		<section class="sotlLogin">
		<div class="container-fluid">
		    <div>
		          <h1 class="registerHead">Thank you for uploading your film!</h1>
		          <p class="tParaInfo text-center">The upload was successful, and once it has been converted for streaming, it will appear in the Screening Room under Your Pending Films.</p>
		    </div>
		</div>      
		</section>
<?php 
}
}
else{
?>
@include("errors.404")

<?php 
} 
?>
@endsection

