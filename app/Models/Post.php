<?php

namespace App\Models;

use App\Support\SiteContent;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image_path',
        'is_published',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Posts are addressed by slug in public URLs.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Posts that are live: flagged as published, and not scheduled for later.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->where(function (Builder $query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    /**
     * This site has a single author, so there is no users table to join.
     * The name comes from the same content the portfolio hero uses.
     *
     * @return array{name: string, avatar: string}
     */
    public function author(): array
    {
        $site = SiteContent::all();

        return [
            'name' => trim($site['hero_name'].' '.$site['hero_last_name']),
            'avatar' => asset('images/2x2-pic.jpg'),
        ];
    }

    /**
     * The date shown on the post — when it went live, falling back to creation.
     */
    public function displayedAt(): Carbon
    {
        return $this->published_at ?? $this->created_at;
    }

    public function imageUrl(): ?string
    {
        return $this->image_path ? asset('storage/'.$this->image_path) : null;
    }

    /**
     * Whether the content is long enough to need a "Read more" link.
     */
    public function isLong(int $limit = 280): bool
    {
        return Str::length($this->content) > $limit;
    }

    public function excerpt(int $limit = 280): string
    {
        return Str::limit($this->content, $limit);
    }

    /**
     * Build a slug that does not collide with an existing post.
     */
    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'post';
        $slug = $base;
        $suffix = 2;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn (Builder $query) => $query->whereKeyNot($ignoreId))
            ->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
