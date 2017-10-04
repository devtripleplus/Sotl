<script type="text/javascript" src="/js/star-rating.js"></script>
<!-- <script type="text/javascript" src="/js/star-rating.js"></script> -->
<?php //print_r($reviews); ?>
@foreach($reviews as $review)
  <div class="col-md-4 col-sm-6">
      <div class="vCard">
          <?php 
            $filmrating = unserialize($review['rate_elements'])['filmrating']; 
            $film_thumbnail = DB::table('films')->select('video_thumbnail')->where('id','=',$review['film_id'])->get()->toArray()[0]->video_thumbnail;
          ?>
          <a href="javascript:void(0)">
              <img class="vCardImg" src="/uploads/{{$film_thumbnail}}" alt="">
              <div class="vCardGradient"></div>
              <div class="vcardInfo2">
                  <input id="kartik" name="filmrating" class="rating" data-stars="5" data-step="0.1" value="{{$filmrating}}" disabled title=""/>
                  <label for="filmrating">{{$filmrating}} Stars</label>
              </div>
              <div class="vCardInfo">
                  <h2 class="text-left">{{str_limit($review['title'], 15, '...')}}</h2>
                  <p class="text-left">{{str_limit($review['description'], 125, '...')}}</p>
                  <p class="stuName"> <a href="javascript:void(0)">{{DB::table('users')->where('id','=',$review['user_id'])->get()->toArray()[0]->name}}</a> | <a href="javascript:void(0)">{{date('M d, Y', strtotime($review['created_at']))}}</a></p>
                  
              </div>
            @if(Auth::user())
              <?php 
               $helpfulReview = array();
               $helpfulReviewCount = 0;
               if($review['helpfullreview'] != ''){
                  $helpfulReview = unserialize($review['helpfullreview']); 
                  $helpfulReviewCount = count($helpfulReview);
               }
               $currentUserID = Auth::user()->id;
                $helpfulClass = '';
                if(in_array($currentUserID, $helpfulReview)){
                  $helpfulClass = 'active';
                }
              ?>
              @if($helpfulReviewCount >= 1 && $helpfulClass == 'active')
              <div class="helpful {{$helpfulClass}}">
                  <a href="javascript:void(0)">{{$helpfulReviewCount}} <i class="fa fa-thumbs-up"></i></a> 
              </div>
              @elseif($helpfulReviewCount >= 1)
                <div class="helpful notLogged">
                  <a href="/review/helpful/{{$review['id']}}">{{$helpfulReviewCount}} <i class="fa fa-thumbs-up"></i></a> 
                </div>
              @else
                <div class="helpful {{$helpfulClass}}">
                  <a href="/review/helpful/{{$review['id']}}">Helpful?</a>
                </div>
              @endif
            @else
            <?php
                 $helpfulReview = array();
                 $helpfulReviewCount = 0;
                 if($review['helpfullreview'] != ''){
                    $helpfulReview = unserialize($review['helpfullreview']); 
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