<?php

namespace Tests\Feature;
use App\User;
use App\Friend;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FriendsTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_user_can_send_a_friend_request()
    {
        
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $anotherUser = factory(User::class)->create();

        $response = $this->post('/api/friend-request', [
            'friend_id' => $anotherUser->id,
        ])->assertStatus(200);

        $friendRequest = Friend::first();

        $this->assertNotNull($friendRequest);
        $this->assertEquals($anotherUser->id, $friendRequest->friend_id);
        $this->assertEquals($user->id, $friendRequest->user_id);
        $response->assertJson([
            'data' => [
                'type' => 'friend-request',
                'friend_request_id' => $friendRequest->id,
                'attributes' => [
                    'confirmed_at' => null,
                ]
            ],
            'links' => [
                'self' => url('/users/' . $anotherUser->id),
            ]
        ]);
    }

    /** @test */

    public function only_valid_users_can_be_friend_requested()
    {

        
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $response = $this->post('/api/friend-request', [
            'friend_id' => 123,
        ])->assertStatus(404);

        $this->assertNull(\App\Friend::first());

        $response->assertJson([

            'erorrs' => [

                'code' => 404,
                'title' => 'user not found',
                'detail' => 'unable to loacate the user with the given information'


            ]


        ]);


    }


    /** @test */

    public function friend_request_can_be_accepted()
    {

        $this->actingAs($user = factory(\App\User::class)->create(), 'api');
        $anotherUser = factory(\App\User::class)->create();

        $this->post('/api/friend-request',[
            'friend_id' => $anotherUser->id
        ])->assertStatus(200);

        $response = $this->actingAs($anotherUser, 'api')
            ->post('/api/friend-request-response',[
                'user_id' => $user->id,
                'status' => 1,
            ])->assertStatus(200);

        $friendRequest = \App\Friend::first(); //completed friend request  and accepted
        $this->assertNotNull($friendRequest->confirmed_at);     //making it is not null
        $this->assertInstanceOf(Carbon::class, $friendRequest->confirmed_at);     //Carbon instance
        $this->assertEquals(now()->startOfSecond() , $friendRequest->confirmed_at);   //asserting the values 

        $this->assertEquals(1, $friendRequest->status);

        $response->assertJson([

            'data' => [

                'type' => 'friend-request',
                'friend_request_id' => $friendRequest->id ,

                'attributes' =>[

                    'confirmed_at' => $friendRequest->confirmed_at->diffForHumans(),

                ]
            ],

            'links' =>[

                'self' =>   url('/users/'.$anotherUser->id),
            ]
        ]);


    }

}
