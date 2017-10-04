@extends('layouts.layout')


@section('content')

<?php 
use App\Http\Controllers\FilmsController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SiteSettingsController;
$userss  = new UserController;
$filmss = new FilmsController;
$reviewssss = new ReviewsController;
$sitesettings = new SiteSettingsController;
$settings = $sitesettings->getSettingsData();
  //phpinfo();
?>

<?php 

$status = '';
//current page url
$currentURL = URL::current();
// to check the upload film form cancelled
if(isset($_GET['status']) && $_GET['status'] == 'cancelled'){
  $status = $_GET['status'];
}

//to generate uuid
$ruId = $filmss->gen_uuid();

//TODO: for security, add ruId to `uploads` table now, and then only insert film meta with status=0 if it comes with an ruId matching one already in `uploads`

//to generate redirect url in url encoded format 
$redirect_url = urlencode(url('/') . "/thankyou?ruid=" . $ruId);

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.vimeo.com/me/videos?type=POST",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "redirect_url=" . $redirect_url,
  CURLOPT_HTTPHEADER => array(
    "authorization: Bearer 8036c21a8bce50ba835ddfc1a4c410a6",
    "content-type: application/x-www-form-urlencoded",
    "cache-control: no-cache"
    ),
  ));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //print_r($response);
  //decode the response into JSON so you can reference the response elements later
  $json = json_decode($response, true);
  //print_r($json);
 //echo  $json['upload_link_secure'];
} 
?>

@include('layouts.notification')
@if(Auth::user() && !(Auth::user()->role == 'non-student'))
@if ($flash = session('uploadvideo'))
<div class="alert alert-success">
  {{ $flash }}
</div>
@endif

<script>
  var progress = 0;
</script>

<section class="section68 uploadFilms">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-9">
        <div class="up-film">
          <h3 class="txtWWW">UPLOAD FILM</h3>
          <span style="color:#fff; font-size:20px; text-align:center">The required fields need to be filled out before starting your upload.</span>
          <form method="POST" action="{{ $json['upload_link_secure'] }}" enctype="multipart/form-data" id="upload_form">
           <input type="hidden" name="_token" value="{{ csrf_token() }}">
           <input type="hidden" name="userID" value="{{Auth::user()->id}}">
           <div class="uploading">
            <div class="row">
              <div class="col-sm-5">
                <div class="up-down">

                  <div class="dropdown challenge type">
                    <select class="btn dropdown-toggle" id="challenge" name="challenges">
                      <option value="">Challenge</option>
                      <option value="c1">Challenge 1</option>
                      <option value="c2">Challenge 2</option>
                    </select>
                    <span class="help-block">
                      <strong></strong>
                    </span>
                  </div>

                  <input type="hidden" name="ruid" value="{{$ruId}}">
                  <div class="dropdown genre genre{{ $errors->has('genre') ? ' has-error' : '' }}">
                    <select class="btn dropdown-toggle" id="genre" name="genre">
                      <option value="">genre</option>
                      <option value="g1">genre 1</option>
                      <option value="g2">genre 2</option>
                    </select>
                    
                    <span class="help-block">
                      <strong></strong>
                    </span>
                    
                  </div>

                    <!--
                    <div class="film file-upload">
                      <input type="file" name="file_data" id="film" class="inputfile" accept=".ogv, .ogg, .avi, .mov, .wmv, .mp4, .m4v" required />
                      <label for="film">
                        <p>Attach Movie File</p>  
                        <span class="filmname"></span>
                      </label>
                      <span style="color:#95989a">Choose .avi, .mov, .wmv, .mp4, or .m4v file no larger than 2.5GB.</span>
                      <strong></strong>
                    </div>
                  -->

                    <!-- <div class="film file-upload">
                      <input type="file" name="film" id="film" class="inputfile" data-multiple-caption="{count} files selected" multiple="" /> 
                       <input type="file" name="file_data"  id="film" class="inputfile">
                      <label for="film">
                        <p>Attach Movie File</p>   
                        <span class="filmname"></span>
                      </label>
                      <strong></strong>
                    </div> -->
                    

                    <div class="film file-upload">
                      <input type="file" name="thumbnail" id="thumbnail" class="inputfile" accept=".jpg, .jpeg, .png, .gif" />
                      <!-- data-multiple-caption="{count} files selected" multiple="" /> -->
                      <label for="thumbnail">
                        <p>Attach Thumbnail File</p>
                        <span class="thumbnailname"></span>
                      </label>
                      <span style="color:#95989a">Choose .png, .jpg, or .gif file.</span>
                    </div>
                    
                  </div>
                </div>
                <div class="col-sm-7">
                  <div class="movie_name">
                    <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Film Title"/>
                    
                    <span class="title help-block">
                      <strong></strong>
                    </span>
                    
                    <textarea name="biography"  id="biography" placeholder="Film Synopsis">{{ old('biography') }}</textarea>
                    
                    <span class="biography help-block">
                      <strong></strong>
                    </span>
                  </div>
                </div>
              </div>


              <div class="mm-details">
                <div class="row">
                  <div class="col-sm-4{{ $errors->has('director') ? ' has-error' : '' }}">
                    <div class="actors">
                      <div class="actors-details">
                        <h5>DIRECTOR</h5>


                        <div class="input_fields_director">
                          <div>

                            <p><a href="#" class="remove_field"><i class="fa fa-minus"></i></a><input type="text" class="crew" placeholder="Student Name" id="director" name="director[]" />
                              <input type="text" class="crewid" hidden  id="directorid"  name="directorid[]"  />
                            </p>

                          </div>
                          <button class="add_field_director"><i class="fa fa-plus"></i>Add</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4{{ $errors->has('producer') ? ' has-error' : '' }}">
                    <div class="actors">
                      <div class="actors-details">
                        <h5>PRODUCER</h5>


                        <div class="input_fields_producer">

                         <div>

                          <p><a href="#" class="remove_field"><i class="fa fa-minus"></i></a>
                            <input type="text" class="crew" placeholder="Student Name"  id="producer" name="producer[]"/>
                            <input type="text" class="crewid" hidden  name="producerid[]" id="producerid" />
                          </p>

                        </div>
                        <button class="add_field_producer"><i class="fa fa-plus"></i>Add</button>

                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4{{ $errors->has('editor') ? ' has-error' : '' }}">
                  <div class="actors">
                    <div class="actors-details">
                      <h5>EDITOR</h5>


                      <div class="input_fields_editor">
                       <div>

                        <p><a href="#" class="remove_field"><i class="fa fa-minus"></i></a>
                          <input type="text" class="crew" placeholder="Student Name" name="editor[]" id="editor" />
                          <input type="text" id="editorid" class="crewid" hidden  name="editorid[]" />
                        </p>

                      </div>
                      <button class="add_field_editor"><i class="fa fa-plus"></i>Add</button>

                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4{{ $errors->has('writer') ? ' has-error' : '' }}">
                <div class="actors">
                  <div class="actors-details">
                    <h5>WRITER</h5>


                    <div class="input_fields_writer ">
                     <div>

                      <p><a href="#" class="remove_field"><i class="fa fa-minus"></i></a>
                        <input type="text" class="crew" id="writer" placeholder="Student Name" name="writer[]"/>
                        <input type="text" class="crewid" hidden  id="writerid" name="writerid[]" />
                      </p>

                    </div>
                    <button class="add_field_writer"><i class="fa fa-plus"></i>Add</button>

                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-4{{ $errors->has('cinemotography') ? ' has-error' : '' }}">
              <div class="actors">
                <div class="actors-details">
                  <h5>CINEMATOGRAPHY</h5>

                  <div class="input_fields_cinemotography">
                   <div>

                    <p><a href="#" class="remove_field"><i class="fa fa-minus"></i></a>
                      <input type="text" class="crew" placeholder="Student Name" id="cinemotography" name="cinemotography[]"/>
                      <input type="text" class="crewid" hidden  name="cinemotographyid[]" id="cinemotographyid" />
                    </p>

                  </div>
                  <button class="add_field_cinemotography"><i class="fa fa-plus"></i>Add</button>

                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-4{{ $errors->has('actor') ? ' has-error' : '' }}">
            <div class="actors">
              <div class="actors-details">
                <h5>ACTOR</h5>

                <div class="input_fields_actor">
                 <div>

                  <p><a href="#" class="remove_field"><i class="fa fa-minus"></i></a>
                    <input type="text" id="actor" class="crew" placeholder="Student Name" name="actor[]" />
                    <input type="text" class="crewid" id="actorid" hidden  name="actorid[]" />
                  </p>

                </div>
                <button class="add_field_actor"><i class="fa fa-plus"></i>Add</button>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <script type="text/javascript">
      var myform = document.getElementById('upload_form');

      myform.addEventListener("submit", function (event) {
        
        if (myform.validity.valid) {
          title.setCustomValidity(""); 
        } 
        else {
          event.preventDefault(); 
        }
      });                                      
    </script>
    
    <div class="text-center">
      <!-- <button type="submit" class="s-mit" onclick="uploadFilmData();" >Submit Film</button> -->
      <!-- <a href="javascript:void(0)" class="s-mit verifySubmit" onclick="uploadFilmData();">VERIFY FIELDS</a> -->
      <!-- <div id="vimeoSubmit" style="display: none;"> -->
      <!-- <p>All fields verified! Click SUBMIT FILM to upload!</p> -->
      <!-- <input type="submit" name="submit"  class="s-mit" value="SUBMIT FILM"> -->
      <!-- </div> -->
      <a href="javascript:void(0)" class="s-mit" onclick="uploadFilmData();">Continue To Upload</a>
    </div>
    
  </form>
  
</div>
</div>
</div>
<?php 
/* films that not get reviewed by current logged in user */
$filmNotReviewedYets = $filmss->getallPendingFilmstoReview();
?>
<div class="col-md-3">
  <div class="p-films">
    <h5><span class="fa fa-angle-down dropLeft"></span>Your Pending Films<span class="fa fa-angle-down dropRight"></span></h5>
    <div class="artists">
      <div class="art">
        @foreach($filmNotReviewedYets as $filmNotReviewedYet)
        <?php 
        $reviewsForThisFilm = $reviewssss->getReviewUsingFilmID($filmNotReviewedYet['id']);
        $avgrating = $reviewssss->getAvgReviewsRating($reviewsForThisFilm);
        ?>
        <div class="vCard">
         <a href="/videos/{{$filmNotReviewedYet['vimeo_video_id']}}">
          <img class="vCardImg" src="/uploads/{{$filmNotReviewedYet['video_thumbnail']}}" alt="">
          <div class="vCardGradient"></div>
          <div class="vcardInfo2">
            <input id="kartik" name="filmrating" class="rating" data-stars="5" data-step="0.1" value="{{$avgrating}}" disabled title=""/>
            <h5>{{count($reviewsForThisFilm)}} Reviews</h5>
          </div>
          <div class="vCardInfo">
            <h2 class="txtWWW txt300 text-uppercase">{{str_limit($filmNotReviewedYet['title'], 15, '..')}}</h2>
            <p class="txtGGG txt30 txt300 text-uppercase">Uploaded: {{date('M d, Y', strtotime($filmNotReviewedYet['created_at']))}}</p>
          </div>
        </a>
      </div>
      @endforeach
    </div>
  </div>
</div>
</div>

</div>
</div>
</section>
</form>
@else
<div class="col-md-12">
  <h2 for="title" align="center">You Don't have Upload Video Previlege</h2>
</div>
@endif   

<section class="section68 ftr">
  <div class="container-fluid">
    <div class="brMore">
      <div class="dropdown">
        <span class="fa fa-angle-down dropLeft"></span>
        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          Films To Review
        </button>
        <span class="fa fa-angle-down dropRight"></span>
      </div>
    </div>
    <div class="dropDown">
      <div class="row">
        <div class="col-sm-4">
          <div id="locationAjax" class="dropdown">
            <?php $locations = $userss->getAllUsersLocations();  ?>
            <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">Select Location
            </button>
            <ul class="dropdown-menu">
              <li><a href="javascript:void(0)">Select Location</a></li>
              @foreach($locations as $location)
              <li><a href="javascript:void(0)" data-value="{{$location['location']}}">{{$location['location']}}</a></li>
              @endforeach
            </ul>
          </div>
        </div>
        <div class="col-sm-4">
          <div id="genreAjax" class="dropdown">
            <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">Select Genre</button>
            <ul class="dropdown-menu">
              <li><a href="javascript:void(0)" data-value="">Select Genre</a></li>
              <li><a href="javascript:void(0)" data-value="g1">Genre 1</a></li>
              <li><a href="javascript:void(0)" data-value="g2">Genre 2</a></li>
              <li><a href="javascript:void(0)" data-value="g3">Genre 3</a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="dropdown col-white">
            <input type="text" id="search" name="search" class="search-btn" placeholder="Search Any films..">
            <span class="fa fa-search rotate45"></span></button>
          </div>
        </div>
      </div>
    </div>


    <?php   
    /* list all the films that have less than 5 reviews */  
    $allfilms = $filmss->countAllFilmsLessThanFiveReview();
    $films = $filmss->getFilmsWithLessThanFiveReviews();
    
    ?>
    @if($films)
    <div id="movieReview">


      <div class="row" id="loadFilms">
        @foreach($films as $film)


        <div class="col-md-4 col-sm-6">
          <div class="vCard vCard2">
            <a href="/videos/{{$film['vimeo_video_id']}}">
              @if(isset($film['video_thumbnail']))
              <img class="vCardImg" src="/uploads/{{$film['video_thumbnail']}}" alt="">
              @endif
              <div class="vCardGradient"></div>
              <div class="timer">
               <!--  <p>{{$film['duration']}}</p> -->
             </div>
             <div class="vCardInfo">
              <h2 class="txtWWW txt300">{{str_limit($film['title'],15,'...')}}</h2>
              <p class="txt30 txt300">{{str_limit($film['biography'],175,'...')}}</p>
            </div>
          </a>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @else
  <div id="nwAva">
    <div class="container-fluid">
     <div class="row">
       <h3 class="text-center txtWWW txt300">No films found</h3>
     </div>
   </div>
 </div>  
 @endif
 <div class="text-center" id="nextPreviousButton">
  @if(count($films) >= 3 && $allfilms > 3)
  <div class="text-center">
    <button id="filmLoadMore" class="s-mit pull-center">Load More</button>
    <button id="filmsPrev" class="hide s-mit pull-left">Prev</button>
    <button id="filmsNext" class="hide s-mit pull-right">Next</button>
  </div>

  @endif  
</div> 


</div>
</section>
<!-- section -->
<!-- Modal -->
<div id="filmModalSize" class="modal fade" role="dialog" style="width: 100%; height: 700px;z-index: 9999; padding-left:0!important;margin-left:-7px!important;" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="border: 1px solid #fff;min-height:200px;background:#000;border-radius: 3px;margin-top:70px">

    <!-- Modal content-->
    <div class="modal-content" style="background-color: #000000">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" style="padding: 60px 0 50px;">
        <h5 class="txtWWW txt300 text-center">File size can not be more than 2.5GB </h5>
        
      </div>
      
    </div>

  </div>
</div>
<div id="filmModalType" class="modal fade" role="dialog" style="width: 100%; height: 700px;z-index: 9999; padding-left:0!important;" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" style="border: 1px solid #fff;min-height:200px;background:#000;border-radius: 3px;margin-top:70px">

    <!-- Modal content-->
    <div class="modal-content" style="background-color: #000000">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" style="padding: 60px 0 50px;">
        <h5 class="txtWWW txt300 text-center">Choose .avi, .mov, .wmv, .mp4, or .m4v file</h5>
        
      </div>
      
    </div>

  </div>
</div>



<div id="filmuploadsucess" class="modal fade" role="dialog" style="width: 100%; height: 700px;z-index: 9998" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="background-color: #000000">
<!--       <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div> -->
      <div class="modal-body" style="padding: 50px 20px">
        <h5 class="txtWWW txt300 text-center">Please wait...uploading your film may take a while.  You'll be redirected to a confirmation page when finished.</h5>
        
      </div>
      
    </div>

  </div>
</div>

<div id="filmvimeouploadsucess" class="modal fade" role="dialog" style="width: 100%; height: 700px;z-index: 9998" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog">

   <!-- Modal content-->
   <div style="background: rgb(0, 0, 0);border:none;">
     <div class="uploading">
       <div class="up-down">
        <div class="modal-content" style="background-color: #000000; border: 1px solid rgb(153, 153, 153)!important; ">
          <div class="modal-body" style="padding: 30px 20px 10px 20px">
           
            <form id="filmSubmitForm" action="{{$json['upload_link_secure']}}" method="POST" enctype="multipart/form-data">
              <div class="film file-upload">
                <strong></strong>
                <input type="file" name="file_data"  id="film" class="inputfile" accept=".ogv, .ogg, .avi, .mov, .wmv, .mp4, .m4v" />
                <label for="film">
                  <p>Attach Movie File</p>  
                  <span class="filmname"></span>
                </label>
                <span style="color:#95989a">Choose .avi, .mov, .wmv, .mp4, or .m4v file no larger than 2.5GB.</span>
                
              </div>
              
<script type="text/javascript">
//  maxSize admin settings tool in gb
var fileSize12 = '<?php echo $settings['max_file_size_in_gb'];  ?>';
var fileSize = 3000000;
var maxSize = fileSize12 * 1024 * 1024 * 1024;
var myform = document.getElementById('filmSubmitForm');
var filmFile = document.getElementById('film');
var loadStart = 0;
var progress = 0;
console.log("loadStart set: " + loadStart);
console.log("progress set: " + progress);
var status = '<?php echo $status; ?>';
if(status == 'cancelled'){
  jQuery("#filmvimeouploadsucess").modal();
}

jQuery(document).ready( function(){
  jQuery(".c-upload").on("click", function( event){
    window.location = "<?php echo $currentURL.'?status=cancelled'; ?>";
  });
});
filmFile.addEventListener("change", function (event) {
  var txt = "";
  var file = filmFile.files[0];
  var fileType = isVideo(file.type);
  if(fileType != true){
    jQuery("#filmModalType").modal().on('show', function(event){
      
      jQuery("#filmModalType").css({
        "padding-left":"0!important"                 
      });
      alert("no fileType");
    });
    ;
    myform.reset();


  }
  function isVideo(filename) {
    switch (filename) {
      case 'video/quicktime':
      case 'video/mp4':
      case 'video/ogg':
      case 'video/x-msvideo':
      case 'video/x-ms-wmv':
      case 'audio/ogg':
                      // etc
                      return true;
                    }
                    return false;
                  }


    if (file.size > maxSize) {
      filmFile.setCustomValidity("Please choose a file no larger than 2.5GB!");
      //alert("Please choose a file no larger than 2.5GB!");
      jQuery("#filmModalSize").modal();
      $(document.body).css('padding-left','0')
      //reset form
      myform.reset();
    } else {
      filmFile.setCustomValidity("");
      fileSize = file.size;
    }
    
  });

myform.addEventListener("submit", function (event) {
  if( document.getElementById("film").files.length == 0 ){
    jQuery("#filmSubmitForm strong").text("This is a required field!");
    //reset form
    myform.reset();
    //prevent the form from being sent by canceling the event
    event.preventDefault();
  }else{
    loadStart = 1;
    progress = 0;
	jQuery("#filmSubmitForm button[type=submit]").css('display',"none");
    jQuery(".c-message p").css('display',"block");
    jQuery(".c-upload").css('display',"block");
    jQuery(".spinner").css('display',"block");
    title.setCustomValidity(""); 
  }
  // if (filmFile.files[0].size > maxSize) {
  //   //TODO: fix this so you get a proper error message if you click Submit on a film over maxSize!
  //   alert("Please choose a film no larger than 2.5GB!");
  //   //jQuery("#filmModal").modal();
  //   console.log("file is " + document.getElementById('film').size + " bytes!");
  //   //reset form
  //   myform.reset();
  //   //prevent the form from being sent by canceling the event
  //   event.preventDefault();
  // } 
  // else {
  //   title.setCustomValidity("");   
  // }

});                                      
</script>          

<button type="submit" style="margin-top: 25px" class="s-mit">Submit Film</button>
</form>
<div class="c-message"><p style="display: none; text-align: center;">Your upload is in process.  The progress bar may reset several times while we convert your film for streaming.</p></div>
<div id="content" class="spinner" style="background-color: #000000; text-align: center; display: none; "></div>
<button type="reset"  class="c-upload s-mit" style="display: none; margin: 0 auto;">CANCEL UPLOAD</button>
</div>

</div>
</div>
</div>
</div>

</div>
</div>


<script type="text/javascript">



  function uploadFilmData(){
    if(jQuery("#genre").val() == '' || jQuery("#challenge").val() == '' || jQuery("#title").val() == '' || jQuery("#biography").val() == ''){
      if(jQuery("#challenge").val() == ''){
        jQuery(".challenge strong").text("This is a required field!");
      }else{
        jQuery(".challenge strong").text("");
      }
      if(jQuery("#genre").val() == ''){
        jQuery(".genre strong").text("This is a required field!");
      }
      else{
        jQuery(".genre strong").text("");
      }
      if(jQuery("#title").val() == ''){
        jQuery(".title strong").text("This is a required field!");
      }
      else{
        jQuery(".title strong").text("");
      }
      if(jQuery("#biography").val() == ''){
        jQuery(".biography strong").text("This is a required field!");
      }
      else{
        jQuery(".biography strong").text("");
      }
      // if(jQuery("#thumbnail").val() == ''){
      //   jQuery(".thumbnail strong").text("This is a required field!");
      // }
      // else{
      //   jQuery(".thumbnail strong").text("");
      // }
      
    }
    else{
      var formData = new FormData(jQuery("#upload_form")[0]);
    //formData.title = jQuery("#title").val();
    //formData.biography = jQuery("#biography").val();
    //formData.genre = jQuery("#genre").val();
    //formData.challenge = jQuery("#challenge").val();
    //formData.director = jQuery("#director").val();
    //formData.directorid = jQuery("#directorid").val();
    //formData.producer = jQuery("#producer").val();
    //formData.producerid = jQuery("#producerid").val();
    //formData.editor = jQuery("#editor").val();
    //formData.editorid = jQuery("#editorid").val();
    //formData.writer = jQuery("#writer").val();
    //formData.writerid = jQuery("#writerid").val();
    //formData.cinemotography = jQuery("#cinemotography").val();
    //formData.cinemotographyid = jQuery("#cinemotographyid").val();
    //formData.actor = jQuery("#actor").val();
    //formData.actorid = jQuery("#actorid").val();
    //formData.thumbnail = jQuery("#thumbnail").val();
    //formData.append('title', 'biography', 'genre', 'challenge', 'director', 'directorid', 'producer', 'producerid', 'editor', 'editorid', 'writer', 'writerid', 'cinemotography', 'cinemotographyid', 'actor', 'actorid', 'thumbnail');
    //formData.append("test", "some test data");

    jQuery.ajax({
      url: "/upload",
      type: 'POST',
      data: formData,
      async: false,
      success: function (data) {
        if(data == 'true'){
                //jQuery("#upload_form").submit();
                jQuery("#filmvimeouploadsucess").modal();                

              }
              else{
                alert("Something went wrong when you are trying to upload this film");
              }
            },
            cache: false,
            contentType: false,
            processData: false
          });

  }
}


function jsFunction(value){
  window.location = '?genre='+value;
}
function locationFunction(value) {
  window.location = '?location='+value;
}

      //* ajax script for cast and crew
      $('body').on('keyup','.crew',function(){
        var $this=$(this);
        $( ".crew" ).autocomplete({
          source: "/search/autocomplete",
          dataType: 'json',
          minLength: 1,
          type: 'GET',
          select: function(event, ui) {
            $this.parents('p').next('.crew').val(ui.item.value);
            $this.siblings('.crewid').val(ui.item.id);
            console.log(ui.item.id);
          }
        });
      });



//* ajax script for cast and crew
      //jQuery("#search").focus( function(){
        jQuery("#search").keyup(function(e) {
         
        //jQuery("#genreAjax button").text(jQuery(this).text());
        jQuery("#filmLoadMore").addClass('hide');
        var search = jQuery(this).val();
        jQuery.ajax({
          url: "/search/films/upload",
          type: "GET",
          data:{'search' : search},
          success: function(data){
            //console.log(data);
            jQuery("#loadFilms").html(data);
          }
        });
      });
        
        // });

        

        jQuery("#genreAjax li a").click( function(){
          jQuery("#genreAjax button").text(jQuery(this).text());
          jQuery("#filmLoadMore").addClass('hide');
          var genre = jQuery(this).attr("data-value");
          jQuery.ajax({
            url: "/search/films/upload",
            type: "GET",
            data:{'genre' : genre},
            success: function(data){
            //console.log(data);
            jQuery("#loadFilms").html(data);
          }
        });
        });

        jQuery("#locationAjax li a").click( function(){
          jQuery("#locationAjax button").text(jQuery(this).text());
          jQuery("#filmLoadMore").addClass('hide');
          var location = jQuery(this).attr("data-value");
          jQuery.ajax({
            url: "/search/films/upload",
            type: "GET",
            data:{'location' : location},
            success: function(data){
            //console.log(data);
            jQuery("#loadFilms").html(data);
          }
        });
        });

      // Films load more ajax with next and previous

      var initial_count = 1;
      var allfilms = '<?php echo $allfilms; ?>';
      jQuery("#filmLoadMore").click( function(){
        jQuery(this).removeClass("show").addClass("hide");
        jQuery("#filmsPrev").removeClass("hide").addClass("show");
        jQuery("#filmsNext").removeClass("hide").addClass("show");
        initial_count++;
        var total = 3*initial_count;
        console.log((parseInt(total, 10) - parseInt(allfilms, 10))%3);
        if((parseInt(total, 10) - parseInt(allfilms, 10))%3 > 3){
         jQuery("#filmsNext").removeClass("show").addClass("hide");
       }
       jQuery.ajax({
        url: "/films/ajaxdataupload",
        type: "GET",
        data:{'total' : total},
        success: function(data){
          jQuery("#loadFilms").html(data);
        }
      });
     });

      jQuery("#filmsPrev").click( function(){
        initial_count--;

        var total = 3*initial_count;
        if(total==3){
          jQuery(this).removeClass("show").addClass("hide");
          jQuery("#filmLoadMore").removeClass("hide").addClass("show");
          jQuery("#filmsNext").removeClass("show").addClass("hide");
        }
        jQuery.ajax({
          url: "/films/ajaxdataupload",
          type: "GET",
          data:{'total' : total},
          success: function(data){
            jQuery("#loadFilms").html(data);
          }
        });
      });
      jQuery("#filmsNext").click( function(){
        initial_count++;
        var total = 3*initial_count;
        var filmtotal = '<?php echo $allfilms; ?>';
        filmtotal = parseInt(filmtotal, 10);
        console.log(filmtotal+" "+total+" "+(parseInt(filmtotal, 10) - parseInt(total, 10))%3);
        if((parseInt(filmtotal, 10) - parseInt(total, 10))%3 < -2){
          initial_count--;
          jQuery(this).removeClass("show").addClass("hide");
          jQuery("#filmLoadMore").removeClass("show").addClass("hide");
          jQuery("#filmsPrev").removeClass("hide").addClass("show");
        }else{
          if((parseInt(filmtotal, 10) - parseInt(total, 10))%3 <= 0){
            jQuery(this).removeClass("show").addClass("hide");
          }
          jQuery.ajax({
            url: "/films/ajaxdataupload",
            type: "GET",
            data:{'total' : total},
            success: function(data){
              jQuery("#loadFilms").html(data);
            }
          });
        }
      });

      $('#film').change(function() {
        var filename = $('#film').val().replace(/C:\\fakepath\\/i, '');
        //console.log(filename);
        $('.filmname').text(filename);
        

      });
      $('#thumbnail').change(function() {
        var filename = $('#thumbnail').val().replace(/C:\\fakepath\\/i, '');
        //console.log(filename);
        $('.thumbnailname').text(filename);
        

      });
      
      


      
    </script>


    <script>
      $(document).ready(function() {
      
var colors = {
    'blue': '#57d8ff',
    'yellow': '#f0ff08',
    'green': '#47e495'
};

var color = colors.blue;

var radius = 100;
var border = 5;
var padding = 30;
var startPercent = 0;
var endPercent = 1;


var twoPi = Math.PI * 2;
var formatPercent = d3.format('.0%');
var boxSize = (radius + padding) * 2;


var step = endPercent < startPercent ? -0.01 : 0.01;

var arc = d3.arc()
    .startAngle(0)
    .innerRadius(radius)
    .outerRadius(radius - border);

var parent = d3.select('div#content');

var svg = parent.append('svg')
    .attr('width', boxSize)
    .attr('height', boxSize);

var defs = svg.append('defs');

var filter = defs.append('filter')
    .attr('id', 'blur');

filter.append('feGaussianBlur')
    .attr('in', 'SourceGraphic')
    .attr('stdDeviation', '7');

var g = svg.append('g')
    .attr('transform', 'translate(' + boxSize / 2 + ',' + boxSize / 2 + ')');

var meter = g.append('g')
    .attr('class', 'progress-meter');

meter.append('path')
    .attr('class', 'background')
    .attr('fill', '#ccc')
    .attr('fill-opacity', 0.5)
    .attr('d', arc.endAngle(twoPi));

var foreground = meter.append('path')
    .attr('class', 'foreground')
    .attr('fill', color)
    .attr('fill-opacity', 1)
    .attr('stroke', color)
    .attr('stroke-width', 5)
    .attr('stroke-opacity', 1)
    .attr('filter', 'url(#blur)');

var front = meter.append('path')
    .attr('class', 'foreground')
    .attr('fill', color)
    .attr('fill-opacity', 1);

var numberText = meter.append('text')
    .attr('fill', '#fff')
    .attr('text-anchor', 'middle')
    .attr('dy', '.35em');

function updateProgress(progress) {
  if (loadStart == 1) {
    foreground.attr('d', arc.endAngle(twoPi * progress));
    front.attr('d', arc.endAngle(twoPi * progress));
    numberText.text(formatPercent(progress));
  } else {
    progress = 0;
    foreground.attr('d', arc.endAngle(twoPi * progress));
    front.attr('d', arc.endAngle(twoPi * progress));
    numberText.text(formatPercent(twoPi * progress));
  }
  
}


//var progress = startPercent;
var count = 1;

(function loops() {
    updateProgress(progress);
        progress += step;
        setTimeout(loops, (fileSize/45000) * (1 + Math.log(count)));
    if (progress >= (Math.floor(Math.random() * (99 - 87 + 1) + 87))/100 && loadStart == 1) {
      progress = (Math.floor(Math.random() * (11 - 3 + 1) + 3))/100;
      count++
    }
})();

      })
    </script>



    @endsection
