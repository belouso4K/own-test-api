<?php
namespace Tests\Feature\API\Post;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class LoadPostsTest extends TestCase
{
    use RefreshDatabase;

    public function testNoPostsLoad()
    {
        $response = $this->getJson('/api/v1/posts');
        $response
            ->assertStatus(200);

    }

    public function testFivePostsLoaded()
    {
        $users = Post::factory()->count(5)->create();

        $response = $this->getJson('/api/v1/posts');
        $response
            ->assertStatus(200);

//        php artisan test
    }

}
