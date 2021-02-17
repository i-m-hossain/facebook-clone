<?php

namespace App\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    /** 
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json([
           'erorrs' => [

                'code' => 404,
                'title' => 'user not found',
                'detail' => 'unable to loacate the user with the given information'

           ]
        ],404);
    }
}
