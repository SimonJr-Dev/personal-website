@extends('admin.layout')

@section('title', 'Settings')
@section('heading', 'Profile settings')
@section('subheading', 'Signed in as '.$adminEmail)

@section('content')

    @if ($usingDefaultPassword)
        <div class="warning">
            You are still using the default password. Set a new one below.
        </div>
    @endif

    <div class="card">

        <div class="card-head">
            <h2>Change password</h2>
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf

            <div class="form-grid">

                <div class="field">
                    <label for="current_password">Current password</label>
                    <input id="current_password" type="password" name="current_password" required
                        autocomplete="current-password">
                    @error('current_password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="new_password">New password</label>
                    <input id="new_password" type="password" name="new_password" required autocomplete="new-password">
                    <span class="hint">At least 8 characters.</span>
                    @error('new_password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="new_password_confirmation">Confirm new password</label>
                    <input id="new_password_confirmation" type="password" name="new_password_confirmation" required
                        autocomplete="new-password">
                </div>

            </div>

            <button class="save-btn" type="submit">Update password</button>

        </form>

    </div>

@endsection
