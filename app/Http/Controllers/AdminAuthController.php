<?php

namespace App\Http\Controllers;

use App\Mail\AdminPasswordChanged;
use App\Support\AdminCredentials;
use App\Support\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! AdminCredentials::verify($request->email, $request->password)) {
            return back()->withErrors([
                'login' => 'Invalid email or password.',
            ])->onlyInput('email');
        }

        // Guard against session fixation now that the session is privileged.
        $request->session()->regenerate();
        $request->session()->put('admin_email', AdminCredentials::email());

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_email');
        $request->session()->regenerate();

        return redirect()->route('admin.login');
    }

    /**
     * Password reset is not wired up: there is no database to store reset
     * tokens in, and the account password is changed from the settings page.
     */
    public function showForgotPasswordForm()
    {
        return view('admin.forgot-password');
    }

    public function sendPasswordResetLink(Request $request)
    {
        return $this->passwordResetDisabled();
    }

    public function showResetPasswordForm(Request $request)
    {
        return view('admin.reset-password', [
            'token' => $request->query('token'),
            'type' => $request->query('type'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        return $this->passwordResetDisabled();
    }

    protected function passwordResetDisabled()
    {
        return redirect()->route('admin.login')
            ->with('status', 'Password reset is disabled. Sign in and change your password from the settings page.');
    }

    public function dashboard()
    {
        return view('admin.dashboard', [
            'adminEmail' => AdminCredentials::email(),
            'usingDefaultPassword' => AdminCredentials::isDefault(),
            'site' => SiteContent::all(),
        ]);
    }

    public function updateSiteContent(Request $request)
    {
        $validated = $request->validate([
            'hero_name' => ['required', 'string', 'max:40'],
            'hero_last_name' => ['required', 'string', 'max:40'],
            'hero_role' => ['required', 'string', 'max:120'],
            'hero_description' => ['required', 'string', 'max:500'],
            'about_text' => ['required', 'string', 'max:500'],
        ]);

        SiteContent::merge($validated);

        return back()->with('status', 'Portfolio content updated successfully.');
    }

    public function settings()
    {
        return view('admin.settings', [
            'adminEmail' => AdminCredentials::email(),
            'usingDefaultPassword' => AdminCredentials::isDefault(),
        ]);
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $email = AdminCredentials::email();

        if (! AdminCredentials::verify($email, $request->current_password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        AdminCredentials::update($request->new_password);

        Mail::to($email)->send(new AdminPasswordChanged($email));

        return redirect()->route('admin.settings')
            ->with('status', 'Password updated successfully. A notification email was sent to '.$email.'.');
    }
}
