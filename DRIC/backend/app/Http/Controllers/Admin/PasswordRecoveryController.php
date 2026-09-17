<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'El correo electronico es obligatorio.',
            'email.email' => 'Ingresa un correo electronico válido.',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user) {
            return back()
                ->with('success', 'Te enviamos una nueva contraseña temporal.')
                ->onlyInput('email');
        }

        $temporaryPassword = (string) random_int(1000000, 9999999);
        $previousPassword = $user->password;

        $user->forceFill([
            'password' => Hash::make($temporaryPassword),
        ])->save();

        try {
            Mail::send('emails.admin-password-recovery', [
                'user' => $user,
                'temporaryPassword' => $temporaryPassword,
                'loginUrl' => route('login'),
            ], function ($message) use ($user) {
                $message
                    ->to($user->email, $user->name)
                    ->subject('Nueva contrasena temporal - Panel DRIC');
            });
        } catch (Throwable $exception) {
            $user->forceFill([
                'password' => $previousPassword,
            ])->save();

            report($exception);

            return back()
                ->withErrors(['email' => 'No pudimos enviar el correo en este momento. Revisa la configuracion de correo e intenta otra vez.'])
                ->onlyInput('email');
        }

        return back()
            ->with('success', 'Te enviamos una nueva contraseña temporal.')
            ->onlyInput('email');
    }
}
