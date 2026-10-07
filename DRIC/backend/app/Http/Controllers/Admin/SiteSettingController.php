<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiteSettingController extends Controller
{
    private const FOOTER_KEYS = [
        'footer_title',
        'footer_title_en',
        'footer_address_line_1',
        'footer_address_line_1_en',
        'footer_address_line_2',
        'footer_address_line_2_en',
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
            'topbar_logo_restore' => ['nullable', 'string', 'max:900'],
        ], [
            'topbar_logo.required' => 'Selecciona un logo para actualizar.',
            'topbar_logo.image' => 'El archivo debe ser una imagen.',
            'topbar_logo.mimes' => 'El logo debe ser JPG, PNG o WebP.',
            'topbar_logo.max' => 'El logo no debe superar 2 MB.',
            'topbar_logo_remove.boolean' => 'La opcion para quitar el logo no es valida.',
            'topbar_logo_restore.string' => 'La ruta del logo para restaurar no es valida.',
            'topbar_logo_restore.max' => 'La ruta del logo para restaurar es demasiado larga.',
        ]);

        $validator->after(function ($validator) use ($request): void {
            if (
                ! $request->hasFile('topbar_logo')
                && ! $request->boolean('topbar_logo_remove')
                && ! $request->filled('topbar_logo_restore')
            ) {
                $validator->errors()->add('topbar_logo', 'Selecciona un logo o quita el logo personalizado actual.');
            }
        });

        $validated = $validator->validate();

        if ($request->boolean('topbar_logo_remove')) {
            SiteSetting::setValue('topbar_logo_path', null);

            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Logo del topbar restablecido al predeterminado.');
        }

        if (! $request->hasFile('topbar_logo') && $request->filled('topbar_logo_restore')) {
            SiteSetting::setValue('topbar_logo_path', ltrim((string) $validated['topbar_logo_restore'], '/'));

            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Logo del topbar restaurado correctamente.');
        }

        $path = $validated['topbar_logo']->store('brand', 'public');

        SiteSetting::setValue('topbar_logo_path', $path);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Logo del topbar actualizado correctamente.');
    }

    public function updateFooter(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->hasRole('Admin'), 403);

        $validated = $request->validate([
            'footer_title' => ['required', 'string', 'max:180'],
            'footer_title_en' => ['required', 'string', 'max:180'],
            'footer_address_line_1' => ['required', 'string', 'max:180'],
            'footer_address_line_1_en' => ['required', 'string', 'max:180'],
            'footer_address_line_2' => ['required', 'string', 'max:180'],
            'footer_address_line_2_en' => ['required', 'string', 'max:180'],
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

    public function updateMobileMenu(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->hasRole('Admin'), 403);

        $rules = [];

        foreach (['es', 'en'] as $locale) {
            $rules["menu.{$locale}.kicker"] = ['required', 'string', 'max:80'];
            $rules["menu.{$locale}.title"] = ['required', 'string', 'max:120'];
            $rules["menu.{$locale}.copy"] = ['required', 'string', 'max:420'];
            $rules["menu.{$locale}.footer"] = ['required', 'string', 'max:120'];
            $rules["menu.{$locale}.items"] = ['required', 'array', 'min:1', 'max:24'];
            $rules["menu.{$locale}.items.*.label"] = ['required', 'string', 'max:80'];
            $rules["menu.{$locale}.items.*.description"] = ['required', 'string', 'max:120'];
            $rules["menu.{$locale}.items.*.href"] = ['required', 'string', 'max:500'];
        }

        $validated = $request->validate($rules, [
            'required' => 'Este campo es obligatorio.',
            'string' => 'Este campo debe contener texto.',
            'array' => 'La estructura del menu no es valida.',
            'min' => 'Agrega al menos una pestana.',
            'max' => 'Este campo supera el tamano permitido.',
        ]);

        $menu = [];

        foreach (['es', 'en'] as $locale) {
            $menu[$locale] = [
                'kicker' => trim($validated['menu'][$locale]['kicker']),
                'title' => trim($validated['menu'][$locale]['title']),
                'copy' => trim($validated['menu'][$locale]['copy']),
                'footer' => trim($validated['menu'][$locale]['footer']),
                'items' => collect($validated['menu'][$locale]['items'])
                    ->map(fn (array $item): array => [
                        'label' => trim($item['label']),
                        'description' => trim($item['description']),
                        'href' => trim($item['href']),
                    ])
                    ->values()
                    ->all(),
            ];
        }

        SiteSetting::setValue('mobile_menu_settings', json_encode($menu, JSON_UNESCAPED_UNICODE));

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Menu principal actualizado correctamente.');
    }
}
