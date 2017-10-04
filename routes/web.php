<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//welcome page or home page routes

Route::get('/', function () {
    return view('home');
});


Route::get('/theater', function () {
    return view('home');
});

//login rotes

Route::get('/login', function(){
	if(Auth::user() && Auth::user()->role == 'admin'){
		return redirect('/admin');
	}
	elseif(Auth::user()){
		return redirect('/');
	}
	return view('layouts.login');
});

//registration routes

Route::get('/register', function(){
	if(Auth::user() && Auth::user()->role == 'admin'){
		return redirect('/admin');
	}
	elseif(Auth::user()){
		return redirect('/');
	}
	
	return view('layouts.register');
});

Route::post('/login','UserController@startSession');
Route::post('/register','UserController@store');
Route::get('/logout', "UserController@destroy");
Route::post('loginwithWP', 'UserController@loginWithWP');
Route::post('/wplogout', "UserController@destroylaravel");

//visit  profile 

Route::get('/profile', 'UserController@visitProfile');

//update profile

Route::post('/profile/update', 'UserController@update');
Route::post('/admin/profile/update', 'UserController@updateAdmin');

Route::get('/posts', "PostController@postView");
Route::get('/post/create', "PostController@create");
Route::post('/posts/store', "PostController@store");
Route::get('/posts/show', "PostController@showPosts");
Route::get('/posts/{post}', "PostController@show");
Route::get('/post/{id}/edit', "PostController@edit");
Route::post('/post/{id}/update', "PostController@update");
Route::get('/post/{id}/delete', "PostController@deletePost");
Route::post('/posts/{id}/comment', "CommentController@store");
/*
Route::get('/social/sign', 'UserController@redirectToProvider');
Route::get('/social/sign/auth', 'UserController@handleProviderCallback');*/

Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/auth', 'Auth\LoginController@handleProviderCallback');

Route::get('login/linkedin', 'Auth\LoginController@redirectToLinkedinProvider');
Route::get('login/linkedin/auth', 'Auth\LoginController@handleProviderLinkedinCallback');


//Auth::routes();



Route::get('/home', function(){
	return view('home');
});

Route::get('/admin/users/show', function(){
	return view('admin.users');
});

//Admin user management 
Route::get('/admin', 'UserController@adminDashboard');
Route::get('/admin/users', 'UserController@userManage');
Route::get('/admin/user/edit/{id}', 'UserController@userEdit');
Route::post('/admin/user/update/{id}', 'UserController@userUpdate');
Route::get('/admin/user/delete/{id}', 'UserController@userDelete');

//admin film view management
Route::get('/admin/films/show', 'FilmsController@filmsManage');
Route::get('/admin/films/edit/{id}', 'FilmsController@filmEdit');
Route::post('/admin/films/update/{id}', 'FilmsController@filmUpdate');
Route::get('/admin/films/delete/{id}', 'FilmsController@filmDelete');

//* Videos route 
Route::get('/upload', "FilmsController@videos");
Route::post('/upload', "FilmsController@uploadvideo");/*
Route::get('/uploadtest', 'FilmsController@videostest');
Route::post('/uploadtest', 'FilmsController@uploadvideotest');*/

// Route to view single video

Route::get('/videos/{vimeo_id}', "FilmsController@viewVideo");

// update number of likes of a video

Route::get('/video/likes/{filmid}','FilmsController@updateVideoLikes');
Route::get('/video/mostlikes/{filmid}','FilmsController@updateVideoMostLikes');
Route::post('/video/review/{filmid}','ReviewsController@updateVideoReview');


//edit your review 

Route::post('/review/update/{review_id}','ReviewsController@updateReview');

//to vote a review helpful or not

Route::get('/review/helpful/{review_id}','ReviewsController@updateReviewHelpful');


//load more for film using ajax
Route::get('/films/ajaxdata', 'FilmsController@numberOfFilms');
Route::get('/reviews/ajaxdata', 'ReviewsController@numberOfReviews');

//ajax search of films using genre and location on home page
Route::get('/search/films', 'FilmsController@searchAjaxHome');

//ajax search of films using genre and location on Upload Page
Route::get('/search/films/upload', 'FilmsController@searchAjaxUpload');

//ajax search of films crew
Route::get('/search/autocomplete', 'FilmsController@autocomplete');

//autocomplete search of films location on sign up page
Route::get('/search/autocompleteLocation', 'UserController@autocompleteLocation');

//load more for film using ajax on upload page
Route::get('/films/ajaxdataupload', 'FilmsController@numberOfFilmsUpload');


//to update users challeges on profile page
Route::get('/user/update/challenge', 'UserController@updateChallenges');


//to get users heat and fame score on wp profile page
Route::get('/user/fameheatscore/{id}', 'UserController@heatAndFameScore');
Route::get('/user/heatscore/{id}', 'ReviewsController@getHeatScore');

Route::get('/thankyou', 'FilmsController@thankyou');

Route::POST('/upload/progress', 'FilmsController@uploadprogress');


//url settings in admin dashboard

Route::get('/admin/Settings/url', 'SiteSettingsController@adminSettingsUrl');
Route::post('/admin/Settings/url', "SiteSettingsController@updateSettingsUrl");


Route::get('test1', 'UserController@getTheWpSiteUrl');