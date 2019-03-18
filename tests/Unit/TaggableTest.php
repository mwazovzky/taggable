<?php

namespace Tests\Unit;

use Tests\TestCase;
use MWazovzky\Taggable\Tag;
use MWazovzky\Taggable\Dummy;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TaggableTest extends TestCase
{
    use DatabaseMigrations;

    protected $dummy;

    public static function setUpBeforeClass()
    {
        //
    }

    protected function setUp() : void
    {
        parent::setUp();

        Dummy::createTable();

        $this->dummy = Dummy::create(['name' => 'Mary']);
    }

    protected function tearDown() : void
    {
        Dummy::deleteTable();
    }

    /** @test */
    function it_can_create_dummy_model()
    {
        $this->assertDatabaseHas('dummies', [
            'name' => $this->dummy->name
        ]);
    }

    /** @test */
    function it_can_create_tag()
    {
        $tag = Tag::create(['name' => 'tagName']);

        $this->assertDatabaseHas('tags', [
            'name' => $tag->name
        ]);
    }

    /** @test */
    function it_can_attach_tag_to_model()
    {
        $this->assertCount(0, $this->dummy->tags);

        $tag = Tag::create(['name' => 'tagName']);
        $this->dummy->tags()->attach($tag);

        $this->assertCount(1, $this->dummy->fresh()->tags);

        $this->assertDatabaseHas('taggables', [
            'tag_id' => $tag->id,
            'taggable_id' => $this->dummy->id,
            'taggable_type' => get_class($this->dummy),
        ]);
    }

    /** @test */
    public function it_can_detach_tags_from_model()
    {
        $tag = Tag::create(['name' => 'tagName']);
        $this->dummy->tags()->attach($tag);

        $this->assertCount(1, $this->dummy->tags);
        $this->dummy->tags()->detach($tag);

        $this->assertCount(0, $this->dummy->fresh()->tags);
    }

    /** @test */
    public function it_validates_tags()
    {
        $tagOne = Tag::create(['name' => 'tagOne']);
        $tagTwo = Tag::create(['name' => 'tagTwo']);

        $this->assertEquals(
            [$tagOne->id, $tagTwo->id],
            Tag::validate([$tagOne->name, $tagTwo->name])
        );

        $this->assertEquals(
            [$tagOne->id, $tagTwo->id],
            Tag::validate([$tagOne->name, $tagTwo->name, 'wrongName'])
        );

        $this->assertEquals(
            [],
            Tag::validate()
        );
    }

    /** @test */
    public function it_can_sync_tags()
    {
        $tagOne = Tag::create(['name' => 'tagOne']);
        $tagTwo = Tag::create(['name' => 'tagTwo']);
        $tagThree = Tag::create(['name' => 'tagThree']);

        $this->dummy->tags()->attach($tagOne);
        $this->dummy->tags()->attach($tagTwo);

        $this->assertTrue($this->dummy->tags->contains($tagOne));
        $this->assertTrue($this->dummy->tags->contains($tagTwo));
        $this->assertFalse($this->dummy->tags->contains($tagThree));

        $this->dummy->syncTags([$tagTwo->name, $tagThree->name]);
        $this->dummy = $this->dummy->fresh();

        $this->assertFalse($this->dummy->tags->contains($tagOne));
        $this->assertTrue($this->dummy->tags->contains($tagTwo));
        $this->assertTrue($this->dummy->tags->contains($tagThree));
    }

    /** @test */
    public function it_detachs_tags_when_model_is_deleted()
    {
        $tag = Tag::create(['name' => 'tagOne']);
        $this->dummy->tags()->attach($tag);

        $this->assertDatabaseHas('taggables', [
            'tag_id' => $tag->id,
            'taggable_id' => $this->dummy->id,
        ]);

        $this->dummy->delete();

        $this->assertDatabaseMissing('taggables', [
            'tag_id' => $tag->id,
            'taggable_id' => $this->dummy->id,
        ]);
    }

    protected function signIn()
    {
        $user = factory('App\User')->create();
        $this->be($user);
        return $user;
    }
}
