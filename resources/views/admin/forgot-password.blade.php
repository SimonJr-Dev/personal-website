@extends('admin.auth-layout')

@section('title', 'Forgot password')
@section('heading', 'Forgot password')

@section('content')

    <p class="meta" style="font-size:14px">
        Password reset by email is not available on this site. Sign in and change your password from the settings page.
    </p>

    <form method="POST" action="{{ route('admin.forgot-password.submit') }}">
        @csrf

        <div class="field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button class="save-btn" type="submit">Continue</button>

    </form>

    <div class="helper">
        <a href="{{ route('admin.login') }}">&larr; Back to login</a>
    </div>

@endsection
