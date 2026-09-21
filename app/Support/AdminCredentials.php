<?php

namespace App\Support;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * The single admin account, stored as a hash on the local disk.
 *
 * There is no database in this project, so the password lives in a JSON file
 * outside the web root. It is seeded from config('admin.password') the first
 * time it is needed and is only ever stored hashed.
 */
class AdminCredentials
{
    protected const FILE = 'admin-credentials.json';

    /**
     * The one email address allowed to sign in.
     */
    public static function email(): string
    {
        return strtolower(trim((string) config('admin.email')));
    }

    /**
     * Whether the given email and password match the admin account.
     */
    public static function verify(string $email, string $password): bool
    {
        // Hash::check() is run unconditionally so a wrong email takes the same
        // time as a wrong password.
        $passwordMatches = Hash::check($password, static::hash());

        return hash_equals(static::email(), strtolower(trim($email))) && $passwordMatches;
    }

    /**
     * Replace the stored password.
     */
    public static function update(string $password): void
    {
        static::store(Hash::make($password));
    }

    /**
     * Whether the account is still on the password shipped in config.
     */
    public static function isDefault(): bool
    {
        return Hash::check((string) config('admin.password'), static::hash());
    }

    /**
     * The stored password hash, seeding the file on first use.
     */
    protected static function hash(): string
    {
        $stored = static::stored();

        if (isset($stored['password']) && is_string($stored['password']) && $stored['password'] !== '') {
            return $stored['password'];
        }

        $hash = Hash::make((string) config('admin.password'));

        static::store($hash);

        return $hash;
    }

    protected static function store(string $hash): void
    {
        Storage::disk('local')->put(
            static::FILE,
            json_encode(['password' => $hash], JSON_PRETTY_PRINT)
        );
    }

    /**
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
