<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

	protected $fillable = ['title', 'body', 'user_id'];
     public function comments(){
     	return $this->hasMany(Comment::class);
     }
     public static function getPost($id){
     	return Post::first();
     }

     public function user()
     {
         return $this->belongsTo(User::class);
     }
    /* public function updatePost(array $id, array $data)
     {
     	$post = Post::find($id->id);
     	$post->title = $data->title;
     	$post->body = $data->body;
     	$post->save();
     	return true;
     }*/
 
	
}    
