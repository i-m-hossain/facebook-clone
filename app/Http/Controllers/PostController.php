<?php

namespace App\Http\Controllers;


use App\Friend;
use App\Http\Resources\PostCollection;
use App\Http\Resources\Post as PostResource;
use App\Post;

class PostController extends Controller
{
    
    public function index()
    {
        $friends = Friend::friendships();

        //if a user have no friends retrieves only his post
        if($friends->isEmpty()){

            return new PostCollection(request()->user()->posts);
        }

        //if user have friends retieves all the posts
        return new PostCollection(

            Post::whereIn('user_id', [$friends->pluck('user_id'), $friends->pluck('friend_id')])
                ->get()
        );        
        
    }

    public function store(){

        $data = request()->validate([

            'data.attributes.body' =>'',
        ]);

        

        $post = request()->user()->posts()-> create($data['data']['attributes']);
        return new PostResource($post);
    }
}
