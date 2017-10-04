<?php

namespace App\Http\Controllers;
use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store($id)
    {
    	$this->validate(request(), [
    		'body' => 'required|max:255'
    	]);
    	$comment =new Comment;
    	$comment->body = request('body');
        $comment->user_id = auth()->id();
    	$comment->post_id = $id;
    	$comment->save();
    	return back();
    }
}
