<?php

namespace App\Http\Controllers;
use App\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;

class AuthUserController extends Controller
{
    
    public function show(){

        return new UserResource(auth()->user());

    }

}
