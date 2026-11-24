<?php

namespace Tests\Feature;

use App\Models\CertificateVerification;
use App\Models\Page;
use App\Models\User;
use Database\Seeders\LanguageSeeder;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Mockery;
use Tests\TestCase;

class PublicWorkflowSecurityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        $paths = array_filter(glob(database_path('migrations/*.php')), fn ($path) =>
            !str_contains($path, 'expand_content_block_translation_title')
            && !str_contains($path, 'backfill_agreement_archive_documents'));
        $this->artisan('migrate', ['--path' => array_values($paths), '--realpath' => true])->assertSuccessful();
    }

    public function test_recovery_preserves_password_and_reset_token_expires_and_is_single_use(): void
    {
        config(['mail.default' => 'smtp', 'app.url' => 'https://admin.example.test']);
        $user = User::factory()->create();
        $hash = $user->password;
        $token = '';
        Mail::shouldReceive('send')->once()->andReturnUsing(function ($view, $data) use (&$token): void {
            $this->assertSame('emails.admin-password-recovery', $view);
            $this->assertStringStartsWith('https://admin.example.test/admin/password/reset/', $data['resetUrl']);
            $token = basename(parse_url($data['resetUrl'], PHP_URL_PATH));
        });
        $this->post(route('admin.password.email'), ['email' => $user->email])->assertSessionHas('success');
        $this->assertSame($hash, $user->fresh()->password);
        $this->assertNotSame($token, DB::table('password_reset_tokens')->value('token'));

        $data = ['email' => $user->email, 'token' => $token, 'password' => 'New-example-passphrase', 'password_confirmation' => 'New-example-passphrase'];
        $this->get(route('admin.password.reset', ['token' => $token, 'email' => $user->email]))->assertOk()->assertSee('Elegir nueva contraseña');
        $this->post(route('admin.password.update'), $data)->assertRedirect(route('login'));
        $this->assertTrue(Hash::check($data['password'], $user->fresh()->password));
        $this->post(route('admin.password.update'), $data)->assertSessionHasErrors('email');

        $token = Password::createToken($user);
        $this->travel(61)->minutes();
        $data['token'] = $token;
        $this->post(route('admin.password.update'), $data)->assertSessionHasErrors('email');
    }

    public function test_recovery_mail_failure_does_not_change_password_or_reveal_account(): void
    {
        config(['mail.default' => 'smtp']);
        $user = User::factory()->create();
        $hash = $user->password;
        Mail::shouldReceive('send')->once()->andThrow(new \RuntimeException('Synthetic delivery failure'));
        $response = $this->post(route('admin.password.email'), ['email' => $user->email]);
        $response->assertSessionHas('success');
        $message = session('success');
        $this->post(route('admin.password.email'), ['email' => 'unknown@example.test'])->assertSessionHas('success', $message);
        $this->assertSame($hash, $user->fresh()->password);
    }

    public function test_login_is_throttled_and_successful_login_clears_attempts(): void
    {
        $user = User::factory()->create(['password' => Hash::make('Known-example-password')]);
        for ($i = 0; $i < 5; $i++) {
            $this->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'wrong'])->assertSessionHasErrors('email');
        }
        $this->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'Known-example-password'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();
        $this->travel(61)->seconds();
        $this->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'Known-example-password'])
            ->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_appointment_requires_contact_and_sends_personal_reply_address_to_institution(): void
    {
        foreach (['es' => 'Escribe tu nombre completo.', 'en' => 'Enter your full name.'] as $locale => $message) {
            $this->postJson('/api/appointments', ['locale' => $locale])->assertUnprocessable()
                ->assertJsonValidationErrors(['name', 'email'])->assertJsonPath('errors.name.0', $message);
        }
        config(['mail.default' => 'smtp', 'dric.appointments.recipient_email' => 'rrii@umss.edu.bo', 'dric.appointments.recipient_name' => 'DRIC']);
        $payload = ['name' => 'Example Visitor', 'email' => 'visitor@gmail.com', 'topic' => 'Other', 'message' => 'Synthetic request', 'consent' => true, 'locale' => 'en'];
        Mail::shouldReceive('send')->twice()->andReturnUsing(function ($view, $data, $callback): void {
            $message = Mockery::mock(\Illuminate\Mail\Message::class);
            $message->shouldReceive('to')->with(config('dric.appointments.recipient_email'), 'DRIC')->once()->andReturnSelf();
            $message->shouldReceive('replyTo')->with('visitor@gmail.com', 'Example Visitor')->once()->andReturnSelf();
            $message->shouldReceive('subject')->once()->andReturnSelf();
            $callback($message);
        });
        $this->postJson('/api/appointments', $payload)->assertOk();
        config(['dric.appointments.recipient_email' => 'future-office@example.org']);
        $this->postJson('/api/appointments', $payload)->assertOk();

        foreach ([null, 'invalid-address'] as $recipient) {
            config(['dric.appointments.recipient_email' => $recipient]);
            $this->postJson('/api/appointments', $payload)->assertStatus(503);
        }
    }

    public function test_certificate_saving_preserves_omitted_records_and_rejects_stale_edits(): void
    {
        $this->seed(LanguageSeeder::class);
        $user = User::factory()->create();
        config(['dric.admin.email' => $user->email]);
        $this->seed(RolePermissionSeeder::class);
        $page = Page::create(['slug' => 'validar-certificado', 'status' => 'published']);
        $this->actingAs($user);
        $content = ['eyebrow' => 'Certificados', 'title' => 'Verificar Certificado', 'description' => 'Example'];
        $payload = ['es' => $content, 'en' => $content];
        $cert = ['code' => 'Q2W3E4R', 'full_name' => 'Example Person', 'certificate_type' => 'Asistencia', 'description_es' => 'Example', 'issue_date' => '2026-11-20', 'is_active' => true];
        $existing = CertificateVerification::create(['code' => 'B7T3SG9', 'full_name' => 'Protected Person', 'certificate_type' => 'Asistencia', 'issue_date' => '2026-11-20', 'is_active' => true]);
        $url = route('admin.pages.certificates.update', $page);
        $this->put($url, $payload + ['certificates' => [$cert]])->assertSessionHasNoErrors();
        $id = CertificateVerification::where('code', $cert['code'])->value('id');
        $this->assertTrue(CertificateVerification::whereKey($id)->whereDate('issue_date', '2026-11-20')->exists());
        foreach (['es', 'en'] as $locale) {
            $this->postJson('/api/certificates/verify', ['code' => $cert['code'], 'locale' => $locale])
                ->assertOk()->assertJsonPath('data.issue_date', '2026-11-20');
        }
        $invalidDate = array_merge($cert, ['code' => 'Z2X3C4V', 'issue_date' => '2026-11-20T00:00:00Z']);
        $this->put($url, $payload + ['certificates' => [$invalidDate]])
            ->assertSessionHasErrors('certificates.0.issue_date');
        $this->assertDatabaseMissing('certificate_verifications', ['code' => 'Z2X3C4V']);
        $this->assertDatabaseHas('certificate_verifications', ['id' => $existing->id, 'is_active' => true]);
        $view = $this->get(route('admin.pages.certificates.edit', $page))->assertOk();
        $row = collect($view->viewData('certificates'))->firstWhere('id', $id);
        $this->assertSame('2026-11-20', $row['issue_date']);
        $record = CertificateVerification::findOrFail($id);
        $record->update(['description' => 'Changed by another editor']);
        $this->put($url, $payload + ['certificates' => [$row]])->assertSessionHasErrors('certificates.0.code');
        $this->assertDatabaseHas('certificate_verifications', ['id' => $id, 'description' => 'Changed by another editor']);
        $this->put($url, $payload)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('certificate_verifications', ['id' => $id]);
        $this->assertDatabaseCount('certificate_change_logs', 1);

        $row = collect($this->get(route('admin.pages.certificates.edit', $page))->viewData('certificates'))->firstWhere('id', $id);
        $row['is_active'] = false;
        $this->put($url, $payload + ['certificates' => [$row]])->assertSessionHasNoErrors();
        $this->assertDatabaseHas('certificate_verifications', ['id' => $id, 'is_active' => false]);
        $this->assertDatabaseCount('certificate_change_logs', 2);
        $this->assertNotNull(DB::table('certificate_change_logs')->latest('id')->value('before'));

        $user->syncRoles('Editor_Media');
        $second = array_merge($cert, ['code' => 'T2Y3U4I', 'full_name' => 'Second Person']);
        $this->put($url, $payload + ['certificates' => [$second]])->assertSessionHasNoErrors();
        $this->assertDatabaseHas('certificate_verifications', ['code' => 'T2Y3U4I']);
        $this->assertDatabaseHas('certificate_verifications', ['id' => $existing->id, 'is_active' => true]);
        $this->assertDatabaseHas('certificate_verifications', ['id' => $id, 'is_active' => false]);
        $this->assertDatabaseCount('certificate_change_logs', 3);
    }
}
