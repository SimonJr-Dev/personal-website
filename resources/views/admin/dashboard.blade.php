@extends('admin.layout')

@section('title', 'Dashboard')
@section('heading', 'Welcome back.')
@section('subheading', 'Edit the copy that appears at the top of your portfolio.')

@section('content')

    @if ($usingDefaultPassword)
        <div class="warning">
            You are still using the default password.
            <a href="{{ route('admin.settings') }}">Change it in settings</a> before putting this site online.
        </div>
    @endif

    <div class="card">

        <div class="card-head">
            <h2>Portfolio content</h2>
            <span class="badge">Site admin</span>
        </div>

        <form method="POST" action="{{ route('admin.dashboard.update') }}">
            @csrf

            <div class="form-grid">

                <div class="field">
                    <label for="hero_name">Hero first name</label>
                    <input id="hero_name" type="text" name="hero_name" maxlength="40" required
                        value="{{ old('hero_name', $site['hero_name']) }}">
                    @error('hero_name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="hero_last_name">Hero last name</label>
                    <input id="hero_last_name" type="text" name="hero_last_name" maxlength="40" required
                        value="{{ old('hero_last_name', $site['hero_last_name']) }}">
                    @error('hero_last_name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field full">
                    <label for="hero_role">Role line</label>
                    <input id="hero_role" type="text" name="hero_role" maxlength="120" required
                        value="{{ old('hero_role', $site['hero_role']) }}">
                    @error('hero_role')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field full">
                    <label for="hero_description">Hero description</label>
                    <textarea id="hero_description" name="hero_description" maxlength="500" required>{{ old('hero_description', $site['hero_description']) }}</textarea>
                    @error('hero_description')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field full">
                    <label for="about_text">About text</label>
                    <textarea id="about_text" name="about_text" maxlength="500" required>{{ old('about_text', $site['about_text']) }}</textarea>
                    @error('about_text')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <button class="save-btn" type="submit">Save changes</button>

        </form>

    </div>

@endsection
