<?php

namespace App\Http\Controllers;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function __construct()
    {   
        $this->middleware('auth')->except(['postview','show']);
    }
     public function postView(){
     	return view("posts.index");
     }

     public function create(){
     	return view("posts.create");
     }

     public function store(){
     	$this->validate(request(),[
     		'title' => 'required',
     		'body' => 'required'
     	]);
     	
     	Post::create([
     		'title' => request('title'),
     		'body' => request('body'),
        'user_id' => auth()->id()
     	]);
     	return view('posts.index');
     }
     public function showPosts(){
          $posts = Post::all();
          return view('posts.lists',compact('posts'));
     }

     public function edit($id){
          $post = Post::find($id);
          return view('posts.edit',compact('post'));
     }
     public function update($id){
          $this->validate(request(), [
               'title' => 'required',
               'body' =>  'required'
          ]);
          $post = Post::find($id);
          $post->title = request('title');
          $post->body = request('body');
          $updatePost = $post->save();

          if($updatePost){
              return view('posts.index');
          }
          
     }

     public function deletePost($id){
        $deletepost= Post::find($id);
        $deletepost->delete();
        return back();
    }

    public function show(Post $post)
    {
      //$post = Post::find($id);
      return view('posts.post',compact('post'));
    }
 }
