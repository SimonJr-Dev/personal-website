@extends('admin.auth-layout')

@section('title', 'Reset password')
@section('heading', 'Reset password')

@section('content')

    <p class="meta" style="font-size:14px">
        Password reset by email is not available on this site. Sign in and change your password from the settings page.
    </p>

    <form method="POST" action="{{ route('admin.reset-password.submit') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="type" value="{{ $type }}">

        <div class="field">
            <label for="password">New password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password">
        </div>

        <button class="save-btn" type="submit">Continue</button>

    </form>

    <div class="helper">
        <a href="{{ route('admin.login') }}">&larr; Back to login</a>
    </div>

@endsection
