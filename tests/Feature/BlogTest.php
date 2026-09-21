<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_index_shows_an_empty_state_with_no_posts(): void
    {
        $this->get(route('blog.index'))
            ->assertOk()
            ->assertSee('No posts yet');
    }

    public function test_blog_index_lists_published_posts(): void
    {
        $post = Post::factory()->create(['title' => 'A published post']);

        $this->get(route('blog.index'))
            ->assertOk()
            ->assertSee($post->title)
            ->assertDontSee('No posts yet');
    }

    public function test_blog_index_hides_drafts_and_scheduled_posts(): void
    {
        $draft = Post::factory()->draft()->create(['title' => 'Still a draft']);
        $scheduled = Post::factory()->scheduled()->create(['title' => 'Out next week']);
        $live = Post::factory()->create(['title' => 'Live right now']);

        $response = $this->get(route('blog.index'));

        $response->assertSee($live->title);
        $response->assertDontSee($draft->title);
        $response->assertDontSee($scheduled->title);
    }

    public function test_blog_index_paginates_at_ten_posts(): void
    {
        Post::factory()->count(12)->create();

        $response = $this->get(route('blog.index'));

        $response->assertOk();
        $this->assertCount(10, $response->viewData('posts'));
        $response->assertSee('Load more posts');
    }

    public function test_second_page_shows_the_remaining_posts(): void
    {
        Post::factory()->count(12)->create();

        $response = $this->get(route('blog.index', ['page' => 2]));

        $response->assertOk();
        $this->assertCount(2, $response->viewData('posts'));
        $response->assertSee('You have reached the end');
    }

    public function test_single_post_page_renders(): void
    {
        $post = Post::factory()->create(['title' => 'Readable post']);

        $this->get(route('blog.show', $post->slug))
            ->assertOk()
            ->assertSee($post->title)
            ->assertSee('Back to blog');
    }

    public function test_draft_post_is_not_reachable_by_slug(): void
    {
        $post = Post::factory()->draft()->create();

        $this->get(route('blog.show', $post->slug))->assertNotFound();
    }

    public function test_scheduled_post_is_not_reachable_before_its_date(): void
    {
        $post = Post::factory()->scheduled()->create();

        $this->get(route('blog.show', $post->slug))->assertNotFound();
    }

    public function test_unknown_slug_returns_404(): void
    {
        $this->get(route('blog.show', 'no-such-post'))->assertNotFound();
    }

    public function test_long_posts_are_truncated_with_a_read_more_toggle(): void
    {
        Post::factory()->create(['content' => str_repeat('word ', 200)]);

        $this->get(route('blog.index'))->assertSee('Read more');
    }

    public function test_short_posts_have_no_read_more_toggle(): void
    {
        Post::factory()->create(['content' => 'Short and sweet.']);

        $this->get(route('blog.index'))->assertDontSee('Read more');
    }

    public function test_post_without_an_image_skips_the_media_block(): void
    {
        Post::factory()->create(['image_path' => null]);

        $this->get(route('blog.index'))
            ->assertOk()
            ->assertDontSee('post-media');
    }

    public function test_post_with_an_image_renders_the_media_block(): void
    {
        Post::factory()->create(['image_path' => 'posts/example.jpg']);

        $this->get(route('blog.index'))
            ->assertOk()
            ->assertSee('post-media');
    }

    public function test_blog_link_appears_in_the_navigation(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee(route('blog.index'));
    }

    public function test_blog_link_is_marked_active_on_the_blog(): void
    {
        $this->get(route('blog.index'))
            ->assertOk()
            ->assertSee('is-active');
    }

    public function test_author_name_follows_the_editable_site_content(): void
    {
        $post = Post::factory()->create();

        $this->assertSame('Marco Simon', $post->author()['name']);
    }
}
