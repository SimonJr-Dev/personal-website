@extends('admin.auth-layout')

@section('title', 'Sign in')
@section('heading', 'Sign in')

@section('content')

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf

        <div class="field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                autocomplete="username">
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password">
        </div>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <button class="save-btn" type="submit">Login</button>

    </form>

    <div class="helper">
        <a href="{{ route('admin.forgot-password') }}">Forgot password?</a>
    </div>

@endsection
