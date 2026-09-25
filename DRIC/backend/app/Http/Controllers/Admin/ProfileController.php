<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $this->authorizeEditorProfile($request);

        return view('admin.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $this->authorizeEditorProfile($request);

        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_profile_photo' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'Ingresa un correo valido.',
            'email.unique' => 'Este correo ya esta registrado.',
            'password.min' => 'La contrasena debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmacion de contrasena no coincide.',
            'profile_photo.image' => 'La foto debe ser una imagen.',
            'profile_photo.mimes' => 'La foto debe ser JPG, PNG o WebP.',
            'profile_photo.max' => 'La foto no debe superar 2 MB.',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->boolean('remove_profile_photo') && ! $request->hasFile('profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $user->profile_photo_path = null;
        }

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $user->profile_photo_path = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $user->save();

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', 'Perfil actualizado correctamente.');
    }

    private function authorizeEditorProfile(Request $request): void
    {
        abort_if($request->user()?->hasRole('Admin'), 403, 'El perfil personal esta disponible solo para editores por ahora.');
    }
}
