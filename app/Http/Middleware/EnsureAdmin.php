<?php

namespace App\Http\Middleware;

use App\Support\AdminCredentials;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $email = $request->session()->get('admin_email');

        // The allowed address can change in config, so re-check it on every
        // request rather than trusting whatever was put in the session.
        if (! is_string($email) || ! hash_equals(AdminCredentials::email(), $email)) {
            $request->session()->forget('admin_email');

            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
