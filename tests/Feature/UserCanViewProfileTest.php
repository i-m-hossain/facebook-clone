<?php

namespace Tests\Feature;

use App\User;
use App\Post;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCanViewProfileTest extends TestCase
{
    
    /** @test */
    use RefreshDatabase;

    public function a_user_can_view_user_profile()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $posts = factory(Post::class)->create();

        $response = $this->get('/api/users/'.$user->id);

        $response->assertStatus(200)
            ->assertJson([

                'data' => [

                    'type'       =>     'users',
                    'user_id'    =>     $user->id,
                    'attributes' =>     [

                        'name' => $user->name,
                        
                    ]
                ],
                'links' => [

                    'self' => url('/users/' .$user->id),

                ]    




            ]);



    }
}
