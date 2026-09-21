<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPostTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
        Storage::fake('public');

        config(['admin.email' => 'admin@example.test', 'admin.password' => 'admin123']);
    }

    protected function signedIn(): static
    {
        return $this->withSession(['admin_email' => 'admin@example.test']);
    }

    /**
     * An uploaded image that does not need the GD extension, which this PHP
     * build does not have. UploadedFile::fake()->image() would require it.
     */
    protected function fakeImage(string $name = 'cover.jpg'): UploadedFile
    {
        return UploadedFile::fake()->create($name, 120, 'image/jpeg');
    }

    /**
     * @return array<string, mixed>
     */
    protected function validPost(array $overrides = []): array
    {
        return array_merge([
            'title' => 'A brand new post',
            'content' => 'Something worth writing down.',
            'is_published' => '1',
        ], $overrides);
    }

    public function test_guest_cannot_reach_any_post_screen(): void
    {
        $post = Post::factory()->create();

        $this->get(route('admin.posts.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.posts.create'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.posts.edit', $post))->assertRedirect(route('admin.login'));
        $this->post(route('admin.posts.store'), $this->validPost())->assertRedirect(route('admin.login'));
        $this->put(route('admin.posts.update', $post), $this->validPost())->assertRedirect(route('admin.login'));
        $this->delete(route('admin.posts.destroy', $post))->assertRedirect(route('admin.login'));

        $this->assertDatabaseCount('posts', 1);
    }

    public function test_admin_sees_the_post_list(): void
    {
        $post = Post::factory()->create(['title' => 'Listed post']);

        $this->signedIn()->get(route('admin.posts.index'))
            ->assertOk()
            ->assertSee('Listed post');
    }

    public function test_admin_can_create_a_post(): void
    {
        $response = $this->signedIn()->post(route('admin.posts.store'), $this->validPost());

        $response->assertRedirect(route('admin.posts.index'));

        $this->assertDatabaseHas('posts', [
            'title' => 'A brand new post',
            'slug' => 'a-brand-new-post',
            'is_published' => true,
        ]);
    }

    public function test_publishing_without_a_date_sets_published_at_to_now(): void
    {
        $this->signedIn()->post(route('admin.posts.store'), $this->validPost());

        $this->assertNotNull(Post::first()->published_at);
    }

    public function test_a_post_saved_as_a_draft_stays_hidden(): void
    {
        $this->signedIn()->post(route('admin.posts.store'), $this->validPost(['is_published' => null]));

        $post = Post::first();

        $this->assertFalse($post->is_published);
        $this->get(route('blog.index'))->assertDontSee($post->title);
    }

    public function test_creating_a_post_requires_a_title_and_content(): void
    {
        $this->signedIn()
            ->post(route('admin.posts.store'), ['title' => '', 'content' => ''])
            ->assertSessionHasErrors(['title', 'content']);

        $this->assertDatabaseCount('posts', 0);
    }

    public function test_duplicate_titles_get_distinct_slugs(): void
    {
        $this->signedIn()->post(route('admin.posts.store'), $this->validPost());
        $this->signedIn()->post(route('admin.posts.store'), $this->validPost());

        $this->assertSame(
            ['a-brand-new-post', 'a-brand-new-post-2'],
            Post::orderBy('id')->pluck('slug')->all()
        );
    }

    public function test_admin_can_upload_an_image(): void
    {
        $this->signedIn()->post(route('admin.posts.store'), $this->validPost([
            'image' => $this->fakeImage('cover.jpg'),
        ]));

        $post = Post::first();

        $this->assertNotNull($post->image_path);
        Storage::disk('public')->assertExists($post->image_path);
    }

    public function test_a_non_image_upload_is_rejected(): void
    {
        $this->signedIn()
            ->post(route('admin.posts.store'), $this->validPost([
                'image' => UploadedFile::fake()->create('notes.pdf', 40, 'application/pdf'),
            ]))
            ->assertSessionHasErrors('image');

        $this->assertDatabaseCount('posts', 0);
    }

    public function test_admin_can_update_a_post(): void
    {
        $post = Post::factory()->create(['title' => 'Old title']);

        $this->signedIn()
            ->put(route('admin.posts.update', $post), $this->validPost(['title' => 'New title']))
            ->assertRedirect(route('admin.posts.index'));

        $post->refresh();

        $this->assertSame('New title', $post->title);
        $this->assertSame('new-title', $post->slug);
    }

    public function test_replacing_an_image_deletes_the_old_file(): void
    {
        $post = Post::factory()->create([
            'image_path' => $this->fakeImage('old.jpg')->store('posts', 'public'),
        ]);

        $old = $post->image_path;

        $this->signedIn()->put(route('admin.posts.update', $post), $this->validPost([
            'image' => $this->fakeImage('new.jpg'),
        ]));

        Storage::disk('public')->assertMissing($old);
        Storage::disk('public')->assertExists($post->refresh()->image_path);
    }

    public function test_admin_can_remove_an_image_without_uploading_one(): void
    {
        $post = Post::factory()->create([
            'image_path' => $this->fakeImage('cover.jpg')->store('posts', 'public'),
        ]);

        $old = $post->image_path;

        $this->signedIn()->put(route('admin.posts.update', $post), $this->validPost([
            'remove_image' => '1',
        ]));

        $this->assertNull($post->refresh()->image_path);
        Storage::disk('public')->assertMissing($old);
    }

    public function test_unpublishing_hides_a_post_from_the_blog(): void
    {
        $post = Post::factory()->create(['title' => 'Going private']);

        $this->signedIn()->put(route('admin.posts.update', $post), $this->validPost([
            'title' => 'Going private',
            'is_published' => null,
        ]));

        $this->get(route('blog.index'))->assertDontSee('Going private');
        $this->get(route('blog.show', $post->slug))->assertNotFound();
    }

    public function test_admin_can_delete_a_post_and_its_image(): void
    {
        $post = Post::factory()->create([
            'image_path' => $this->fakeImage('cover.jpg')->store('posts', 'public'),
        ]);

        $path = $post->image_path;

        $this->signedIn()
            ->delete(route('admin.posts.destroy', $post))
            ->assertRedirect(route('admin.posts.index'));

        $this->assertDatabaseCount('posts', 0);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_sidebar_links_to_every_admin_section(): void
    {
        $response = $this->signedIn()->get(route('admin.posts.index'));

        $response->assertSee(route('admin.dashboard'));
        $response->assertSee(route('admin.posts.index'));
        $response->assertSee(route('admin.settings'));
        $response->assertSee('Sign out');
    }
}
