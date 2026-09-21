<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

/**
 * File-backed store for the editable portions of the public portfolio page.
 */
class SiteContent
{
    protected const FILE = 'portfolio-content.json';

    /**
     * The fields the admin dashboard may edit, with their defaults.
     *
     * @var array<string, string>
     */
    public const DEFAULTS = [
        'hero_name' => 'Marco',
        'hero_last_name' => 'Simon',
        'hero_role' => 'IT Developer · Administrative Support',
        'hero_description' => 'I help teams stay organized, build useful digital tools, and move everyday work forward with care and consistency.',
        'about_text' => 'A recent Bachelor of Science in Information Technology graduate with hands-on experience in development, administrative operations, and project coordination.',
    ];

    /**
     * The stored content, with defaults filled in for anything not yet edited.
     *
     * @return array<string, string>
     */
    public static function all(): array
    {
        return array_merge(static::DEFAULTS, static::stored());
    }

    /**
     * Merge the given fields into the stored content.
     *
     * @param  array<string, string>  $fields
     */
    public static function merge(array $fields): void
    {
        $content = array_merge(static::stored(), $fields);

        Storage::disk('local')->put(
            static::FILE,
            json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );
    }

    /**
     * The raw contents of the JSON file, or an empty array if it is missing or invalid.
     *
     * @return array<string, string>
     */
    protected static function stored(): array
    {
        if (! Storage::disk('local')->exists(static::FILE)) {
            return [];
        }

        $decoded = json_decode(Storage::disk('local')->get(static::FILE), true);

        return is_array($decoded) ? $decoded : [];
    }
}
