<?php

namespace Tests\Feature;

use Tests\TestCase;
use MWazovzky\Taggable\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TagsOperatinsTest extends TestCase
{
    use DatabaseMigrations;


    public function guest_may_not_create_new_tag()
    {
        $tagName = 'TagName';
        $tag = new Tag(['name' => $tagName ]);

        $this->postJson(route('tags.store'), $tag->toArray())
            ->assertStatus(401);

        $this->assertDatabaseMissing('tags', ['name' => $tagName]);
    }

    /** @test */
    public function authenticated_user_can_create_tag()
    {
        // $this->withoutExceptionHandling();

        $this->signIn();
        $tagName = 'TagName';
        $tag = new Tag(['name' => $tagName ]);

        $this->postJson(route('tags.store'), $tag->toArray())->assertStatus(201);

        $this->assertDatabaseHas('tags', ['name' => $tagName]);
    }

    /** @test */
    public function user_can_get_list_of_tags()
    {
        $this->signIn();

        $tagName = 'TagName';
        $tag = Tag::create(['name' => $tagName]);

        $this->getJson(route('tags.index'))
            ->assertStatus(200)
            ->assertJsonFragment(['name' => $tagName]);
    }

    protected function signIn()
    {
        $user = factory('App\User')->create();
        $this->be($user);
        return $user;
    }
}
