<?php
namespace App\Http\Controllers;
use Request;
use Auth;
use App\User;
use App\Uploads;
use App\Films;
use App\Reviews;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use DB;



class FilmsController extends Controller
{
		    //protected $vimeo;

	public function __construct()
	{
		$this->middleware('auth')->except(['videos', 'viewVideo','numberOfFilms','searchAjaxHome','testingHeatScore','getFeaturedFilmInfo','getHomeHottestFilm']);
		//$this->vimeo = $vimeo;
	}
	// Get Videos From Vimeo Account
	public function videos()
	{
		if(!(Auth::user() && !(Auth::user()->role == 'fans'))){
            return redirect('/login');
        }
        $videos = array();
		//$videos = Vimeo::request('/me/videos', ['per_page' => 50], 'GET');
		return view('student/upload', compact('videos'));
	}

	//method to call thank you page
	public function thankyou()
	{
		return view('thankyou');
	}


	/*public function updateMetaData(Request $request, VimeoManager $vimeo)
	{	
		return request('vimeo_id');
		$this->vimeo = $vimeo;
		$films = Films::where('vimeo_video_id', $vimeo_id)->get()->toArray();
		$video_data = $this->vimeo->request(request('vimeo_id'), array(
				'name' => $films[0]['title'],
				'description' => $films[0]['biography'],
				'pictures' => $films[0]['video_thumbnail']
				), 'PATCH');
		if($video_data){
			return 'true';
		}
		return 'false';
	}*/


	//* Upload Film Project Video 
	public function uploadvideo(Request $request)
	{
		//*For upload thumbnail on own server
		$Uploads = new Uploads();
		if (request('thumbnail')) {
		$fileforstore = Request::file('thumbnail');
		$filename = $fileforstore->getClientOriginalName();
		$path = public_path().'/uploads/';
		$fileforstore->move($path, $filename);
	}else {
		$filename = "default.jpg";
	}

		//$videofile=Request::file('file_data');
		// to get the films duration in the vimeo format like (HH:MM:SS.MS)
		//ob_start(); //Turn on output buffering
		// Execute an external program and display raw output 
		//passthru("/usr/bin/ffmpeg -i \"{$videofile}\" 2>&1");
		//$duration = ob_get_contents(); //Return the contents of the output buffer
		//ob_end_clean(); //Turn off output buffering
		//$search='/Duration: (.*?),/';
		//$duration=preg_match($search, $duration, $matches, PREG_OFFSET_CAPTURE, 3); //Perform a regular expression match
		// End of getting duration.
		$film_meta = [['title' => request('title')],['biography' => request('biography')], ['challenges' => request('challenges')], ['genre' =>  request('genre')],['filename' => $filename], ['duration' => 0]];
		$teamArray = [
			['Director'=>Input::get('director'),'DirectorID'=>Input::get('directorid')],
			['Producer'=>Input::get('producer'),'ProducerID'=>Input::get('producerid')],
			['Writer'=>Input::get('writer'),'WriterID'=>Input::get('writerid')],
			['Editor'=>Input::get('editor'),'EditorID'=>Input::get('editorid')],
			['Cinematographer'=>Input::get('cinemotography'),'CinematographerID'=>Input::get('Cinematographerid')],
			['Actor'=>Input::get('actor'),'ActorID'=>Input::get('actorid')],
			];
		$filmMetaData = [['film_meta' => $film_meta], ['team_credit' => $teamArray]];	
                $filmMetaData = serialize($filmMetaData);
		$Uploads->data = $filmMetaData;
		$Uploads->user_id = Auth::user()->id;
		$Uploads->status = 0;
		$Uploads->ruid = request('ruid');
		if($Uploads->save()){
			return 'true';
		}
		else {
			return 'false';
		}


	}

	public function gen_uuid() {
	    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
	        // 32 bits for "time_low"
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

	        // 16 bits for "time_mid"
	        mt_rand( 0, 0xffff ),

	        // 16 bits for "time_hi_and_version",
	        // four most significant bits holds version number 4
	        mt_rand( 0, 0x0fff ) | 0x4000,

	        // 16 bits, 8 bits for "clk_seq_hi_res",
	        // 8 bits for "clk_seq_low",
	        // two most significant bits holds zero and one for variant DCE1.1
	        mt_rand( 0, 0x3fff ) | 0x8000,

	        // 48 bits for "node"
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
	    );
	}



	//method to update the metaData of the films
	public function updateFilmMetaData($vimeo_id, $ruid)
	{
		$filmeMetaData = Uploads::where('ruid', $ruid)->where('status', 0)->get()->toArray();
		if($filmeMetaData){
			$filmMetadata = unserialize($filmeMetaData[0]['data']);
			if($filmeMetaData){
				$Uploads = Uploads::find($filmeMetaData[0]['id']);
			}
			$Films = new Films();
			$filmMeta = $filmMetadata[0]['film_meta'];
			$teamArray = $filmMetadata[1]['team_credit'];
			$Films->title = $filmMeta[0]['title'];
			$Films->biography = $filmMeta[1]['biography'];
			$Films->user_id = Auth::user()->id;
			$Films->challenges = $filmMeta[2]['challenges'];
			$Films->genre = $filmMeta[3]['genre'];
			$Films->video_thumbnail = $filmMeta[4]['filename'];
			$Films->team_credit = serialize($teamArray);
			$Films->video_link = 'https://vimeo.com/' . $vimeo_id;
			$Films->vimeo_video_id = $vimeo_id;
			$Films->duration = $filmMeta[5]['duration'];
			if($Films->save()){
				$Uploads->status = 1;
				$Uploads->save();
				return 'true';
			}
			return 'false';
		}
		else{
			return 'false';
		}
		

	}


	// Controller method to view a particular video
	public function viewVideo($id)
	{   
		$film = Films::where('vimeo_video_id',$id)->get();
		if($film[0]->is_feature == 1){
		return view('theater-publicStudent', compact('film'));
		}else {	
		Session::flash('curr_film_id', $id);		
		return view('student.viewVideo', compact('film'));
		}
	}

	//method to fetch all pending review by current loggedin users
	public function getallPendingFilmstoReview()
	{
		$filmsIdReviewed = Reviews::select('film_id')->where('user_id','=',Auth::user()->id)->get()->toArray();
		$ids = array();
		foreach ($filmsIdReviewed as $id) {
			array_push($ids, $id['film_id']);
		}
		return $filmNotReviewedYets =Films::where('user_id',Auth::user()->id)->orderBy('most_likes','desc')->get()->take(4)->toArray();
	}

	//update video likes controller method
	public function updateVideoLikes($id)
	{
		if(Auth::user()){
				$user_id = Auth::user()->id;
				$film = Films::find($id);
				if($film->user_id == $user_id){
                    Session::flash('message', "You can't give one thumb to your own film");
                    return back();
                }
                else{
				if($film->likes == ''){
					$film->likes = array();
					$likes = $film->likes;
				}
				else{
				  $likes = unserialize($film->likes);
				}
				if($film->most_likes == ''){
					$film->most_likes = array();
					 $most_likes = $film->most_likes;
				}
				else{
				  $most_likes = unserialize($film->most_likes);
				}
				if(in_array($user_id, $likes)){
				    $film->likes = serialize(array_diff($likes, array($user_id)));
				    if($film->save()){
						Session::flash('message', 'You just disliked this film');
				        return back();
					}
				}
				else{
					if(in_array($user_id, $most_likes)){
						$most_likes = array_diff($most_likes, array($user_id));
					}
					$film->most_likes = serialize($most_likes);
					if ($likes) {
						array_push($likes, $user_id);
					    $film->likes = serialize($likes);
					}
					else{
						$film->likes = serialize(array($user_id));
					}
					if($film->save()){
						Session::flash('message', 'You gave this film one thumb up!');
				        return back();
					}
				}
			}
		}
		
		Session::flash('message', 'Please login first to like this film');
		return back();
	}

	//method to get the featured film for the home page
	public function getFeaturedFilmInfo()
	{
		$featuredFilm = Films::where('featured','=',1)->orderBy('id','asc')->take(1)->get()->toArray();
		$reviewsForThisFilm = Reviews::where('film_id','=',$featuredFilm[0]['id'])->orderBy('helpfullreviewcount','desc')->get()->toArray();
		$totalfilmrating = 0;
		foreach ($reviewsForThisFilm as $review) {
		$totalfilmrating = $totalfilmrating + unserialize($review['rate_elements'])['filmrating'];
		} 
		$avgrating = 0;
		if(count($reviewsForThisFilm) != 0){
		$avgrating = $totalfilmrating/count($reviewsForThisFilm);
		}
		return array('featuredFilm' => $featuredFilm,'reviewsForThisFilm' => $reviewsForThisFilm, 'totalfilmrating' => $totalfilmrating, 'avgrating' => $avgrating);

	}

	//method to fetch film thumbnail using film id
	public function getFilmsThumbnailUsingID($film_id)
	{
		return Films::select('video_thumbnail')->where('id','=',$film_id)->get()->toArray()[0]['video_thumbnail'];
	}

	//method to get home page hottest films as suggested bu client
	public function getHomeHottestFilm()
	{
		return Films::select('vimeo_video_id')->orderBy('most_likes','desc')->take(1)->get()->toArray(); 
	}

	//method to get more than five reviews
	public function getFilmsWithMoreThanFiveReviews()
	{
		$reviews1 = Reviews::whereIn('film_id', function ( $query ) {
                    $query->select('film_id')->from('reviews')->groupBy('film_id')->havingRaw('count(*) >= 5');
                })->get()->toArray();
        $filmsIdWith5Reviews = array();
        foreach ($reviews1 as $review) {
          array_push($filmsIdWith5Reviews, $review['film_id']);
        }
        return Films::orderBy('most_likes','desc')->whereIn('id',$filmsIdWith5Reviews)->take(3)->get()->toArray();
	}

	//method to get less than five reviews
	public function getFilmsWithLessThanFiveReviews()
	{
		$reviews1 = Reviews::whereIn('film_id', function ( $query ) {
                    $query->select('film_id')->from('reviews')->groupBy('film_id')->havingRaw('count(*) >= 5');
                })->get()->toArray();
        $filmsIdWith5Reviews = array();
        foreach ($reviews1 as $review) {
          array_push($filmsIdWith5Reviews, $review['film_id']);
        }
        return Films::orderBy('most_likes','desc')->whereNotIn('id',array_unique($filmsIdWith5Reviews))->where('user_id', '!=', Auth::user()->id)->take(3)->get()->toArray();
	}

	//method to get films with less than 5 reviews and not uploaded by the current user
    public function countAllFilmsLessThanFiveReview()
    {
        return films::where('user_id','!=', Auth::user()->id)->count();
    }

	//method to count all films
	public function countAllFilms()
	{
		return films::count();
	}

	//update video likes controller method
	public function updateVideoMostLikes($id)
	{
		if(Auth::user()){
				$user_id = Auth::user()->id;
				$film = Films::find($id);
				if($film->user_id == $user_id){
                    Session::flash('message', "You can't give two thumb to your own film");
                    return back();
                }
                else{
				if($film->most_likes == ''){
					$film->most_likes = array();
					$most_likes = $film->most_likes;
				}
				else{
				  $most_likes = unserialize($film->most_likes);
				}
				if($film->likes == ''){
					$film->likes = array();
					$likes = $film->likes;
				}
				else{
				  $likes = unserialize($film->likes);
				}

				if(in_array($user_id, $most_likes)){
				    $film->most_likes = serialize(array_diff($most_likes, array($user_id)));
				    if($film->save()){
						Session::flash('message', 'You just disliked this film');
				        return back();
					}
				}
				else{
					if(in_array($user_id, $likes)){
						$likes = array_diff($likes, array($user_id));
					}
					$film->likes = serialize($likes);
					if ($most_likes) {
						array_push($most_likes, $user_id);
					    $film->most_likes = serialize($most_likes);
					}
					else{
						$film->most_likes = serialize(array($user_id));
					}
					if($film->save()){
						Session::flash('message', 'You gave this film two thumbs up!');
				        return back();
					}
				}
			}
		}
		Session::flash('message', 'Please login first to like this film');
		return back();
	}

	// Number of films for load more module
	public function numberOfFilms()
	{  
		$number = request('total');
		$films = Films::orderBy('most_likes','desc')->take($number)->get()->toArray();
		return view('student.ajaxLoadFilm', compact('films'));
	}

		//* Number of films for load more module on upload page
	public function numberOfFilmsUpload()
	{  
		$number = request('total');
		$reviews1 = \App\Reviews::whereIn('film_id', function ( $query ) {
                    $query->select('film_id')->from('reviews')->groupBy('film_id')->havingRaw('count(*) >= 5');
                    })->get()->toArray();
        $filmsIdLess5Reviews = array();
        foreach ($reviews1 as $review) {
        	array_push($filmsIdLess5Reviews, $review['film_id']);
        }

		$films = Films::orderBy('most_likes','desc')->take($number)->whereNotIn('id',array_unique($filmsIdLess5Reviews))->where('user_id', '!=', Auth::user()->id)->get()->toArray();
		return view('student.ajaxLoadFilm', compact('films'));
	}

	public function searchAjaxHome()
	{	
		$reviews1 = \App\Reviews::whereIn('film_id', function ( $query ) {
                    $query->select('film_id')->from('reviews')->groupBy('film_id')->havingRaw('count(*) >= 5');
                    })->get()->toArray();

        $filmsIdWith5Reviews = array();
        foreach ($reviews1 as $review) {
        	if(!in_array($review['film_id'], $filmsIdWith5Reviews)){
        		array_push($filmsIdWith5Reviews, $review['film_id']);
        	}
        }
		if(request('genre') != ''){
			$films = Films::orderBy('most_likes')->where('genre','=',request('genre'))->whereIn('id',$filmsIdWith5Reviews)->get()->toArray();
		}else {
			$films = Films::orderBy('most_likes')->whereIn('id',$filmsIdWith5Reviews)->get()->toArray();
		}
		if(request('location')){
			$Users = User::select('id')->where('location','=',request('location'))->get()->toArray();
            $users = array();
            foreach ($Users as $user) {
              array_push($users, $user['id']);
            }
            $films = Films::orderBy('most_likes','desc')->whereIn('user_id',$users)->whereIn('id',$filmsIdWith5Reviews)->get()->toArray();
		}

		if(request('search')){
         $films = Films::orderBy('most_likes','desc')->whereIn('id',$filmsIdWith5Reviews)->where('title','LIKE','%'.request('search').'%')->get()->toArray();

       	}
		return view('student.ajaxLoadFilm', compact('films'));
	}


	//* ajax search of films using genre and location on Upload Page
	public function searchAjaxUpload()
	{	
		$reviews1 = \App\Reviews::whereIn('film_id', function ( $query ) {
                    $query->select('film_id')->from('reviews')->groupBy('film_id')->havingRaw('count(*) >= 5');
                    })->get()->toArray();
        $filmsIdLess5Reviews = array();
        foreach ($reviews1 as $review) {
        	array_push($filmsIdLess5Reviews, $review['film_id']);
        }
		if(request('genre') != ''){
			$films = Films::orderBy('most_likes')->where('genre','=',request('genre'))->whereNotIn('id',array_unique($filmsIdLess5Reviews))->where('user_id', '!=', Auth::user()->id)->get()->toArray();
		}else {
			$films = Films::orderBy('most_likes')->whereNotIn('id',array_unique($filmsIdLess5Reviews))->where('user_id', '!=', Auth::user()->id)->get()->toArray();
		}
		if(request('location')){
			$Users = User::select('id')->where('location','=',request('location'))->get()->toArray();
            $users = array();
            foreach ($Users as $user) {
              array_push($users, $user['id']);
            }
            $films = Films::orderBy('most_likes','desc')->where('user_id', '!=', Auth::user()->id)->whereIn('user_id',$users)->whereNotIn('id',array_unique($filmsIdLess5Reviews))->get()->toArray();
		}
		if(request('search')){
         $films = Films::orderBy('most_likes','desc')->take(9)->whereNotIn('id',array_unique($filmsIdLess5Reviews))->where('user_id', '!=', Auth::user()->id)->where('title','LIKE','%'.request('search').'%')->get()->toArray();

       }
		return view('student.ajaxLoadFilm', compact('films'));
	}

	// method to manage all the films by admin
	public function filmsManage()
    {
        if(!(Auth::user() && Auth::user()->role == 'admin')){
            return redirect('/home');
        }
        $data = Films::all();
        return view('admin.posts',compact('data'));
    }

    // method to edit a film
    public function filmEdit($id)
    {
    	if(auth()->user()->role == 'admin'){
            $film = Films::where('id', $id)->get();
            return view('admin.editfilm',compact('film'));
        }
        return redirect('/');
    }

    // method to update a film
    public function filmUpdate($id)
    {
		$this->validate(request(), [
			'title' => 'required|max:255',
			'biography' => 'required',
			'challenges' => 'required',
			'genre' => 'required',
		]);
	    $film = Films::find($id);
        $film->title = request('title');
        $film->biography = request('biography');
        $film->challenges = request('challenges');
        $film->genre = request('genre');
        if(request('featured') == 'on'){
        	$film->featured = 1;
        }
        else{
        	$film->featured = 0;
        }
        $updateFilm = $film->save();

        if($updateFilm){
        	Session::flash('message', 'Films updated successfully.');
            return redirect('/admin/films/show');
        }
    }

    // method to delete a film
    public function filmDelete($id)
    {
    	$user = Films::find($id);
        $user->delete();
        Session::flash('message', 'Films updated successfully.');
        return back();
    }


	//* Ajax Responce for screening cast and crew
	public function autocomplete(){
		$term = Input::get('term');
		
		$results = array();
		
		$queries = User::select("name",'id')->where('name', 'LIKE', '%'.$term.'%')->get();
		
		foreach ($queries as $query)
		{
		    $results[] = [ 'id' => $query->id, 'value' => $query->name ];
		}	    return response()->json($results);
	}


	public function uploadprogress(){
		return view('student/uploadprogress');
	}

}
