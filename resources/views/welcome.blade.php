@extends('layouts.layout')


@section('content')
<section>
    <div id="banner001">
        <div><img src="/img/imgBnr01.png" alt=""></div>
    </div>
</section>
<section>
    <div id="carousel3Img">

         <div id="owl-carousel4-img" class="owl-carousel owl-theme">
            <?php $films = DB::table('films')->orderBy('most_likes','desc')->take(8)->get()->toArray();  ?>
            @foreach($films as $film)
                <div class="item">
                    <div class="vCard">
                        <a href="/videos/{{$film->vimeo_video_id}}">
                        <!-- <iframe class="vCardVideo" src="https://player.vimeo.com/video/194163144" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>                      -->
                         <img class="vCardImg" src="/uploads/{{$film->video_thumbnail}}" alt="">   
                        <div class="vCardGradient"></div>
                        <div class="vCardInfo vCardInfo22">
                            <h5 class="txtWWW txt300 text-uppercase">{{str_limit($film->title, 15, '...')}}</h5>
                            <p class="txtGGG txt16 txt300 text-uppercase">{{$film->genre}}</p>
                        </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        
    </div>
</section>

<section class="section00">

    <div class="brMore">
            <div class="dropdown">
              <span class="fa fa-angle-down dropLeft"></span>
              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                BROWSE CLASSES
              </button>
               <span class="fa fa-angle-down dropRight"></span><!-- 
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a href="#">Animation</a></li>
                <li><a href="#">Arts & Design</a></li>
                <li><a href="#">Comedy</a></li>
                <li><a href="#">Food</a></li>
                <li><a href="#">Fashion</a></li>
                <li><a href="#">Music</a></li>
                <li><a href="#">Travel</a></li>
                
              </ul> -->
            </div>
       </div>

    <div id="bigVo">
       <div class="container-fluid">
           <img class="img-responsive" src="/img/bigImg.png" alt="">
       </div>
    </div>
</section>

<!-- section -->
<section>
    <div id="nwAva">
        <div class="container-fluid">
            <div class="secHdr text-center">
                  <h4 class="txtWWW">NOW AVAILABLE</h4>
            </div>
            <div class="row">
                 <?php 
                    // films with >= 5 reviews
                    $reviews1 = \App\Reviews::whereIn('film_id', function ( $query ) {
                    $query->select('film_id')->from('reviews')->groupBy('film_id')->havingRaw('count(*) >= 5');
                    })->get()->toArray();
                    $filmsIdWith5Reviews = array();
                    foreach ($reviews1 as $review) {
                    array_push($filmsIdWith5Reviews, $review['film_id']);
                    }
                    $films = DB::table('films')->orderBy('most_likes','desc')->whereIn('id',$filmsIdWith5Reviews)->get()->toArray();   
                 ?>
                 @foreach($films as $film)
                    <div class="col-sm-6">
                            <div class="vCard vCard2">
                             <a href="/videos/{{$film->vimeo_video_id}}">
                                <img class="vCardImg" src="/uploads/{{$film->video_thumbnail}}" alt="">
                                <div class="vCardGradient"></div>
                                <div class="vCardInfo">
                                    <h2 class="txtWWW txt300 text-uppercase">{{$film->title}}</h2>
                                    <p class="txtGGG txt30 txt300 text-uppercase">{{$film->genre}}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach   
            </div>
        </div>
    </div>
</section>

<section class="">
    <div id="bigVo">
       <div class="container-fluid">
           <img class="img-responsive" src="/img/bigImg2.png" alt="">
       </div>
    </div>
</section>


<!-- section carousel 3 img-->
<section>
    <div id="carousel3Img">
        <div id="owl-carousel4-img2" class="owl-carousel owl-theme">
            <div class="item">
                <div class="vCard">
                   <a href="">

                    <img class="vCardImg" src="/img/carousel4Imgs/1-min.jpg" alt="">
                    <div class="vCardGradient"></div>
                    <div class="vCardInfo">
                        <h2 class="txtWWW txt300 text-uppercase">steve marting</h2>
                        <p class="txtGGG txt30 txt300 text-uppercase">teaches comedy</p>
                    </div>
                    </a>
                </div>
            </div>
            <div class="item">
                <div class="vCard">
                    <a href="">
                        <img class="vCardImg" src="/img/carousel4Imgs/2-min.jpg" alt="">
                        <div class="vCardGradient"></div>
                        <div class="vCardInfo">
                            <h2 class="txtWWW txt300 text-uppercase">steve marting</h2>
                            <p class="txtGGG txt30 txt300 text-uppercase">teaches comedy</p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="item">
                <div class="vCard">
                    <a href="">
                        <img class="vCardImg" src="/img/carousel4Imgs/3-min.jpg" alt="">
                        <div class="vCardGradient"></div>
                        <div class="vCardInfo">
                            <h2 class="txtWWW txt300 text-uppercase">steve marting</h2>
                            <p class="txtGGG txt30 txt300 text-uppercase">teaches comedy</p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="item">
                <div class="vCard">
                    <a href="">
                        <img class="vCardImg" src="/img/carousel4Imgs/4-min.jpg" alt="">
                        <div class="vCardGradient"></div>
                        <div class="vCardInfo">
                            <h2 class="txtWWW txt300 text-uppercase">steve marting</h2>
                            <p class="txtGGG txt30 txt300 text-uppercase">teaches comedy</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
       
    </div>
</section>
<!-- / section carousel 3 img-->
        <!-- section 2 cols-->
<section class="section00">
     <div class="brMore">
            <div class="dropdown">
               <span class="fa fa-angle-down dropLeft"></span>
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                BROWSE CLASSES
                </button>
                <span class="fa fa-angle-down dropRight"></span><!-- 
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a href="#">Animation</a></li>
                    <li><a href="#">Arts & Design</a></li>
                    <li><a href="#">Comedy</a></li>
                    <li><a href="#">Food</a></li>
                    <li><a href="#">Fashion</a></li>
                    <li><a href="#">Music</a></li>
                    <li><a href="#">Travel</a></li>
                </ul> -->
            </div>
        </div>


    <div id="vo2Cols">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <div class="vCard vCard2" >
                       <a href="">
                        <img class="vCardImg" src="/img/cols2Imgs/1.jpg" alt="">
                        <div class="vCardGradient"></div>
                        <div class="vCardInfo">
                            <h2 class="txtWWW txt300 text-uppercase">steve marting</h2>
                            <p class="txtGGG txt30 txt300 text-uppercase">teaches comedy</p>
                        </div>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="vCard vCard2">
                       <a href="">

                       <img class="vCardImg" src="/img/cols2Imgs/2.jpg" alt="">
                        <div class="vCardGradient"></div>
                        <div class="vCardInfo">
                            <h2 class="txtWWW txt300 text-uppercase">steve marting</h2>
                            <p class="txtGGG txt30 txt300 text-uppercase">teaches comedy</p>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- / section 2 Cols-->

<section class="bgCta">
    <div class="hoCta">
        <div class="hoCtaInfo text-center">
            <h2 class="txtWWW txt200">LEARN FROM THE BEST</h2>
            <p  class="txtWWW txt200 txt24">Visit our blog for a deeper dive into all things SOTL.</p>
            <a  class="txtWWW txt24 hvr-underline-from-center" href="">READ MORE <span class="rightArrow"></span></a>
        </div>
    </div>
</section>
    
<section class="section100 bg090">
    <div id="fSocial" class="text-center">
       <h4>STAY UP TO DATE WITH SOTL</h4>
        <ul>
            <li><a href="https://www.twitter.com/" target="_blank"><img src="/img/s1.png" alt=""></a></li>
            <li><a href="https://www.facebbok.com/" target="_blank"><img src="/img/s2.png" alt=""></a></li>
            <li><a href="https://www.googleplus.com/" target="_blank"><img src="/img/s3.png" alt=""></a></li>
        </ul>
    </div>
</section>
@endsection




