<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AdminSpanishMessagesTest extends TestCase
{
    public function test_admin_default_validation_stays_spanish_with_english_preferences(): void
    {
        config(['app.locale' => 'en', 'app.fallback_locale' => 'en']);
        $this->withHeader('Accept-Language', 'en')->postJson(route('admin.password.update'), [
            'locale' => 'en',
            'email' => 'example@example.org',
            'token' => 123,
            'password' => 'A-valid-new-password',
            'password_confirmation' => 'A-valid-new-password',
        ])->assertUnprocessable()->assertJsonPath('errors.token.0', 'El campo enlace de recuperación debe ser texto.');
    }

    public function test_admin_rate_limit_page_and_json_are_spanish(): void
    {
        Mail::fake();
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post(route('admin.password.email'), ['email' => ''])->assertSessionHasErrors('email');
        }
        $this->post(route('admin.password.email'), ['email' => ''])->assertStatus(429)
            ->assertSee('Demasiados intentos.');
        $this->postJson(route('admin.password.email'), ['email' => ''])->assertStatus(429)
            ->assertJsonPath('message', 'Demasiados intentos. Espera un momento antes de volver a intentarlo.');
    }

    public function test_all_builtin_validation_rules_have_spanish_entries(): void
    {
        $english = require base_path('vendor/laravel/framework/src/Illuminate/Translation/lang/en/validation.php');
        $spanish = require lang_path('es/validation.php');
        $this->assertSame([], array_diff_key($english, $spanish));
        $this->assertSame('Anterior', trans('pagination.previous', [], 'es'));
    }
}
