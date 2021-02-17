<?php

namespace App\Http\Controllers;

use App\Exceptions\UserNotFoundException;
use App\Http\Resources\Friend as FriendResource;
use App\Friend;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class FriendRequestController extends Controller
{
    //
    public function store()

    {
        $data = request()->validate([

            'friend_id' => ''
        ]);

        try{

            User::findOrFail($data['friend_id'])
            ->friends()->attach(auth()->user());

        }catch(ModelNotFoundException $e){

            throw new UserNotFoundException();
        }
        

        return new FriendResource(

            Friend::where('user_id', auth()->user()
            ->id)->where('friend_id', $data['friend_id'])
            ->first()
        );
    }
}
