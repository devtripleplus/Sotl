@extends('layouts.layout')

@section('content')
<?php $allfilms = DB::table('films')->get()->count();
      if(!Auth::user()){
        $film_id = $film[0]['id'];
      }
      else{
        $film_id = $film[0]['id'];
      }
      
 ?>
 <?php $reviewsForThisFilm = DB::table('reviews')->where('film_id','=',$film[0]['id'])->get()->toArray();
        //print_r($reviewsForThisFilm);
        $totalfilmrationg = 0;
        foreach ($reviewsForThisFilm as $review) {
            $totalfilmrationg = $totalfilmrationg + unserialize($review->rate_elements)['filmrating'];
         } 
         $avgrating = 0;
         if(count($reviewsForThisFilm) != 0){
           $avgrating = $totalfilmrationg/count($reviewsForThisFilm);
         }
         $teamcreditss = unserialize($film[0]['team_credit']);
         
      ?>
<section class="featuredFilm">
        <div class="ffilm">
            <div class="row">
                <div class="col-md-6">
                    <div class="ffilmOuter">
                       <img src="/img/ffilm.png" alt="">
                       <div class="vCardGradient"></div>
                        <div class="ffilmInner">
                            <h3 class="txt300 tac">FEATURED FILM</h3>
                            <div class="ffilmDetails">
                                <h3 class="txt300">{{$film[0]['title']}}</h3>
                                <div class="vcardInfo2">
                                    <input id="kartik" name="filmrating" class="rating" data-stars="5" data-step="0.1" value="{{$avgrating}}" disabled title=""/>
                                    <label for="filmrating">{{count($reviewsForThisFilm)}} Reviews | <a href="/videos/{{$film[0]['vimeo_video_id']}}/?show=reviews" class="text-left">Read Reviews</a></label>
                                </div>
                                <p>{{$film[0]['biography']}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="side-capture">
                        <img src="/img/capture.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="clearfix"></div>

   @if(!Auth::user())
        <?php 
          $reviews = DB::table('reviews')->where('film_id','=',$film[0]['id'])->orderBy('helpfullreviewcount', 'desc')->take(2)->get(); 
        ?>
        
        @if(!empty($reviews->toArray()) && count($reviews->toArray()) >= 2)
    <section class="topReviews">
        <div class="container-fluid">
            <div class="brMore">
                    <div class="dropdown">
                      <span class="caret"></span>
                      <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        TOP REVIEWS
                      </button>
                       <span class="caret"></span>
                    </div>
               </div>
            <div class="topR">
                <div class="row">
                @foreach($reviews as $review)
                    <div class="col-sm-6">
                    <?php 
                    $filmrating = unserialize($review->rate_elements)['filmrating'];
                    ?>
                        <div class="vCard">
                           <a href="">
                            <img class="vCardImg" src="/img/review/reviewbg.png" alt="">
                            <div class="vCardGradient"></div>
                            <div class="vcardInfo2">
                                <input id="kartik" name="filmrating" class="rating" data-stars="5" data-step="0.1" value="{{$filmrating}}" disabled title=""/>
                                <label for="filmrating">{{$filmrating}} Stars</label>
                            </div>
                            <div class="vCardInfo">
                                <h2>{{$review->title}}</h2>
                                <p>{{$review->description}}</p>
                                <p class="stuName">
                                    <a href="">{{DB::table('users')->where('id','=',$review->user_id)->get()->toArray()[0]->name}}</a> | <a href="">{{date('M d, Y', strtotime($review->created_at))}}</a>
                                </p>
                            </div>
                            @if(Auth::user())
                            <div class="helpful">
                                <a href="/review/helpful/{{$review->id}}">Helpful?</a>
                            </div>
                            @endif
                            </a>
                        </div>
                    </div>
                    @endforeach

                
                    
                    
                </div>
            </div>
        </div>
    </section>
@endif    
      @endif
    <div class="clearfix"></div>

    <section class="hottestFilm">
        <video width="100%" height="">
            <source src="movie.mp4" type="video/mp4">
        </video>
        <div class="playBtn">
            <a href="#"><img src="/img/review/playbtn.png" alt=""></a>
        </div>
    </section>


        <section class="filmsSlide">
        <div class="slideinner3">
            <div class="owl-carousel f-slide owl-theme">
                <div class="item">
                    <div class="vCard">
                       <a href="">
                        <img class="vCardImg" src="/img/student.png" alt="">
                        <div class="vCardGradient"></div>
                        <div class="timer">
                            <p>00:10:35</p>
                        </div>
                        <div class="vcardInfo2">
                            <input id="kartik" name="filmrating" class="rating" data-stars="5" data-step="0.1" value="3.6" disabled title=""/>
                                <label for="filmrating">3.25 Stars</label>
                        </div>
                        <div class="vCardInfo">
                            <h2 class="txtWWW txt300">FILM TITLE…..</h2>
                            <p class=" txt30 txt300">This is an excerpt of the critique mauris at sollicitudin sapien. Nullam consequat leo et nibh egestas, in pulvinar diam fem, mauris at sollic itudin sapien. Nullam consequat leo et nibh egestas, in pulvinar….</p>
                        </div>
                        </a>
                    </div>
                </div>
                         
            </div>
        </div>
    </section>
    
    <section class="section68 ftr stucomm">
        <div class="container-fluid">
           <div class="brMore">
                    <div class="dropdown">
                      <span class="caret"></span>
                      <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        FILMS TO REVIEW
                      </button>
                       <span class="caret"></span>
                    </div>
               </div>
            <div class="dropDown">
                <div class="row">
                    <div class="col-sm-4">
                                <div class="dropdown">
        <?php $locations = DB::table('users')->select('location')->distinct()->get()->toArray(); //print_r($locations); ?>
            <select class="btn dropdown-toggle" name="location" onchange="locationFunction(this.value);">
                        <option value="">Select Location</option>
                        @foreach($locations as $location)
              <option value="{{$location->location}}">{{$location->location}}</option>
             @endforeach
                      </select>
          </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="dropdown">
<select class="btn dropdown-toggle"name="genre" onchange="jsFunction(this.value);">
                        <option value="">Genre</option>
                        <option value="g1">genre 1</option>
                        <option value="g2">genre 2</option>
                      </select>
            </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="dropdown col-white">
                            <input type="text" id="search" name="search" class="search-btn" placeholder="Search">
                            <span class="fa fa-search rotate45"></span></button>
                        </div>
                    </div>
                </div>
            </div>

                    <?php $allfilms = DB::table('films')->get()->count();
              if(isset($_REQUEST['genre'])){
                $films = DB::table('films')->where('genre','=',$_GET['genre'])->orderBy('most_likes','desc')->take(3)->get()->toArray(); 
              }
              elseif(isset($_REQUEST['location'])){
                $Users = DB::table('users')->select('id')->where('location','=',$_GET['location'])->get()->toArray();
                $users = array();
                foreach ($Users as $user) {
                  array_push($users, $user->id);
                }
                $films = DB::table('films')->whereIn('user_id',$users)->orderBy('most_likes','desc')->take(3)->get()->toArray();
              }
              elseif(isset($_REQUEST['search'])){
                $films = DB::table('films')->where('title','LIKE','%'.$_GET['search'].'%')->orWhere('biography','LIKE','%'.$_GET['search'].'%')->orWhere('team_credit','LIKE','%'.$_GET['search'].'%')->orderBy('most_likes','desc')->take(9)->get()->toArray();
                
              }
              else{
                $films = DB::table('films')->orderBy('most_likes','desc')->take(3)->get()->toArray();
              }
        ?>
        @if($films)
            <div class="commReviews">
            <?php
//* Get VIdeo Duration by ID
function vimeoVideoDuration($video_url) {

   $video_id = (int)substr(parse_url($video_url, PHP_URL_PATH), 1);

   $json_url = 'http://vimeo.com/api/v2/video/' . $video_id . '.xml';

   $ch = curl_init($json_url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_HEADER, 0);
   $data = curl_exec($ch);
   curl_close($ch);
   $data = new SimpleXmlElement($data, LIBXML_NOCDATA);

   if (!isset($data->video->duration)) {
       return null;
   }

   $duration = $data->video->duration;

   return $duration; // in seconds
}

?>
                  <div class="row" id="loadFilms">
                  @foreach($films as $film)
                <?php
                $vimeo = $film->video_link;
                $Videoduration = vimeoVideoDuration($vimeo);
                $arr = json_decode( json_encode($Videoduration) , 1);
                $arr[0];
                 
      
                  ?>
                <div class="col-md-4 col-sm-6">
                    <div class="vCard">
                       <a href="/videos/{{$film->vimeo_video_id}}">
                       @if(isset($film->video_thumbnail))
                        <img class="vCardImg" src="/uploads/{{$film->video_thumbnail}}" alt="">
                  @endif
                        <div class="vCardGradient"></div>
                        <div class="timer">
                            <p><?php echo gmdate("H:i:s", $arr[0]);?></p>
                        </div>
                        <div class="vCardInfo">
                            <h2>{{$film->title}}</h2>
                            <p>{{$film->biography}}</p>
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
                 <h3 class="text-center">Not found any films</h3>
               </div>
             </div>
          </div>
          @endif
            <div class="text-center" id="nextPreviousButton">
            @if($allfilms > 3)
                <a href="javascript:void(0)" id="filmLoadMore" class="s-mit">Load More</a>
            
          @endif  
          <input type='button' id='filmsPrev' class='btn pull-left btn-primary hide' value='Prev'>
          <input type='button' id='filmsNext' class='btn pull-right btn-primary hide' value='Next'>
            </div>
        </div>
    </section>

<script type="text/javascript">
    function jsFunction(value){
      window.location = '?genre='+value;
    }
    function locationFunction(value) {
      window.location = '?location='+value;
    }
    jQuery(document).ready( function(){
      jQuery("#search").focus( function(){
        jQuery("#search").keypress(function(e) {
          if(e.which == 13) {
              window.location = '?search='+jQuery(this).val();
          }
        });
      });
      

      // Films load more ajax with next and previous

      var initial_count = 1;
      jQuery("#filmLoadMore").click( function(){
        jQuery(this).removeClass("show").addClass("hide");
        jQuery("#filmsPrev").removeClass("hide").addClass("show");
        jQuery("#filmsNext").removeClass("hide").addClass("show");
        initial_count++;
        var total = 3*initial_count;
        jQuery.ajax({
          url: "/films/ajaxdata",
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
          url: "/films/ajaxdata",
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
        if(filmtotal < total){
          initial_count--;
          jQuery(this).removeClass("show").addClass("hide");
          jQuery("#filmLoadMore").removeClass("show").addClass("hide");
          jQuery("#filmsPrev").removeClass("hide").addClass("show");
        }else{
          
          jQuery.ajax({
            url: "/films/ajaxdata",
            type: "GET",
            data:{'total' : total},
            success: function(data){
              jQuery("#loadFilms").html(data);
            }
          });
        } 
      });


      
     
    });
  
</script>

@endsection
