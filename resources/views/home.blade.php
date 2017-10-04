@extends('layouts.layout')

@section('content')
@include('layouts.notification')

<!-- fetured film from films controller -->
<?php 
  use App\Http\Controllers\FilmsController;
  use App\Http\Controllers\ReviewsController;
  use App\Http\Controllers\UserController;
  $userss  = new UserController;
  $filmss = new FilmsController;
  $featuredFilm = $filmss->getFeaturedFilmInfo();
 ?>
<section class="featuredFilm">
        <div class="ffilm">
            <div class="row">
                <div class="col-md-6">
                    <div class="ffilmOuter">
                       <img src="/img/ffilm.png" alt="">
                        <div class="ffilmInner">
                            <h3 class="txt300 tac">FEATURED FILM</h3>
                            <div class="ffilmDetails">
                                <h3 class="txt300">{{$featuredFilm['featuredFilm'][0]['title']}}</h3>
                                <div class="vcardInfo2">
                                    <input id="kartik" name="filmrating" class="rating" data-stars="5" data-step="0.1" value="{{$featuredFilm['avgrating']}}" disabled title=""/>
                                    <label for="filmrating">{{count($featuredFilm['reviewsForThisFilm'])}} Reviews | Read Reviews</label>
                                </div>
                                <p><a href="/videos/{{$featuredFilm['featuredFilm'][0]['vimeo_video_id']}}">{{str_limit($featuredFilm['reviewsForThisFilm'][0]['description'],320,'...')}}</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 side-capture-right">
                    <div class="side-capture">
                  <a href="/videos/{{$featuredFilm['featuredFilm'][0]['vimeo_video_id']}}">
                  <img src="/uploads/{{$featuredFilm['featuredFilm'][0]['video_thumbnail']}}" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <div class="clearfix"></div>
    <!-- top 2 reviews from Reviews controller -->
    <?php 
        $reviewssss = new ReviewsController;
        $reviews = $reviewssss->getTopReviews(); 
    ?>
    <section class="topReviews">
        <div class="container-fluid">
            <div class="brMore">
                    <div class="dropdown">
                      <span class="fa fa-angle-down dropLeft"></span>
              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Top Reviews
              </button>
               <span class="fa fa-angle-down dropRight"></span>
                    </div>
               </div>
            <div class="topR">
                <div class="row">
                    @foreach($reviews as $review)
                      <?php 
                       /* method to fetch the film thumbnail */
                       $filmrating = unserialize($review->rate_elements)['filmrating'];
                       $film_thumbnail = $filmss->getFilmsThumbnailUsingID($review['film_id']);
                       ?>
                          <div class="col-sm-6">
                            <div class="vCard">
                               <a href="">
                                <img class="vCardImg" src="/uploads/{{$film_thumbnail}}" alt="">
                                <div class="vCardGradient"></div>
                                <div class="vcardInfo2">
                                    <input id="kartik" name="filmrating" class="rating" data-stars="5" data-step="0.1" value="{{$filmrating}}" disabled title=""/>
                                    <label for="filmrating">{{$filmrating}} Stars</label>
                                </div>
                                <div class="vCardInfo">
                                    <h2>{{str_limit($review->title, 15, '...')}}</h2>
                                    <p>{{str_limit($review->description, 320, '...')}}</p>
                                    <p class="stuName">
                                        <a href="">{{$reviewssss->getReviewUserName($review->user_id)}}</a> | <a href="">{{date('M d, Y', strtotime($review->created_at))}}</a>
                                    </p>
                                </div>
                                @if(Auth::user())
                                  <?php 
                                   $helpfulReview = array();
                                   $helpfulReviewCount = 0;
                                   if($review->helpfullreview != ''){
                                      $helpfulReview = unserialize($review->helpfullreview); 
                                      $helpfulReviewCount = count($helpfulReview);
                                   }
                                    $helpfulClass = '';
                                    if(in_array(Auth::user()->id, $helpfulReview)){
                                      $helpfulClass = 'active';
                                    }
                                  ?>
                                  @if($helpfulReviewCount >= 1 && $helpfulClass == 'active')
                                  <div class="helpful {{$helpfulClass}}">
                                      <a href="javascript:void(0)">{{$helpfulReviewCount}} <i class="fa fa-thumbs-up"></i></a> 
                                  </div>
                                  @elseif($helpfulReviewCount >= 1)
                                    <div class="helpful notLogged">
                                      <a href="/review/helpful/{{$review->id}}">{{$helpfulReviewCount}} <i class="fa fa-thumbs-up"></i></a> 
                                    </div>
                                  @else
                                    <div class="helpful {{$helpfulClass}}">
                                      <a href="/review/helpful/{{$review->id}}">Helpful?</a>
                                    </div>
                                  @endif
                                @else
                                <?php
                                     $helpfulReview = array();
                                     $helpfulReviewCount = 0;
                                     if($review->helpfullreview != ''){
                                        $helpfulReview = unserialize($review->helpfullreview); 
                                        $helpfulReviewCount = count($helpfulReview);
                                     }
                                 ?>
                                  <div class="helpful notLogged">
                                      <a href="javascript:void(0)">{{$helpfulReviewCount}} <i class="fa fa-thumbs-up"></i></a> 
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
    
   
    <section class="section00">
        <div class="container-fluid">
            <div class="brMore">
            <div class="dropdown">
              <span class="fa fa-angle-down dropLeft"></span>
              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Hottest Films
              </button>
               <span class="fa fa-angle-down dropRight"></span>
              
            </div>
        </div>
        </div>
 
        <?php $randomFilm = $filmss->getHomeHottestFilm();  ?>
           <div class="hottestFilm">
               <iframe id="hottestFilmFrame" src="https://player.vimeo.com/video/{{$randomFilm[0]['vimeo_video_id']}}?title=0&byline=0&portrait=0&badge=0&autopause=0&player_id=0&toolbar=0" width="100%" height="480px" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
              <div class="playOverlay">
                <div class="playBtn">
                  <a href="javascript:void(0){return false;}" id="playbtn"><img src="/img/playbtn.png" alt=""></a>
                </div>
            </div>
            </div>
    </section>
    <?php 
        /* fetch those films who has more than five reviews  */
        $films = $filmss->getFilmsWithMoreThanFiveReviews();
        $allfilms = $filmss->countAllFilms();

    ?>
    <section class="filmsSlide">
        <div class="slideinner3">
            <div class="owl-carousel f-slide owl-theme">
                @foreach($films as $film)
                <?php 
                    /* fetch reviews using film id */
                    $reviewsForThisFilm = $reviewssss->getReviewUsingFilmID($film['id']);
                    /* to fetch avg rating reviews */
                    $avgrating = $reviewssss->getAvgReviewsRating($reviewsForThisFilm);
                   ?>
                    <div class="item">
                        <div class="vCard">
                           <a href="/videos/{{$film['vimeo_video_id']}}">
                            <img class="vCardImg" src="/uploads/{{$film['video_thumbnail']}}" alt="">
                            <div class="vCardGradient"></div>
                            <div class="timer">
                                <!-- <p>{{$film['duration']}}</p> -->
                            </div>
                            <div class="vcardInfo2">
                                <input id="kartik" name="filmrating" class="rating" data-stars="5" data-step="0.1" value="{{$avgrating}}" disabled title=""/>
                                    <label for="filmrating">{{number_format($avgrating, 1)}} Stars</label>
                            </div>
                            <div class="vCardInfo">
                                <h2 class="txtWWW txt300">{{str_limit($film['title'], 10, '...')}}</h2>
                                <p class=" txt30 txt300">{{str_limit($film['biography'],175,'...')}}</p>
                            </div>
                            </a>
                        </div>
                    </div>
                @endforeach    
            </div>
        </div>
    </section>
    
    <section class="section68 ftr stucomm">
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
                            <?php 
                              /* fetch all the locations fron user table  */
                              $locations = $userss->getAllUsersLocations();  
                            ?>
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
                           <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">Select Genre
                            </button>
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
                             <input type="text" name="search" class="search-btn" id="search" placeholder="Search Any films..">
                            <span class="fa fa-search rotate45"></span>

                        </div>
                    </div>
                </div>
            </div>
            @if($films)
              <div id="movieReview">
                  <div class="row" id="loadFilms">
                      @foreach($films as $film)
                        <div class="col-md-4 col-sm-6">
                          <div class="vCard vCard2">
                              <a href="/videos/{{$film['vimeo_video_id']}}">
                                  <img class="vCardImg" src="/uploads/{{$film['video_thumbnail']}}" alt="">
                                  <div class="vCardGradient"></div>
                                  <div class="timer">
                                     <!--  <p>{{$film['duration']}}</p> -->
                                  </div>
                                  <div class="vCardInfo">
                                      <h2 class="txtWWW txt300">{{str_limit($film['title'], 15, '...')}}</h2>
                                      <p class=" txt30 txt300">{{str_limit($film['biography'], 175, '...')}}</p>
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
            <div class="text-center">
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

    <script type="text/javascript">
    function jsFunction(value){
      window.location = '?genre='+value;
    }
    function locationFunction(value) {
      window.location = '?location='+value;
    }
   //* ajax script for cast and crew

        jQuery("#search").keyup(function(e) {
        
        jQuery("#filmLoadMore").addClass('hide');
        var search = jQuery(this).val();
        console.log(search);
        jQuery.ajax({
          url: "/search/films",
          type: "GET",
          data:{'search' : search},
          success: function(data){
            //console.log(data);
            jQuery("#loadFilms").html(data);
          }
        });
      });

      jQuery('#playbtn').click( function(){
        jQuery(this).hide();
        jQuery(".filmsSlide").css('top', '-65px');
        jQuery(".brMore").addClass("brmoreclicked");
        jQuery(".brMore.brmoreclicked").css("margin-top","30px");
        jQuery(".stucomm").css('margin-top', '-70px');
        jQuery(".hottestFilm .playOverlay").css('height','0px');
        jQuery("#hottestFilmFrame").attr('src',(jQuery("#hottestFilmFrame").attr('src')+'&autoplay=1'));
      });
      
      jQuery("#genreAjax li a").click( function(){
        jQuery("#genreAjax button").text(jQuery(this).text());
        jQuery("#filmLoadMore").addClass('hide');
        var genre = jQuery(this).attr("data-value");
        jQuery.ajax({
          url: "/search/films",
          type: "GET",
          data:{'genre' : genre},
          success: function(data){
            jQuery("#loadFilms").html(data);
          }
        });
      });

      jQuery("#locationAjax li a").click( function(){
        jQuery("#locationAjax button").text(jQuery(this).text());
        jQuery("#filmLoadMore").addClass('hide');
        var location = jQuery(this).attr("data-value");
        jQuery.ajax({
          url: "/search/films",
          type: "GET",
          data:{'location' : location},
          success: function(data){
            jQuery("#loadFilms").html(data);
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
</script>
@endsection
