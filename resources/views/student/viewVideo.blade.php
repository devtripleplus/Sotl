  @extends('layouts.layout')


  @section('content')


 @include('layouts.notification')

<?php 
use Carbon\Carbon; 
use App\Http\Controllers\FilmsController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SiteSettingsController;
$filmss = new FilmsController;
$reviewssss = new ReviewsController;
$userss = new UserController;
$allfilms = $filmss->countAllFilms();
$sitesettings = new SiteSettingsController;
$settings = $sitesettings->getSettingsData();

if(!Auth::user()){
  $film_id = $film[0]['id'];
}
else{
  $film_id = $film[0]['id'];
}
 ?>


  @if($film)

    <section class="rBanner">
        @if(isset($_GET['autoplay']) && $_GET['autoplay'] == 1)
          <iframe id="hottestFilmFrame" src="https://player.vimeo.com/video/{{$film[0]['vimeo_video_id']}}?title=0&byline=0&portrait=0&badge=0&autopause=0&player_id=0&toolbar=0&autoplay={{$_GET['autoplay']}}" width="100%" height="480px" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
        @else
          <iframe id="hottestFilmFrame" src="https://player.vimeo.com/video/{{$film[0]['vimeo_video_id']}}?title=0&byline=0&portrait=0&badge=0&autopause=0&player_id=0&toolbar=0" width="100%" height="480px" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
        @endif    
        <div class="playOverlay">
          <div class="playBtn">
            <a href="javascript:void(0){return false;}" id="playbtn"><img src="/img/playbtn.png" alt=""></a>
          </div>
        </div>
     
    </section>
    <div class="">
  

    </div>


    <?php 
          /* fetch all reviews for current film id */
          $reviewsForThisFilm = $reviewssss->getReviewUsingFilmID($film[0]['id']);
          /*  fetch avg rating reviews for this film using all the review on this film  */
          $avgrating = $reviewssss->getAvgReviewsRating($reviewsForThisFilm);
          
          $teamcreditss = unserialize($film[0]['team_credit']);
          if(count($reviewsForThisFilm) >= 1){
            $reviewFotThisFilm = str_limit($reviewsForThisFilm[0]['description'],350,'...');
          }
          else{
            $reviewFotThisFilm = '';
          }
          /*  fetch heat score of each category of this films from the reviews given on this film   */
          $heatScores = $reviewssss->getEachCategoryHeatScoreForThisFilm($film[0]['id']);

      ?>

    <section class="filmDetails">
        <div class="container-fluid">
           <div class="row">
               <div class="col-sm-9">
                <div class="headings">
                   
                       
                    <h2 class="txtWWW txt300">{{$film[0]['title']}}</h2>
                </div>
                @if( isset($_REQUEST['view']) && $_GET['view'] == 'screening' )
                @else
                <div class="sRatings">
                    <input id="kartik" name="filmrating" class="rating" data-stars="5" data-step="0.1" value="{{$avgrating}}" disabled title=""/>
                    <div class="vRatings">
                        <p>{{count($reviewsForThisFilm)}} Reviews <span></span> Read Reviews</p>
                    </div>
                </div>
                @endif
                <p class="fDetailsPara">{{str_limit($reviewFotThisFilm,380,'...')}}</p>
                 </div>
              @if(Auth::user())   
              <?php 
                if($film[0]['likes'] != '' ){
                  $likes = unserialize($film[0]['likes']); 
                }
                else{
                  $likes = array(); 
                }
                if($film[0]['most_likes'] != '' ){
                  $most_likes = unserialize($film[0]['most_likes']); 
                }
                else{
                  $most_likes = array(); 
                }
               
                if(in_array(Auth::user()->id,$likes)){
                  $likeThumbClass = 'active';
                  $mostlikeThumbClass = '';
                  $likeThumbIcon = 'like-btn-2.png';
                  $mostlikeThumbIcon = 'like-btn.png';
                }
                elseif (in_array(Auth::user()->id, $most_likes)) {
                  $likeThumbClass = '';
                  $mostlikeThumbClass = 'active';
                  $likeThumbIcon = 'like-btn.png';
                  $mostlikeThumbIcon = 'like-btn-2.png';
                }
                else{
                  $likeThumbClass = '';
                  $mostlikeThumbClass = '';
                  $likeThumbIcon = 'like-btn.png';
                  $mostlikeThumbIcon = 'like-btn.png';
                }
               ?>
                <div class="col-sm-3">
                    <div class="likeBtns">
                        <a class="like {{$likeThumbClass}}" href="/video/likes/{{$film[0]['id']}}">
                            <img src="/img/{{$likeThumbIcon}}" alt="">
                            <span>
                                <?php if($film[0]['likes'] == '')
                                         echo "0";
                                      else
                                         echo count(unserialize($film[0]['likes']));
                                 ?>
                            </span>
                        </a>
                        <a class="like superlike {{$mostlikeThumbClass}}" href="/video/mostlikes/{{$film[0]['id']}}">
                            <img src="/img/{{$mostlikeThumbIcon}}" alt=""><img src="/img/{{$mostlikeThumbIcon}}" alt="">
                            <span>
                                <?php if($film[0]['most_likes'] == '')
                                          echo "0";
                                       else
                                          echo count(unserialize($film[0]['most_likes']));
                                 ?>
                            </span>
                        </a>
                    </div>
                </div>
              @else

                <div class="col-sm-3">
                    <div class="likeBtns likeBtns2">
                        <a class="like getsignPopUp" data-toggle="modal" data-target="#myModal" href="javascript:void(0)">
                           <img src="/img/like-btn.png" alt="">
                            <span>
                            
                                <?php if($film[0]['likes'] == '')
                                         echo "0";
                                      else
                                         echo count(unserialize($film[0]['likes']));
                                 ?>
                            </span>
                        </a>
                        <a class="like superlike superlike2  getsignPopUp" data-toggle="modal" data-target="#myModal" href="javascript:void(0)">
                            <img src="/img/like-btn.png" alt=""><img src="/img/like-btn.png" alt="">
                            <span>
                          
                                <?php if($film[0]['most_likes'] == '')
                                          echo "0";
                                       else
                                          echo count(unserialize($film[0]['most_likes']));
                                 ?>
                            </span>
                        </a>
                        
                    </div>
                </div>
              @endif  
            </div>
        </div>
    </section>

  
    @if(!Auth::user() || ( Auth::user() && (count(DB::table('reviews')->where([['user_id', '=', Auth::user()->id],['film_id', '=', $film[0]['id']]])->get()->toArray()) == 1 && !isset($_REQUEST['view']))) || (Auth::user() && Auth::user()->role == 'fans'))
        <section class="section68 ftr ftr-cast">
              <div class="container-fluid">
                  <div class="brMore">
                          <div class="dropdown">
                            <span class="fa fa-angle-down dropLeft"></span>
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                              Cast & Crew
                            </button>
                             <span class="fa fa-angle-down dropRight"></span>
                          </div>
                     </div>
                  <div class="castCrew">
                      <div class="row">
                          @if($teamcreditss)
                              <?php $i = 0; ?>
                              @foreach($teamcreditss as $team_credits)
                              <?php $j = 0; ?>
                                @foreach($team_credits as $key => $teanmcredit)
                                  <?php $j++; ?>
                                  @if($j < 2)
                                    <div class="col-md-2 col-sm-4">
                                      <div class="castBox">
                                          <div class="cBox-details">
                                              <h4 >{{$key}}</h4>
                                              @if($teanmcredit)
                                                @foreach($teanmcredit as $value)
                                                  <p>{{$value}}</p>
                                                @endforeach
                                              @endif  
                                             <!-- <img src="/img/badge.png" alt=""> -->
                                             <div class="heatBadges">
                                               <input id="kartik" name="filmrating" class="rating" data-stars="1" data-step="1" value="10" title="" disabled />
                                               <span class="text-center">{{number_format($heatScores[$i]*2,1)}}</span>
                                             </div>
                                          </div>
                                      </div>
                                    </div> 
                                  @endif 
                                @endforeach 
                                <?php $i++; ?> 
                              @endforeach  
                          @endif   
                      </div>
                    </div>
                 </div>
          </section>


    @endif

     
<?php 
if(Auth::user() && (Auth::user()->role == 'student' || Auth::user()->role == 'admin')){
  /* fetch current logged in users review data usig user id and film id */
  $reviewdata = $reviewssss->getCurrentLoggedINUsersReview($film[0]->id); 
  if(!empty($reviewdata))
  $reviewelements = unserialize($reviewdata[0]['rate_elements']);
  $film_id = $film[0]['id'];
}
?>
  <?php if(Auth::user() && Auth::user()->id != $film[0]['user_id']){ ?>
    
      @if(isset($_REQUEST['show']) && Auth::user())
      <div class="md-col-12" style="margin-bottom: 40px">
        <a href="/videos/{{$film[0]['vimeo_video_id']}}/?show=reviews" class="text-center" style="display: block;">Read Reviews</a>
      </div>
      @endif
    

    @if(Auth::user() && (!(Auth::user()->role == 'non-student'|| Auth::user()->role == 'fans')))
   
      @if(!DB::table('reviews')->where([['user_id', '=', Auth::user()->id],['film_id', '=', $film[0]['id']]])->get()->toArray())
           
          <section class="reviewEditor">
              <div class="container-fluid">
                  <div class="brMore">
                          <div class="dropdown">
                            <span class="fa fa-angle-down dropLeft"></span>
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                              Read Reviews
                            </button>
                             <span class="fa fa-angle-down dropRight"></span>
                          </div>
                     </div>
                  <div class="reviewBox box2" style="background-image: url('/uploads/{{$film[0]['video_thumbnail']}}');">
                      <div class="reviewInner">
                          <h3 class="txt300">WRITE A REVIEW</h3>
                          <p class="f22">Mauris at sollicitudin sapien. Nullam consequat leo et nibh egestas, in pulvinar diam fermentum. Aenean at aliquet nulla, ac consequat lacus. Sed mattis at ex at aliquam. Mauris vel eros ut justo vehicula sollicitudin eu nec nibh. Aenean interdum ornare eleifend. Maecenas vel pretium nibh, et auctor mauris.</p>
                          <div class="reviewSliders">
                              <div class="row">
                                <form method="POST" action="/video/review/{{$film[0]['id']}}">
                                  {{ csrf_field() }}
                                  <div class="col-md-5 sliderPoints">
                                      <div class="row">
                                          <div class="col-sm-5">
                                              <p>WRITER</p>
                                          </div>
                                          <div class="col-sm-7">
                                              <div class="range-slider">
                                                  <input class="range-slider__range rangeslider" type="range" name="writer" value="0" min="0" max="5">
                                                  <span class="range-slider__value">0</span>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-sm-5">
                                              <p>DIRECTOR</p>
                                          </div>
                                          <div class="col-sm-7">
                                              <div class="range-slider">
                                                  <input class="range-slider__range rangeslider" type="range" name="director" value="0" min="0" max="5">
                                                  <span class="range-slider__value">0</span>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-sm-5">
                                              <p>EDITOR</p>
                                          </div>
                                          <div class="col-sm-7">
                                              <div class="range-slider">
                                                  <input class="range-slider__range rangeslider" type="range" name="editor" value="0" min="0" max="5">
                                                  <span class="range-slider__value">0</span>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-sm-5">
                                              <p>CINEMATOGRAPHY</p>
                                          </div>
                                          <div class="col-sm-7">
                                              <div class="range-slider">
                                                  <input class="range-slider__range rangeslider" type="range" name="cinematography" value="0" min="0" max="5">
                                                  <span class="range-slider__value">0</span>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-sm-5">
                                              <p>ACTING</p>
                                          </div>
                                          <div class="col-sm-7">
                                              <div class="range-slider">
                                                  <input class="range-slider__range rangeslider" type="range" name="acting" value="0" min="0" max="5">
                                                  <span class="range-slider__value">0</span>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-sm-5">
                                              <p>PRODUCER</p>
                                          </div>
                                          <div class="col-sm-7">
                                              <div class="range-slider">
                                                  <input type="hidden" name="producer" value="">
                                                  <input class="range-slider__range rangeslider" type="range" id="producer2" disabled min="0" max="5" name="producer" value="0">
                                                  <span class="range-slider__value producerValue">0</span>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="row lastRating">
                                          <div class="col-sm-5">
                                              <p class="mt08">FILM RATING</p>
                                          </div>
                                          <div class="col-sm-7">
                                              <input id="kartik" name="filmrating" class="rating" data-stars="5" data-step="0.1" value="0" title=""/>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-7">
                                      <div class="reviewTitle1 ">
                                          <div class="reviewInput">
                                              <input type="text" name="title" placeholder="Review Title">
                                              <textarea id="field" id="reviewdescription" name="description" onkeyup="countChar(this)" placeholder="I think this film........."></textarea>
                                              <div id="charNum"></div>
                                          </div>
                                          <div class="editButton reviewEditbtn">
                                              <button class="s-mit">Submit Review</button>
                                          </div>
                                      </div>
                                  </div>
                                </form>  
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </section>
      @else
            <section class="reviewEditor">
                <div class="container-fluid">
                    <div class="brMore">
                            <div class="dropdown">
                              <span class="fa fa-angle-down dropLeft"></span>
                              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                Read Reviews
                              </button>
                               <span class="fa fa-angle-down dropRight"></span>
                            </div>
                       </div>
                    <div class="reviewBox box1" style="background-image: url('/uploads/{{$film[0]['video_thumbnail']}}');">
                        <div class="reviewInner">
                            <h3 class="txt300">YOUR REVIEW</h3>
                            <p class="f22">Mauris at sollicitudin sapien. Nullam consequat leo et nibh egestas, in pulvinar diam fermentum. Aenean at aliquet nulla, ac consequat lacus. Sed mattis at ex at aliquam. Mauris vel eros ut justo vehicula sollicitudin eu nec nibh. Aenean interdum ornare eleifend. Maecenas vel pretium nibh, et auctor mauris.</p>
                            <div class="reviewSliders">
                                <div class="row">
                                  <form method="POST" action="/review/update/{{$reviewdata[0]['id']}}">
                                  {{ csrf_field() }}
                                    <div class="col-md-5 sliderPoints">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <p>WRITER</p>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="range-slider">
                                                    <input class="range-slider__range" type="range" disabled value="{{$reviewelements['writer']}}" min="0" max="5">
                                                    <span class="range-slider__value">{{$reviewelements['writer']}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <p>DIRECTOR</p>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="range-slider">
                                                    <input class="range-slider__range" disabled type="range" value="{{$reviewelements['director']}}" min="0" max="5">
                                                    <span class="range-slider__value">{{$reviewelements['director']}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <p>EDITOR</p>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="range-slider">
                                                    <input class="range-slider__range" disabled type="range" value="{{$reviewelements['editor']}}" min="0" max="5">
                                                    <span class="range-slider__value">{{$reviewelements['editor']}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <p>CINEMATOGRAPHY</p>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="range-slider">
                                                    <input class="range-slider__range" disabled type="range" value="{{$reviewelements['cinematography']}}" min="0" max="5">
                                                    <span class="range-slider__value">{{$reviewelements['cinematography']}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <p>ACTING</p>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="range-slider">
                                                    <input class="range-slider__range" disabled type="range" value="{{$reviewelements['acting']}}" min="0" max="5">
                                                    <span class="range-slider__value">{{$reviewelements['acting']}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <p>PRODUCER</p>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="range-slider">
                                                    <input class="range-slider__range" disabled type="range" value="{{$reviewelements['producer']}}" min="0" max="5">
                                                    <span class="range-slider__value">{{$reviewelements['producer']}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row lastRating">
                                            <div class="col-sm-5">
                                                <p class="mt08">FILM RATING</p>
                                            </div>
                                            <div class="col-sm-7">
                                                <input id="kartik" disabled name="filmrating" class="rating" data-stars="5" data-step="0.1" value="{{$reviewelements['filmrating']}}" title=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <?php   
                                      $reviewDate =  Carbon::parse($reviewdata[0]['created_at']);
                                      $today = Carbon::now('Asia/Kolkata')->addHours(5);
                                      $totalDuration = $reviewDate->diffInHours($today);
                                    ?>
                                    @if( $totalDuration <= 48 ) 
                                      @if(isset($_REQUEST['value']) && $_GET['value'] == 'edit') 
                                        <div class="col-md-7">
                                            <div class="reviewTitle1 ">
                                                <div class="reviewInput">
                                                    <input type="text" name="title" value="{{$reviewdata[0]['title']}}">
                                                    <textarea id="field" id="reviewdescription" name="description" onkeyup="countChar(this)" >{{$reviewdata[0]['description']}}</textarea>
                                                    <div id="charNum"></div>
                                                </div>
                                                <div class="editButton reviewEditbtn">
                                                    <button type="submit" class="s-mit">Update Review</button>
                                                </div>
                                            </div>
                                        </div> 
                                      @else  
                                      
                                      <div class="col-md-7">
                                          <div class="reviewTitle1">
                                              <h3 class="txt300">{{$reviewdata[0]['title']}}</h3>
                                              <p class="ltext fs20">{{Auth::user()->name}} | {{date('M d, Y', strtotime($reviewdata[0]['created_at']))}}</p>
                                              <p class="ltext">
                                                 {{$reviewdata[0]['description']}}
                                              </p>
                                               <div class="editButton">
                                                  <a href="/videos/{{$film[0]['vimeo_video_id']}}/?value=edit" class="s-mit">Edit Your Review</a> 
                                              </div>
                                          </div>
                                      </div>
                                     @endif 
                                    @else
                                      <div class="col-md-7">
                                          <div class="reviewTitle1">
                                              <h3 class="txt300">{{$reviewdata[0]['title']}}</h3>
                                              <p class="ltext fs20">{{Auth::user()->name}} | {{date('M d, Y', strtotime($reviewdata[0]['created_at']))}}</p>
                                              <p class="ltext">
                                                 {{$reviewdata[0]['description']}}
                                              </p>
                                          </div>
                                      </div>
                                    @endif
                                  </form>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> 
                  
      @endif     
    @endif
  <?php } ?>
@endif


   @if(!Auth::user() || (Auth::user() && Auth::user()->role == 'fans'))

        <?php 
          /*   fetch top 2 reviews on this film using film id ordered by mosthelpful  */
          $reviews = $reviewssss->getTopReviewsONFilm($film[0]['id']); 
        ?>
        
        @if(!empty($reviews->toArray()) && count($reviews->toArray()) >= 2)

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
                              <?php $filmrating = unserialize($review['rate_elements'])['filmrating']; 
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
                                            <h2>{{str_limit($review['title'], 15, '...')}}</h2>
                                            <p>{{str_limit($review['description'], 320, '...')}}</p>
                                            <p class="stuName">
                                                <a href="">{{$reviewssss->getReviewUserName($review['user_id'])}}</a> | <a href="">{{date('M d, Y', strtotime($review['created_at']))}}</a>
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
      @endif    
    @endif  

   <?php 
         /* Logged In user review on this film */
         if(Auth::user()){
          $reviewBycurr = $reviewssss->getCurrentLoggedINUsersReview($film_id);
         }
        $allreview = count($reviewssss->getReviewUsingFilmID($film_id));
   ?>
   @if((Auth::user() && count($reviewBycurr) == 1 && !isset($_REQUEST['view'])) || (Auth::user() && count($reviewBycurr) != 1 && !isset($_REQUEST['view'])) || !Auth::user())
        <?php 
          $reviews = DB::table('reviews')->where('film_id','=',$film[0]['id'])->orderBy('helpfullreviewcount', 'desc')->take(3)->get(); 
          $allreview = count($reviewssss->getReviewUsingFilmID($film_id));
        ?>
        
        
            <section class="commReviews">
                <div class="container-fluid">
                  @if(!empty($reviews->toArray())) 
                    <div class="brMore">
                            <div class="dropdown">
                              <span class="fa fa-angle-down dropLeft"></span>
                              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                Community Reviews
                              </button>
                               <span class="fa fa-angle-down dropRight"></span>
                            </div>
                    </div>
                    <div class="dropDown">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">FILTER
                            <span class="fa fa-angle-down dropBottom"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Select</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="row" id="loadReviews">

                        @foreach($reviews as $review)
                          <div class="col-md-4 col-sm-6">
                             <div class="vCard">
                              <?php 
                                $filmrating = unserialize($review->rate_elements)['filmrating']; 
                                $film_thumbnail = $filmss->getFilmsThumbnailUsingID($review->film_id);
                              ?>
                               <a href="javascript:void(0)">
                                  <img class="vCardImg" src="/uploads/{{$film_thumbnail}}" alt="">
                                  <div class="vCardGradient"></div>
                                  <div class="vcardInfo2">
                                      <input id="kartik" name="filmrating" class="rating" data-stars="5" data-step="0.1" value="{{$filmrating}}" disabled title=""/>
                                      <label for="filmrating">{{$filmrating}} Stars</label>
                                  </div>
                                  <div class="vCardInfo">
                                      <h2>{{str_limit($review->title, 15, '...')}}</h2>
                                      <p>{{str_limit($review->description, 125, '...')}}</p>
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
                    
                    @if($allreview > 3)
                        <div class="text-center">
                            <button id="reviewLoadMore" class="s-mit pull-center">Load More</button>
                            <button id="reviewsPrev" class="hide s-mit pull-left">Prev</button>
                            <button id="reviewsNext" class="hide s-mit pull-right">Next</button>
                        </div>
                       
                    @endif    
                  @else
                      <div id="nwAva">
                        <div class="container-fluid">
                           <div class="row">
                             <h3 class="text-center txtWWW txt300">No reviews found</h3>
                           </div>
                         </div>
                      </div>  
                  @endif 

                </div>
            </section>
          
   @endif

    <din class="clear-fix"></din>

    @if(Auth::user())
       <?php 

       // films uploaded by current logged in user
       $reviewddd = $reviewssss->getCurrentLoggedINUsersReview($film_id);  ?>
     @if( (count($reviewddd) == 1 && (isset($_REQUEST['view']) && $_REQUEST['view'] == 'screening')) || (count($reviewddd) != 1 && (isset($_REQUEST['view']) && $_REQUEST['view'] == 'screening')))

      <section class="pad125">
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
                        <div class="dropdown">
                            <?php $locations = $userss->getAllUsersLocations(); ?>
                            <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">Select Location
                            <span class="fa fa-angle-down dropBottom"></span></button>
                            <ul class="dropdown-menu">
                            <li><a href="javascript:void(0)">Select Location</a></li>
                                 @foreach($locations as $location)
                                   <li><a href="?view=screening&location={{$location['location']}}">{{$location['location']}}</a></li>
                                 @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="dropdown">
                          <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">Select Genre
                          <span class="fa fa-angle-down dropBottom"></span></button>
                          <ul class="dropdown-menu">
                              <li><a href="javascript:void(0)" data-value="">Select Genre</a></li>
                              <li><a href="?view=screening&genre=g1">Genre 1</a></li>
                              <li><a href="?view=screening&genre=g2">Genre 2</a></li>
                              <li><a href="?view=screening&genre=g3">Genre 3</a></li>
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

            <?php 
                /* fetch those films who has more than five reviews  */
                $films = $filmss->getFilmsWithMoreThanFiveReviews();
                $allfilms = $filmss->countAllFilms();
            ?>
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
                                      <!-- <p>{{$film['duration']}}</p> -->
                                  </div>
                                  <div class="vCardInfo">
                                      <h2 class="txtWWW txt300">{{str_limit($film['title'], 15, '...')}}</h2>
                                      <p class=" txt30 txt300">{{str_limit($film['biography'], 280, '...')}}</p>
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
            <div class="text-center">
                 @if($films > 3)
                    <div class="text-center hfhf">
                        <button id="filmLoadMore" class="s-mit pull-center">Load More</button>
                        <button id="filmsPrev" class="hide s-mit pull-left">Prev</button>
                        <button id="filmsNext" class="hide s-mit pull-right">Next</button>
                    </div>
                  @endif    
            </div>
          </div>
      </section>
    @endif 
  @endif 

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="background-color: #000000">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <h5 class="txtWWW txt300 text-center">Only registered users can leave Thumbs Up. Create your account now!</h5>
        <div class="text-center">
          <a href="{{$settings['wp_url']}}/wp-login.php" class="s-mit2">Login Here</a>
          <a href="{{$settings['wp_url']}}/wp-login.php?action=register" class="s-mit2">Register Here</a>
        </div>
      </div>
      
    </div>

  </div>
</div>


<script type="text/javascript">



    function jsFunction(value){
      var viewQuerystring = '<?php if(isset($_REQUEST['view'])) echo $_REQUEST['view'];?>';
      if(viewQuerystring)
      window.location = '?view='+ viewQuerystring +'&genre='+value;
    }
    function locationFunction(value) {
      var viewQuerystring = '<?php if(isset($_REQUEST['view'])) echo $_REQUEST['view'];?>';
      if(viewQuerystring)
      window.location = '?view='+ viewQuerystring +'&location='+value;
    }
    jQuery(document).ready( function(){
      jQuery("#search").focus( function(){
        jQuery("#search").keypress(function(e) {
          if(e.which == 13) {
              var viewQuerystring = '<?php if(isset($_REQUEST['view'])) echo $_REQUEST['view'];?>';
              if(viewQuerystring)
              window.location = '?view='+ viewQuerystring +'&search='+jQuery(this).val();
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
            console.log(data);
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


      // Review load more ajax with next and previous

     var film_id = '<?php echo $film_id; ?>';
      var init_count = 1;
      jQuery("#reviewLoadMore").click( function(){
        jQuery(this).removeClass("show").addClass("hide");
        jQuery("#reviewsNext").removeClass("hide").addClass("show");
        jQuery("#reviewsPrev").removeClass("hide").addClass("show");
        init_count++;
        var total = 3*init_count;
        console.log(total);
        var allreview = '<?php echo $allreview; ?>';
        console.log((parseInt(total, 10) - parseInt(allreview, 10))%3);
        if((parseInt(total, 10) - parseInt(allreview, 10))%3 > 3){
           jQuery("#reviewsNext").removeClass("show").addClass("hide");
        }
        jQuery.ajax({
          url: "/reviews/ajaxdata",
          type: "GET",
          data:{'total' : total, 'film_id' : film_id},
          success: function(data){
            //var res = data.replace('src="/js/star-rating.js', "");
            jQuery("#loadReviews").html(data);
          }
        });
      });
      jQuery("#reviewsPrev").click( function(){
        init_count--;

       var total = 3*init_count;
        if(total==3){
          jQuery(this).removeClass("show").addClass("hide");
          jQuery("#reviewLoadMore").removeClass("hide").addClass("show");
          jQuery("#reviewsNext").removeClass("show").addClass("hide");
        }
        jQuery.ajax({
          url: "/reviews/ajaxdata",
          type: "GET",
          data:{'total' : total, 'film_id' : film_id},
          success: function(data){
            //var res = data.replace('src="/js/star-rating.js', "");
            jQuery("#loadReviews").html(data);
          }
        });
      });
      jQuery("#reviewsNext").click( function(){
        init_count++;
        var total = 3*init_count;
        if(parseInt(total, 10) > 12){
              console.log(total);
        }
        var allreview = '<?php echo $allreview; ?>';
        allreview = parseInt(allreview, 10);
        console.log(allreview+" "+total+" "+(parseInt(allreview, 10) - parseInt(total, 10)));
        if((parseInt(allreview, 10) - parseInt(total, 10))%3 < -2){
          init_count--;
          jQuery(this).removeClass("show").addClass("hide");
          jQuery("#reviewLoadMore").removeClass("show").addClass("hide");
          jQuery("#reviewsPrev").removeClass("hide").addClass("show");
        }else{

         if((parseInt(allreview, 10) - parseInt(total, 10)) < 0){
            jQuery(this).removeClass("show").addClass("hide");
          }
          console.log(total);

         jQuery.ajax({
            url: "/reviews/ajaxdata",
            type: "GET",
            data:{'total' : total, 'film_id' : film_id},
            success: function(data){
              //var res = data.replace('src="/js/star-rating.js', "");
              jQuery("#loadReviews").html(data);
            }
          });
        }
      });
    
    });

   jQuery('#playbtn').click( function(){
        jQuery(this).hide();
        jQuery(".filmsSlide").css('top', '-65px');
        jQuery(".stucomm").css('margin-top', '-20px');
        jQuery(".rBanner .playOverlay").css('height','0px');
        jQuery("#hottestFilmFrame").attr('src',(jQuery("#hottestFilmFrame").attr('src')+'&autoplay=1'));
    });
      
  
</script>



@endsection




