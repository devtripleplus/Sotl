<?php

namespace App\Http\Controllers;
use App\User;
use App\Films;
use \Auth;
use Route;
use App\Reviews;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function __construct($value='')
    {
    	$this->middleware('auth')->except(['numberOfReviews','getHeatScore']);
    }

    //method to post a review on a particular video
    public function updateVideoReview($id)
    {
    	$this->validate(request(), [
    		'title' => 'required|min:10|max:255',
    		'description' => 'required',
    		'writer' => 'required|min:1|max:5',
    		'director' => 'required|min:1|max:5',
    		'editor' => 'required|min:1|max:5',
    		'cinematography' => 'required|min:0.1|max:5',
    		'acting' => 'required|min:1|max:5',
    		'producer' => 'required|min:1|max:5',
    		'filmrating' => 'required|min:0.1|max:5'
    	]);
    	if(Auth::user() && (Auth::user()->role == 'admin' || Auth::user()->role == 'student' )){
    	    $user_id = Auth::user()->id;
    		$film_id = $id;
    		$rate_elements = array('writer' => request('writer'), 'director' => request('director'), 'editor' => request('editor'), 'cinematography' => request('cinematography'), 'acting' => request('acting'), 'producer' => request('producer'), 'filmrating' => request('filmrating'));
    		$rate_elements = serialize($rate_elements);
    		$reviews = new Reviews;
    		$reviews->title = request('title');
    		$reviews->description = request('description');
    		$reviews->rate_elements = $rate_elements;
    		$reviews->user_id = $user_id;
    		$reviews->film_id = $film_id;
    		$reviewsres = $reviews->save();

    		/*$review = Reviews::create([
    			'title' => request('title'),
    			'description' => request('description'),
    			'user_id' => $user_id,
    			'film_id' => $film_id,
    			'rate_elements' => $rate_elements
    		]);*/
    		if($reviewsres){
    			Session::flash('message', 'You just reviewed this film');
    			return back();
    		}
    		Session::flash('message', 'Some error occured while you are reviewing this video!!');
    		return back();
    	}
    	return back()->withErrors(array('message' => 'You have not access to review this film!!'));
    	
    }

    //method to fetch current logged-in users review on the current film on film page
    public function getCurrentLoggedINUsersReview($film_id)
    {
       return Reviews::where([['user_id', '=', Auth::user()->id],['film_id', '=', $film_id]])->get()->toArray();
    }



    //method to fetch top review from the reviews table
    public function getTopReviews()
    {
        return Reviews::orderBy('helpfullreviewcount', 'desc')->take(2)->get();
    }

    //method to fetch top review from the reviews table on a particular film using film ID
    public function getTopReviewsONFilm($film_id)
    {
        return Reviews::where('film_id','=',$film_id)->orderBy('helpfullreviewcount', 'desc')->take(2)->get();
    }

    //method to get review user's name using user_id
    public function getReviewUserName($user_id)
    {
        return User::where('id','=',$user_id)->get()->toArray()[0]['name'];
    }

    //method to get reviews using film id
    public function getReviewUsingFilmID($film_id)
    {
       return Reviews::where('film_id','=',$film_id)->orderBy('helpfullreviewcount','desc')->get()->toArray();
    }

    //method to get reviews using film id
    public function getNoOfReviewUsingFilmID($film_id)
    {
       return Reviews::where('film_id','=',$film_id)->orderBy('helpfullreviewcount','desc')->take(3)->toArray();
    }

    //method to get avg rating on a films through reviews
    public function getAvgReviewsRating($reviewsForThisFilm)
    {
        $totalfilmrationg = 0;
        foreach ($reviewsForThisFilm as $review) {
          $totalfilmrationg = $totalfilmrationg + unserialize($review['rate_elements'])['filmrating'];
        } 
        $avgrating = 0;
        if(count($reviewsForThisFilm) != 0){
          $avgrating = $totalfilmrationg/count($reviewsForThisFilm);
        }
        return $avgrating;
    }


    // method to update the current review of logged in user
    public function updateReview($id)
    {
        $this->validate(request(), [
            'title' => 'required|max:255|min:10',
            'description' => 'required',
        ]);
        $review = Reviews::find($id);
        $review->title = request('title');
        $review->description = request('description');
        $film_id = $review->film_id;
        $film = Films::find($film_id);
        $vimeo_id = $film->vimeo_video_id;
        if($review->save()){
            Session::flash('message', 'You just updated your review on this video');
            return redirect('/videos/'.$vimeo_id);
        }

        return back()->withErrors(array('message' => 'You do not have access to update the review on this film!!'));
        
    }

    //users heat score film wise
    public function getEachCategoryHeatScoreForThisFilm($film_id)
    {
           $reviews = Reviews::where('film_id','=', $film_id)->get()->toArray();
           $count = Reviews::where('film_id','=', $film_id)->count();
           $rate_elements = array();
           $writer = 0;
           $director = 0;
           $editor = 0;
           $cinematography = 0;
           $acting = 0;
           $producer = 0;
           foreach ($reviews as $review) {
             $rate_elements = unserialize($review['rate_elements']);
             $writer = $writer + $rate_elements['writer'];
             $director = $director + $rate_elements['director'];
             $editor = $editor + $rate_elements['editor'];
             $cinematography = $cinematography + $rate_elements['cinematography'];
             $acting = $acting + $rate_elements['acting'];
             $producer = $producer + $rate_elements['producer'];
           }
           $heatScores = array();
           if($count >= 1){
               $writer = number_format($writer/$count, 2);
               $director = number_format($director/$count, 2);
               $editor = number_format($editor/$count, 2);
               $cinematography = number_format($cinematography/$count, 2);
               $acting = number_format($acting/$count, 2);
               $producer = number_format($producer/$count, 2);
           }
           return $heatScores = array($director, $producer, $writer, $editor, $cinematography, $acting);
    }

    //method to vote helpful and non-helpful review by logged in user
    public function updateReviewHelpful($id)
    {
       if(Auth::user()){
            $user_id = Auth::user()->id;
            $review = Reviews::find($id);
            if($review->helpfullreview == ''){
                $review->helpfullreview = array();
                $helpfullreview = $review->helpfullreview;
            }
            else{
              $helpfullreview = unserialize($review->helpfullreview);
            }
            
            if(!in_array($user_id, $helpfullreview)){
                $helpfullreviewcount = ++$review->helpfullreviewcount;
                $review->helpfullreviewcount  = $helpfullreviewcount;
                if ($helpfullreview) {
                    array_push($helpfullreview, $user_id);
                    $review->helpfullreview = serialize($helpfullreview);
                }
                else{
                    $review->helpfullreview = serialize(array($user_id));
                }
                if($review->save()){
                    Session::flash('message', 'You just voted review: '.$review->title);
                    return back();
                }
            }
            else{
                /*$helpfullreviewcount = --$review->helpfullreviewcount;
                $review->helpfullreviewcount  = $helpfullreviewcount;
                $review->helpfullreview = serialize(array_diff(unserialize($review->helpfullreview), array($user_id)));
                if($review->save()){*/
                    Session::flash('message', 'You already voted review: '.$review->title);
                    return back();
                //}
            }
            
       }
       Session::flash('message', 'Please login first to like this video');
       return back();
        
    }
    
    //method to load the review on click on load more reviews button
    public function numberOfReviews()
    {  
         $number = request('total');
         $film_id = request('film_id');
         $reviews = Reviews::where('film_id','=',$film_id)->orderBy('helpfullreviewcount','desc')->take($number)->get()->toArray();
         //return count($reviews);
         return view('student.ajaxLoadReview', compact('reviews'));
    }

    //method to calculate the current users heatscore
    public function getUserHeatScore()
    {
        $director = array();
        $producer = array();
        $writer = array();
        $editor = array();
        $cinematography = array();
        $actor = array();

        $user_id = Auth::user()->id;
        $films = Films::select('id', 'team_credit')->get()->toArray();
        //print_r($films);
        foreach ($films as $film) {
            if(!empty(unserialize($film['team_credit']))){
                $team_credits = unserialize($film['team_credit']);
                foreach($team_credits as $key => $team_credit){
                    foreach ($team_credit as $key => $value) {
                        if(!empty($team_credit['ProducerID'])){
                            if($key == 'ProducerID' && in_array(Auth::user()->id, $team_credit['ProducerID'])){
                              array_push($producer, $film['id']);
                            }
                        }
                        if(!empty($team_credit['DirectorID'])){
                            if($key == 'DirectorID' && in_array(Auth::user()->id, $team_credit['DirectorID'])){
                                array_push($director, $film['id']);
                            }
                        }
                        if(!empty($team_credit['WriterID'])){
                           if($key == 'WriterID' && in_array(Auth::user()->id, $team_credit['WriterID'])){
                             array_push($writer, $film['id']);
                           } 
                        }   

                        if(!empty($team_credit['ActorID'])){
                            if($key == 'ActorID' && in_array(Auth::user()->id, $team_credit['ActorID'])){
                                array_push($actor, $film['id']);
                            }
                        } 
                        if(!empty($team_credit['CinematographerID'])) {
                            if($key == 'CinematographerID' && in_array(Auth::user()->id, $team_credit['CinematographerID'])){
                              array_push($cinematography, $film['id']);
                            }
                        } 
                        if(!empty($team_credit['EditorID'])) {
                            if($key == 'EditorID' && in_array(Auth::user()->id, $team_credit['EditorID'])){
                               array_push($editor, $film['id']);
                            }
                        } 
                    }
                }
            }
            
        }

        $directorReviews = array();
        $writerReviews = array();
        $editorReviews = array();
        $producerReviews = array();
        $cinematographyReviews = array();
        $actorReviews = array();
        if($director){
          $directorReviews = Reviews::whereIn('film_id',$director)->get()->toArray();
        }
         if($producer){
          $producerReviews = Reviews::whereIn('film_id',$producer)->get()->toArray();
        }
         if($writer){
          $writerReviews = Reviews::whereIn('film_id',$writer)->get()->toArray();
        }
         if($editor){
          $editorReviews = Reviews::whereIn('film_id',$editor)->get()->toArray();
        }
         if($cinematography){
          $cinematographyReviews = Reviews::whereIn('film_id',$cinematography)->get()->toArray();
        }
         if($actor){
          $actorReviews = Reviews::whereIn('film_id',$actor)->get()->toArray();
        }

        $directorReviewsCount = count($directorReviews);
        $producerReviewsCount = count($producerReviews);
        $writerReviewsCount = count($writerReviews);
        $editorReviewsCount = count($editorReviews);
        $cinematographyReviewsCount = count($cinematographyReviews);
        $actorReviewsCount = count($actorReviews);        

        $directorHeatScore = 0;
        $producerHeatScore = 0;
        $writerHeatScore = 0;
        $editorHeatScore = 0;
        $cinematograhyHeatScore = 0;
        $actorHeatScore = 0;

        if($directorReviews){
            foreach ($directorReviews as $review) {
                $reviewRateElemnets = unserialize($review['rate_elements']);
                $directorHeatScore = $directorHeatScore + $reviewRateElemnets['director'];
            }
        }
        if($producerReviews){
            foreach ($producerReviews as $review) {
                $reviewRateElemnets = unserialize($review['rate_elements']);
                $producerHeatScore = $producerHeatScore + $reviewRateElemnets['producer'];
            }
        }
        if($writerReviews){
            foreach ($writerReviews as $review) {
                $reviewRateElemnets = unserialize($review['rate_elements']);
                $writerHeatScore = $writerHeatScore + $reviewRateElemnets['writer'];
            }
        }
        if($editorReviews){
            foreach ($editorReviews as $review) {
                $reviewRateElemnets = unserialize($review['rate_elements']);
                $editorHeatScore = $editorHeatScore + $reviewRateElemnets['editor'];
            }
        }
        if($cinematographyReviews){
            foreach ($cinematographyReviews as $review) {
                $reviewRateElemnets = unserialize($review['rate_elements']);
                $cinematograhyHeatScore = $cinematograhyHeatScore + $reviewRateElemnets['cinematographer'];
            }
        }
        if($actorReviews){
            foreach ($actorReviews as $review) {
                $reviewRateElemnets = unserialize($review['rate_elements']);
                $actorHeatScore = $actorHeatScore + $reviewRateElemnets['acting'];
            }
        }
        $avgDirectorHeatScore = $avgProducerHeatScore = $avgWriterHeatScore = $avgEditorHeatScore = $avgCinematographyHeatScore = $avgActorHeatScore = 0;
        if($directorReviewsCount > 0){
            $avgDirectorHeatScore = ( $directorHeatScore / $directorReviewsCount ) * 2;
        }
        if($producerReviewsCount > 0){
            $avgProducerHeatScore = ( $producerHeatScore / $producerReviewsCount ) * 2;
        }     
        if($writerReviewsCount > 0){
            $avgWriterHeatScore = ( $writerHeatScore / $writerReviewsCount ) * 2;
        }  
        if($editorReviewsCount > 0){
            $avgEditorHeatScore = ( $editorHeatScore / $editorReviewsCount ) * 2;
        }  
        if($cinematographyReviewsCount > 0){
            $avgCinematographyHeatScore = ( $cinematograhyHeatScore / $cinematographyReviewsCount ) * 2;
        }  
        if($actorReviewsCount > 0){
            $avgActorHeatScore = ( $actorHeatScore / $actorReviewsCount ) * 2;
        }  

        return $heatscores = array('directorHeatScore' => $avgDirectorHeatScore, 'producerHeatScore' => $avgProducerHeatScore,'writerHeatScore' => $avgWriterHeatScore,'editorHeatScore' => $avgEditorHeatScore, 'cinematographyHeatScore' => $avgCinematographyHeatScore, 'actorHeatScore' => $avgActorHeatScore);            
    }
    //get user's heat score in wp
     public function getHeatScore($id)
    {
        $director = array();
        $producer = array();
        $writer = array();
        $editor = array();
        $cinematography = array();
        $actor = array();

        $user_id = $id;
        $films = Films::select('id', 'team_credit')->get()->toArray();
        //print_r($films);
        foreach ($films as $film) {
            if(!empty(unserialize($film['team_credit']))){
                $team_credits = unserialize($film['team_credit']);
                foreach($team_credits as $key => $team_credit){
                    foreach ($team_credit as $key => $value) {
                        if(!empty($team_credit['ProducerID'])){
                            if($key == 'ProducerID' && in_array($id, $team_credit['ProducerID'])){
                              array_push($producer, $film['id']);
                            }
                        }
                        if(!empty($team_credit['DirectorID'])){
                            if($key == 'DirectorID' && in_array($id, $team_credit['DirectorID'])){
                                array_push($director, $film['id']);
                            }
                        }
                        if(!empty($team_credit['WriterID'])){
                           if($key == 'WriterID' && in_array($id, $team_credit['WriterID'])){
                             array_push($writer, $film['id']);
                           } 
                        }   

                        if(!empty($team_credit['ActorID'])){
                            if($key == 'ActorID' && in_array($id, $team_credit['ActorID'])){
                                array_push($actor, $film['id']);
                            }
                        } 
                        if(!empty($team_credit['CinematographerID'])) {
                            if($key == 'CinematographerID' && in_array($id, $team_credit['CinematographerID'])){
                              array_push($cinematography, $film['id']);
                            }
                        } 
                        if(!empty($team_credit['EditorID'])) {
                            if($key == 'EditorID' && in_array($id, $team_credit['EditorID'])){
                               array_push($editor, $film['id']);
                            }
                        } 
                    }
                }
            }
            
        }

        $directorReviews = array();
        $writerReviews = array();
        $editorReviews = array();
        $producerReviews = array();
        $cinematographyReviews = array();
        $actorReviews = array();
        if($director){
          $directorReviews = Reviews::whereIn('film_id',$director)->get()->toArray();
        }
         if($producer){
          $producerReviews = Reviews::whereIn('film_id',$producer)->get()->toArray();
        }
         if($writer){
          $writerReviews = Reviews::whereIn('film_id',$writer)->get()->toArray();
        }
         if($editor){
          $editorReviews = Reviews::whereIn('film_id',$editor)->get()->toArray();
        }
         if($cinematography){
          $cinematographyReviews = Reviews::whereIn('film_id',$cinematography)->get()->toArray();
        }
         if($actor){
          $actorReviews = Reviews::whereIn('film_id',$actor)->get()->toArray();
        }

        $directorReviewsCount = count($directorReviews);
        $producerReviewsCount = count($producerReviews);
        $writerReviewsCount = count($writerReviews);
        $editorReviewsCount = count($editorReviews);
        $cinematographyReviewsCount = count($cinematographyReviews);
        $actorReviewsCount = count($actorReviews);        

        $directorHeatScore = 0;
        $producerHeatScore = 0;
        $writerHeatScore = 0;
        $editorHeatScore = 0;
        $cinematograhyHeatScore = 0;
        $actorHeatScore = 0;

        if($directorReviews){
            foreach ($directorReviews as $review) {
                $reviewRateElemnets = unserialize($review['rate_elements']);
                $directorHeatScore = $directorHeatScore + $reviewRateElemnets['director'];
            }
        }
        if($producerReviews){
            foreach ($producerReviews as $review) {
                $reviewRateElemnets = unserialize($review['rate_elements']);
                $producerHeatScore = $producerHeatScore + $reviewRateElemnets['producer'];
            }
        }
        if($writerReviews){
            foreach ($writerReviews as $review) {
                $reviewRateElemnets = unserialize($review['rate_elements']);
                $writerHeatScore = $writerHeatScore + $reviewRateElemnets['writer'];
            }
        }
        if($editorReviews){
            foreach ($editorReviews as $review) {
                $reviewRateElemnets = unserialize($review['rate_elements']);
                $editorHeatScore = $editorHeatScore + $reviewRateElemnets['editor'];
            }
        }
        if($cinematographyReviews){
            foreach ($cinematographyReviews as $review) {
                $reviewRateElemnets = unserialize($review['rate_elements']);
                $cinematograhyHeatScore = $cinematograhyHeatScore + $reviewRateElemnets['cinematographer'];
            }
        }
        if($actorReviews){
            foreach ($actorReviews as $review) {
                $reviewRateElemnets = unserialize($review['rate_elements']);
                $actorHeatScore = $actorHeatScore + $reviewRateElemnets['acting'];
            }
        }
        $avgDirectorHeatScore = $avgProducerHeatScore = $avgWriterHeatScore = $avgEditorHeatScore = $avgCinematographyHeatScore = $avgActorHeatScore = 0;
        if($directorReviewsCount > 0){
            $avgDirectorHeatScore = ( $directorHeatScore / $directorReviewsCount ) * 2;
        }
        if($producerReviewsCount > 0){
            $avgProducerHeatScore = ( $producerHeatScore / $producerReviewsCount ) * 2;
        }     
        if($writerReviewsCount > 0){
            $avgWriterHeatScore = ( $writerHeatScore / $writerReviewsCount ) * 2;
        }  
        if($editorReviewsCount > 0){
            $avgEditorHeatScore = ( $editorHeatScore / $editorReviewsCount ) * 2;
        }  
        if($cinematographyReviewsCount > 0){
            $avgCinematographyHeatScore = ( $cinematograhyHeatScore / $cinematographyReviewsCount ) * 2;
        }  
        if($actorReviewsCount > 0){
            $avgActorHeatScore = ( $actorHeatScore / $actorReviewsCount ) * 2;
        }  

        return $heatscores = array('directorHeatScore' => $avgDirectorHeatScore, 'producerHeatScore' => $avgProducerHeatScore,'writerHeatScore' => $avgWriterHeatScore,'editorHeatScore' => $avgEditorHeatScore, 'cinematographyHeatScore' => $avgCinematographyHeatScore, 'actorHeatScore' => $avgActorHeatScore);            
    }


}
