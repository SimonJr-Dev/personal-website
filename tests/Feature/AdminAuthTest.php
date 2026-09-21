<?php

namespace Tests\Feature;

use App\Mail\AdminPasswordChanged;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Keep the credential and content files out of the real storage dir.
        Storage::fake('local');

        config([
            'admin.email' => 'admin@example.test',
            'admin.password' => 'admin123',
        ]);
    }

    /**
     * Put the session into the signed-in state without going through the form.
     */
    protected function signedIn(): static
    {
        return $this->withSession(['admin_email' => 'admin@example.test']);
    }

    public function test_admin_can_sign_in_with_the_seeded_password(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@example.test',
            'password' => 'admin123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertSame('admin@example.test', session('admin_email'));
    }

    public function test_sign_in_is_rejected_for_a_wrong_password(): void
    {
        $response = $this->from(route('admin.login'))->post(route('admin.login.submit'), [
            'email' => 'admin@example.test',
            'password' => 'not-the-password',
        ]);

        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHasErrors('login');
        $this->assertNull(session('admin_email'));
    }

    public function test_sign_in_is_rejected_for_an_unknown_email(): void
    {
        $response = $this->from(route('admin.login'))->post(route('admin.login.submit'), [
            'email' => 'someone-else@example.test',
            'password' => 'admin123',
        ]);

        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHasErrors('login');
        $this->assertNull(session('admin_email'));
    }

    public function test_guest_is_redirected_from_the_dashboard(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
    }

    public function test_guest_is_redirected_from_settings(): void
    {
        $this->get(route('admin.settings'))->assertRedirect(route('admin.login'));
    }

    public function test_session_for_a_no_longer_allowed_email_is_rejected(): void
    {
        $response = $this->withSession(['admin_email' => 'old-admin@example.test'])
            ->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_signed_in_admin_sees_the_dashboard(): void
    {
        $this->signedIn()->get(route('admin.dashboard'))->assertOk();
    }

    public function test_logout_clears_the_session(): void
    {
        $response = $this->signedIn()->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
        $this->assertNull(session('admin_email'));
    }

    public function test_password_reset_is_disabled(): void
    {
        $response = $this->post(route('admin.forgot-password.submit'), [
            'email' => 'admin@example.test',
        ]);

        $response->assertRedirect(route('admin.login'));
        $this->assertSame(
            'Password reset is disabled. Sign in and change your password from the settings page.',
            session('status')
        );
    }

    public function test_admin_can_change_password_and_is_notified(): void
    {
        Mail::fake();

        $response = $this->signedIn()
            ->from(route('admin.settings'))
            ->post(route('admin.settings.update'), [
                'current_password' => 'admin123',
                'new_password' => 'NewAdmin456',
                'new_password_confirmation' => 'NewAdmin456',
            ]);

        $response->assertRedirect(route('admin.settings'));
        $this->assertSame(
            'Password updated successfully. A notification email was sent to admin@example.test.',
            session('status')
        );

        Mail::assertSent(AdminPasswordChanged::class, 1);

        $this->flushSession();

        $this->post(route('admin.login.submit'), [
            'email' => 'admin@example.test',
            'password' => 'NewAdmin456',
        ])->assertRedirect(route('admin.dashboard'));
    }

    public function test_changed_password_is_not_stored_in_plain_text(): void
    {
        $this->signedIn()->post(route('admin.settings.update'), [
            'current_password' => 'admin123',
            'new_password' => 'NewAdmin456',
            'new_password_confirmation' => 'NewAdmin456',
        ]);

        $stored = Storage::disk('local')->get('admin-credentials.json');

        $this->assertStringNotContainsString('NewAdmin456', $stored);
    }

    public function test_password_change_requires_the_correct_current_password(): void
    {
        Mail::fake();

        $response = $this->signedIn()
            ->from(route('admin.settings'))
            ->post(route('admin.settings.update'), [
                'current_password' => 'wrong-password',
                'new_password' => 'NewAdmin456',
                'new_password_confirmation' => 'NewAdmin456',
            ]);

        $response->assertRedirect(route('admin.settings'));
        $response->assertSessionHasErrors('current_password');

        Mail::assertNothingSent();
    }

    public function test_password_change_rejects_a_short_password(): void
    {
        $response = $this->signedIn()
            ->from(route('admin.settings'))
            ->post(route('admin.settings.update'), [
                'current_password' => 'admin123',
                'new_password' => 'short',
                'new_password_confirmation' => 'short',
            ]);

        $response->assertSessionHasErrors('new_password');
    }

    public function test_admin_can_edit_portfolio_content(): void
    {
        $response = $this->signedIn()
            ->from(route('admin.dashboard'))
            ->post(route('admin.dashboard.update'), [
                'hero_name' => 'Marco',
                'hero_last_name' => 'Simon',
                'hero_role' => 'IT Developer',
                'hero_description' => 'Updated description.',
                'about_text' => 'Updated about text.',
            ]);

        $response->assertRedirect(route('admin.dashboard'));

        $this->get('/')
            ->assertOk()
            ->assertSee('Updated description.')
            ->assertSee('Updated about text.');
    }

    public function test_guest_cannot_edit_portfolio_content(): void
    {
        $response = $this->post(route('admin.dashboard.update'), [
            'hero_name' => 'Someone',
            'hero_last_name' => 'Else',
            'hero_role' => 'Intruder',
            'hero_description' => 'Should not be saved.',
            'about_text' => 'Should not be saved.',
        ]);

        $response->assertRedirect(route('admin.login'));
        Storage::disk('local')->assertMissing('portfolio-content.json');
    }
}
