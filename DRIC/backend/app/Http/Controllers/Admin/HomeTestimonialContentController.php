<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentBlock;
use App\Models\ContentBlockTranslation;
use App\Models\Language;
use App\Models\MediaAsset;
use App\Models\MediaTranslation;
use App\Models\Page;
use App\Models\Section;
use App\Support\PagePermissionMap;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class HomeTestimonialContentController extends Controller
{
    private const MAX_IMAGE_KB = 5120;
    private const CLEAN_LABEL_REGEX = '/\A[\p{L}\s.,]+\z/u';

    public function edit(Page $page): View
    {
        $this->authorizeAccess($page);
        $section = $this->testimonialsSection($page);

        $section->load([
            'contentBlocks.translations.language',
            'contentBlocks.mediaAsset.translations.language',
        ]);

        return view('admin.pages.home-testimonials-content', [
            'page' => $page,
            'testimonials' => $this->formTestimonials($section),
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $this->authorizeAccess($page);

        $rows = array_values($request->input('testimonials', []));

        $rules = [
            'testimonials' => ['array'],
        ];

        foreach ($rows as $index => $row) {
            $rules["testimonials.{$index}.id"] = ['nullable', 'integer'];
            $rules["testimonials.{$index}.existing_image"] = ['nullable', 'string', 'max:900'];
            $rules["testimonials.{$index}.name_es"] = ['required', 'string', 'max:120', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["testimonials.{$index}.name_en"] = ['nullable', 'string', 'max:120', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["testimonials.{$index}.country_es"] = ['required', 'string', 'max:100', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["testimonials.{$index}.country_en"] = ['nullable', 'string', 'max:100', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["testimonials.{$index}.mobility_type_es"] = ['required', 'string', 'max:140', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["testimonials.{$index}.mobility_type_en"] = ['nullable', 'string', 'max:140', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["testimonials.{$index}.experience_date"] = ['required', 'date'];
            $rules["testimonials.{$index}.rating"] = ['required', 'integer', 'min:1', 'max:10'];
            $rules["testimonials.{$index}.description_es"] = ['required', 'string', 'max:1800'];
            $rules["testimonials.{$index}.description_en"] = ['nullable', 'string', 'max:1800'];
            $rules["testimonials.{$index}.image"] = ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:'.self::MAX_IMAGE_KB];
        }

        $validated = Validator::make($request->all(), $rules, $this->messages())->validate();

        DB::transaction(function () use ($request, $page, $validated): void {
            $section = $this->testimonialsSection($page);
            $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');
            $keepIds = collect($validated['testimonials'] ?? [])->pluck('id')->filter()->map(fn ($id) => (int) $id)->all();

            $removeQuery = $section->contentBlocks()->where('block_type', 'student_testimonial');
            if (count($keepIds) > 0) {
                $removeQuery->whereNotIn('id', $keepIds);
            }

            $removeQuery->with('mediaAsset')->get()->each(function (ContentBlock $block): void {
                if ($block->mediaAsset) {
                    Storage::disk($block->mediaAsset->disk ?? 'public')->delete($block->mediaAsset->file_path);
                    $block->mediaAsset->delete();
                }
                $block->delete();
            });

            foreach (($validated['testimonials'] ?? []) as $index => $testimonial) {
                $block = ! empty($testimonial['id'])
                    ? ContentBlock::query()
                        ->where('section_id', $section->id)
                        ->where('block_type', 'student_testimonial')
                        ->where('id', $testimonial['id'])
                        ->first()
                    : null;

                $block ??= new ContentBlock([
                    'section_id' => $section->id,
                    'block_type' => 'student_testimonial',
                ]);

                $existingImage = trim((string) ($testimonial['existing_image'] ?? ''));

                $block->fill([
                    'sort_order' => $index + 10,
                    'is_active' => true,
                    'link_url' => null,
                    'data' => [
                        'country_es' => trim($testimonial['country_es']),
                        'country_en' => trim($testimonial['country_en'] ?? '') ?: trim($testimonial['country_es']),
                        'experience_date' => $testimonial['experience_date'],
                        'mobility_type_es' => trim($testimonial['mobility_type_es']),
                        'mobility_type_en' => trim($testimonial['mobility_type_en'] ?? '') ?: trim($testimonial['mobility_type_es']),
                        'rating' => (int) $testimonial['rating'],
                        'image' => $existingImage !== '' ? $existingImage : ($block->data['image'] ?? null),
                        'existing_image' => $existingImage !== '' ? $existingImage : ($block->data['existing_image'] ?? null),
                    ],
                ]);

                $uploadedImage = $this->uploadedImage($request, $index);

                if ($uploadedImage) {
                    if ($block->exists && $block->mediaAsset) {
                        Storage::disk($block->mediaAsset->disk ?? 'public')->delete($block->mediaAsset->file_path);
                        $block->mediaAsset->delete();
                    }

                    $block->media_asset_id = $this->storeMedia($uploadedImage, $request, 'home/testimonials', 'Selfie de estudiante')->id;
                }

                $block->save();

                foreach (['es', 'en'] as $locale) {
                    ContentBlockTranslation::updateOrCreate(
                        ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                        [
                            'title' => trim($testimonial["name_{$locale}"] ?? '') ?: trim($testimonial['name_es']),
                            'subtitle' => trim($testimonial["mobility_type_{$locale}"] ?? '') ?: trim($testimonial['mobility_type_es']),
                            'summary' => trim($testimonial["description_{$locale}"] ?? '') ?: trim($testimonial['description_es']),
                            'body' => null,
                            'cta_label' => null,
                        ]
                    );
                }
            }

            $page->update([
                'status' => 'published',
                'published_at' => $page->published_at ?? now(),
                'updated_by' => $request->user()->id,
            ]);
        });

        return redirect()
            ->route('admin.home-testimonials.edit', $page)
            ->with('success', 'Los testimonios de estudiantes fueron actualizados correctamente.');
    }

    private function testimonialsSection(Page $page): Section
    {
        return Section::firstOrCreate(
            ['page_id' => $page->id, 'section_key' => 'home.student_testimonials'],
            [
                'section_type' => 'student_testimonials',
                'sort_order' => 7,
                'is_active' => true,
                'settings' => [
                    'theme' => 'dark',
                    'layout' => 'student-carousel',
                    'image' => '/images/home/student-experience.png',
                ],
            ]
        );
    }

    private function formTestimonials(Section $section): array
    {
        return $section->contentBlocks
            ->where('block_type', 'student_testimonial')
            ->sortBy('sort_order')
            ->values()
            ->map(fn (ContentBlock $block) => [
                'id' => $block->id,
                'name_es' => $block->translations->firstWhere('language.code', 'es')?->title ?? '',
                'name_en' => $block->translations->firstWhere('language.code', 'en')?->title ?? '',
                'country_es' => $block->data['country_es'] ?? '',
                'country_en' => $block->data['country_en'] ?? '',
                'mobility_type_es' => $block->data['mobility_type_es'] ?? ($block->translations->firstWhere('language.code', 'es')?->subtitle ?? ''),
                'mobility_type_en' => $block->data['mobility_type_en'] ?? ($block->translations->firstWhere('language.code', 'en')?->subtitle ?? ''),
                'experience_date' => $block->data['experience_date'] ?? '',
                'rating' => (int) ($block->data['rating'] ?? 10),
                'description_es' => $block->translations->firstWhere('language.code', 'es')?->summary ?? '',
                'description_en' => $block->translations->firstWhere('language.code', 'en')?->summary ?? '',
                'image' => $this->testimonialImage($block),
                'existing_image' => $this->testimonialImage($block),
            ])
            ->all();
    }

    private function testimonialImage(ContentBlock $block): string
    {
        if ($block->mediaAsset?->file_path) {
            return '/storage/'.ltrim($block->mediaAsset->file_path, '/');
        }

        $image = $block->data['image'] ?? $block->data['existing_image'] ?? '';

        if (is_string($image) && trim($image) !== '') {
            return $image;
        }

        $name = $block->translations->firstWhere('language.code', 'es')?->title ?? '';

        return match ($name) {
            'Naïs Mampaey' => '/images/testimonials/mais.jpg',
            'Wannes Loobuyck' => '/images/testimonials/wannes.jpg',
            'Kato Vandoorne' => '/images/testimonials/kato.jpg',
            default => '',
        };
    }

    private function uploadedImage(Request $request, int $index): mixed
    {
        $file = $request->file("testimonials.{$index}.image");

        if ($file) {
            return $file;
        }

        $files = $request->file('testimonials', []);

        return $files[$index]['image'] ?? null;
    }

    private function storeMedia($file, Request $request, string $prefix, string $altText): MediaAsset
    {
        $path = $file->store($prefix, 'public');

        $media = MediaAsset::create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'disk' => 'public',
            'uploaded_by' => $request->user()->id,
        ]);

        foreach (Language::query()->whereIn('code', ['es', 'en'])->get() as $language) {
            MediaTranslation::updateOrCreate(
                ['media_asset_id' => $media->id, 'language_id' => $language->id],
                ['alt_text' => $altText, 'caption' => null]
            );
        }

        return $media;
    }

    private function messages(): array
    {
        return [
            'required' => 'Este campo es obligatorio.',
            'date' => 'Selecciona una fecha válida.',
            'integer' => 'La calificación debe ser un número entero.',
            'min' => 'La calificación mínima permitida es 1.',
            'max' => 'Este campo supera el tamaño permitido.',
            'mimes' => 'Ese formato no está permitido. Solo se aceptan imágenes JPG o PNG.',
            'file' => 'Debes subir un archivo válido.',
            'regex' => 'Este campo solo puede contener letras, espacios, puntos y comas. No uses números ni símbolos especiales.',
            'testimonials.*.rating.max' => 'La calificación máxima permitida es 10.',
            'testimonials.*.image.max' => 'La imagen es demasiado pesada. El tamaño máximo permitido es 5 MB.',
        ];
    }

    private function authorizeAccess(Page $page): void
    {
        abort_unless($page->slug === 'inicio', 404);
        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $page), 403, 'No tienes permiso para editar esta página.');
    }
}
