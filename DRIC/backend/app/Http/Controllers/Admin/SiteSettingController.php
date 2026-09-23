<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SiteSettingController extends Controller
{
    private const FOOTER_KEYS = [
        'footer_title',
        'footer_address_line_1',
        'footer_address_line_2',
        'footer_umss_url',
        'footer_social_linkedin_url',
        'footer_social_facebook_url',
        'footer_social_x_url',
        'footer_social_instagram_url',
        'footer_social_youtube_url',
    ];

    public function updateTopbarLogo(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->hasRole('Admin'), 403);

        $validator = Validator::make($request->all(), [
            'topbar_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'topbar_logo_remove' => ['nullable', 'boolean'],
        ], [
            'topbar_logo.required' => 'Selecciona un logo para actualizar.',
            'topbar_logo.image' => 'El archivo debe ser una imagen.',
            'topbar_logo.mimes' => 'El logo debe ser JPG, PNG o WebP.',
            'topbar_logo.max' => 'El logo no debe superar 2 MB.',
            'topbar_logo_remove.boolean' => 'La opcion para quitar el logo no es valida.',
        ]);

        $validator->after(function ($validator) use ($request): void {
            if (! $request->hasFile('topbar_logo') && ! $request->boolean('topbar_logo_remove')) {
                $validator->errors()->add('topbar_logo', 'Selecciona un logo o quita el logo personalizado actual.');
            }
        });

        $validated = $validator->validate();
        $previousPath = SiteSetting::value('topbar_logo_path');

        if ($request->boolean('topbar_logo_remove')) {
            SiteSetting::setValue('topbar_logo_path', null);

            if ($previousPath) {
                Storage::disk('public')->delete($previousPath);
            }

            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Logo del topbar restablecido al predeterminado.');
        }

        $path = $validated['topbar_logo']->store('brand', 'public');

        SiteSetting::setValue('topbar_logo_path', $path);

        if ($previousPath && $previousPath !== $path) {
            Storage::disk('public')->delete($previousPath);
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Logo del topbar actualizado correctamente.');
    }

    public function updateFooter(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->hasRole('Admin'), 403);

        $validated = $request->validate([
            'footer_title' => ['required', 'string', 'max:180'],
            'footer_address_line_1' => ['required', 'string', 'max:180'],
            'footer_address_line_2' => ['required', 'string', 'max:180'],
            'footer_umss_url' => ['required', 'url', 'max:500'],
            'footer_social_linkedin_url' => ['required', 'url', 'max:500'],
            'footer_social_facebook_url' => ['required', 'url', 'max:500'],
            'footer_social_x_url' => ['required', 'url', 'max:500'],
            'footer_social_instagram_url' => ['required', 'url', 'max:500'],
            'footer_social_youtube_url' => ['required', 'url', 'max:500'],
        ], [
            'required' => 'Este campo es obligatorio.',
            'string' => 'Este campo debe contener texto.',
            'url' => 'Ingresa una URL valida que empiece con http:// o https://.',
            'max' => 'Este campo supera el tamano permitido.',
        ]);

        foreach (self::FOOTER_KEYS as $key) {
            SiteSetting::setValue($key, trim($validated[$key]));
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Footer actualizado correctamente.');
    }
}
