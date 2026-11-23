<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class PasswordRecoveryController extends Controller
{
    public function create(): View
    {
        return view('admin.auth.password-recover');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa un correo electrónico válido.',
        ]);

        try {
            if (in_array(config('mail.default'), ['log', 'array'], true)) {
                throw new \RuntimeException('Password recovery requires a delivery transport.');
            }

            Password::sendResetLink($validated, function (User $user, string $token): void {
                Mail::send('emails.admin-password-recovery', [
                    'user' => $user,
                    'resetUrl' => rtrim(config('app.url'), '/').route('admin.password.reset', ['token' => $token, 'email' => $user->email], false),
                    'expires' => config('auth.passwords.users.expire'),
                ], function ($message) use ($user): void {
                    $message->to($user->email, $user->name)->subject('Restablecer contraseña - Panel DRIC');
                });
            });
        } catch (Throwable $exception) {
            report($exception);
        }

        return back()->with('success', 'Si el correo corresponde a una cuenta, recibirás un enlace para elegir una nueva contraseña. Revisa también spam.')->onlyInput('email');
    }

    public function edit(Request $request, string $token): \Illuminate\Http\Response
    {
        return response()->view('admin.auth.password-reset', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ])->header('Cache-Control', 'no-store')->header('Referrer-Policy', 'no-referrer');
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:12', 'max:255', 'confirmed'],
        ], [
            'required' => 'Este campo es obligatorio.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'password.min' => 'Usa al menos 12 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $status = DB::transaction(function () use ($validated) {
            User::where('email', $validated['email'])->lockForUpdate()->first();

            return Password::reset($validated, function (User $user, string $password): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                if (config('session.driver') === 'database') {
                    DB::table(config('session.table', 'sessions'))->where('user_id', $user->id)->delete();
                }

                event(new PasswordReset($user));
            });
        });

        if ($status !== Password::PASSWORD_RESET) {
            return back()->withErrors(['email' => 'El enlace es inválido o ha vencido. Solicita uno nuevo.'])->onlyInput('email');
        }

        return redirect()->route('login')->with('success', 'Tu contraseña fue actualizada. Ingresa con la nueva contraseña.');
    }
}
