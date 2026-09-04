<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificateVerification;
use App\Models\Language;
use App\Models\Page;
use App\Models\PageTranslation;
use App\Models\Section;
use App\Models\SectionTranslation;
use App\Support\PagePermissionMap;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class CertificateContentController extends Controller
{
    private const CLEAN_NAME_REGEX = '/\A[\p{L}\s.,]+\z/u';
    private const CODE_REGEX = '/\A[A-Z0-9]{7}\z/';
    private const PROTECTED_CODES = ['B7T3SG9', 'X4D8R1Q', 'A7K9P2M'];

    public function edit(Page $page): View
    {
        $this->authorizeCertificateAccess($page);

        $page->load(['translations.language', 'sections.translations.language']);

        return view('admin.pages.certificate-content', [
            'page' => $page,
            'content' => $this->formContent($page),
            'certificates' => $this->certificates(),
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $this->authorizeCertificateAccess($page);

        $validated = Validator::make($request->all(), $this->rules(), $this->messages())->validate();
        $certificates = $this->validatedCertificates($request);

        DB::transaction(function () use ($request, $validated, $certificates, $page): void {
            $page->update([
                'status' => 'published',
                'published_at' => $page->published_at ?? now(),
                'updated_by' => $request->user()->id,
            ]);

            $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');
            $hero = Section::updateOrCreate(
                ['page_id' => $page->id, 'section_key' => 'certificates.hero'],
                ['section_type' => 'certificate_hero', 'sort_order' => 1, 'is_active' => true, 'settings' => ['editable' => true]]
            );

            foreach (['es', 'en'] as $locale) {
                PageTranslation::updateOrCreate(
                    ['page_id' => $page->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['title'],
                        'menu_title' => $validated[$locale]['title'],
                        'subtitle' => $validated[$locale]['eyebrow'],
                        'summary' => $validated[$locale]['description'],
                        'body' => null,
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $hero->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['title'],
                        'subtitle' => $validated[$locale]['eyebrow'],
                        'summary' => $validated[$locale]['description'],
                        'body' => null,
                    ]
                );
            }

            $this->syncCertificates($certificates);
        });

        return redirect()
            ->route('admin.pages.certificates.edit', $page)
            ->with('success', 'La página de certificados fue actualizada correctamente.');
    }

    public function generateCode(): JsonResponse
    {
        abort_unless(auth()->user()?->hasRole('Admin') || auth()->user()?->can('editar.validar_certificado'), 403);

        return response()->json(['code' => $this->uniqueCode()]);
    }

    private function rules(): array
    {
        return [
            'es.eyebrow' => ['required', 'string', 'max:120', 'regex:'.self::CLEAN_NAME_REGEX],
            'en.eyebrow' => ['required', 'string', 'max:120', 'regex:'.self::CLEAN_NAME_REGEX],
            'es.title' => ['required', 'string', 'max:140', 'regex:'.self::CLEAN_NAME_REGEX],
            'en.title' => ['required', 'string', 'max:140', 'regex:'.self::CLEAN_NAME_REGEX],
            'es.description' => ['required', 'string', 'max:900'],
            'en.description' => ['required', 'string', 'max:900'],
        ];
    }

    private function messages(): array
    {
        return [
            'required' => 'Este campo es obligatorio.',
            'string' => 'Este campo debe contener texto.',
            'date' => 'Ingresa una fecha válida.',
            'max' => 'Este campo supera el tamaño permitido.',
            'regex' => 'Este campo solo puede contener letras, espacios, puntos y comas. No uses números ni símbolos especiales.',
            'unique' => 'Este código ya existe. Genera otro código.',
        ];
    }

    private function validatedCertificates(Request $request): array
    {
        $rows = collect($request->input('certificates', []))
            ->filter(fn ($row) => filled($row['full_name'] ?? null) || filled($row['certificate_type'] ?? null) || filled($row['certificate_type_en'] ?? null) || filled($row['code'] ?? null) || filled($row['description_es'] ?? null) || filled($row['id'] ?? null))
            ->values()
            ->all();

        $validator = Validator::make(
            ['certificates' => $rows],
            [
                'certificates' => ['array'],
                'certificates.*.id' => ['nullable', 'integer'],
                'certificates.*.is_active' => ['nullable', 'boolean'],
                'certificates.*.code' => ['required', 'string', 'size:7', 'regex:'.self::CODE_REGEX],
                'certificates.*.full_name' => ['required', 'string', 'max:180', 'regex:'.self::CLEAN_NAME_REGEX],
                'certificates.*.certificate_type' => ['required', 'string', 'max:160', 'regex:'.self::CLEAN_NAME_REGEX],
                'certificates.*.certificate_type_en' => ['nullable', 'string', 'max:160', 'regex:'.self::CLEAN_NAME_REGEX],
                'certificates.*.issue_date' => ['required', 'date'],
                'certificates.*.description_es' => ['required', 'string', 'max:900'],
                'certificates.*.description_en' => ['nullable', 'string', 'max:900'],
            ],
            [
                'certificates.*.code.required' => 'Genera un código para esta persona.',
                'certificates.*.code.size' => 'El código debe tener exactamente 7 caracteres.',
                'certificates.*.code.regex' => 'El código solo puede contener mayúsculas y números.',
                'certificates.*.full_name.required' => 'Escribe el nombre completo.',
                'certificates.*.full_name.regex' => 'El nombre solo puede contener letras, espacios, puntos y comas. No uses números ni símbolos especiales.',
                'certificates.*.certificate_type.required' => 'Escribe el tipo de certificado.',
                'certificates.*.certificate_type.regex' => 'El tipo de certificado solo puede contener letras, espacios, puntos y comas. No uses números ni símbolos especiales.',
                'certificates.*.certificate_type_en.regex' => 'El tipo de certificado en inglés solo puede contener letras, espacios, puntos y comas. No uses números ni símbolos especiales.',
                'certificates.*.issue_date.required' => 'Selecciona la fecha de emisión.',
                'certificates.*.issue_date.date' => 'Selecciona una fecha de emisión válida.',
                'certificates.*.description_es.required' => 'Escribe una descripción en español.',
            ]
        );

        $validator->after(function ($validator) use ($rows): void {
            $seen = [];

            foreach ($rows as $index => $row) {
                $code = strtoupper(trim($row['code'] ?? ''));
                $id = isset($row['id']) ? (int) $row['id'] : null;

                if ($code === '') {
                    continue;
                }

                if (in_array($code, self::PROTECTED_CODES, true)) {
                    $validator->errors()->add("certificates.{$index}.code", 'Este código está protegido y no se puede usar en el panel.');
                }

                if (in_array($code, $seen, true)) {
                    $validator->errors()->add("certificates.{$index}.code", 'Este código está repetido en el formulario.');
                }
                $seen[] = $code;

                $exists = CertificateVerification::query()
                    ->where('code', $code)
                    ->when($id, fn ($query) => $query->where('id', '!=', $id))
                    ->exists();

                if ($exists) {
                    $validator->errors()->add("certificates.{$index}.code", 'Este código ya existe. Genera otro código.');
                }
            }
        });

        $validated = $validator->validate();

        return collect($validated['certificates'] ?? [])
            ->map(fn ($row) => [
                'id' => isset($row['id']) ? (int) $row['id'] : null,
                'is_active' => (bool) ($row['is_active'] ?? false),
                'code' => strtoupper(trim($row['code'])),
                'full_name' => trim($row['full_name']),
                'certificate_type' => trim($row['certificate_type']),
                'certificate_type_en' => trim($row['certificate_type_en'] ?? '') ?: trim($row['certificate_type']),
                'issue_date' => $row['issue_date'],
                'description_es' => trim($row['description_es']),
                'description_en' => trim($row['description_en'] ?? '') ?: trim($row['description_es']),
            ])
            ->all();
    }

    private function syncCertificates(array $certificates): void
    {
        $keptIds = [];

        foreach ($certificates as $certificateData) {
            $certificate = $certificateData['id']
                ? CertificateVerification::query()
                    ->where('id', $certificateData['id'])
                    ->whereNotIn('code', self::PROTECTED_CODES)
                    ->first()
                : null;

            if (! $certificate) {
                $certificate = new CertificateVerification();
            }

            $certificate->fill([
                'code' => $certificateData['code'],
                'full_name' => $certificateData['full_name'],
                'certificate_type' => $certificateData['certificate_type'],
                'certificate_type_en' => $certificateData['certificate_type_en'],
                'description' => $certificateData['description_es'],
                'description_en' => $certificateData['description_en'],
                'issue_date' => $certificateData['issue_date'],
                'is_active' => $certificateData['is_active'],
            ]);
            $certificate->save();
            $keptIds[] = $certificate->id;
        }

        CertificateVerification::query()
            ->whereNotIn('code', self::PROTECTED_CODES)
            ->when($keptIds !== [], fn ($query) => $query->whereNotIn('id', $keptIds))
            ->delete();
    }

    private function formContent(Page $page): array
    {
        return [
            'es' => [
                'eyebrow' => $this->sectionValue($page, 'certificates.hero', 'es', 'subtitle', 'Verificación institucional'),
                'title' => $this->pageValue($page, 'es', 'title', 'Verificar Certificado'),
                'description' => $this->sectionValue($page, 'certificates.hero', 'es', 'summary', 'Consulta la validez de certificados emitidos por la Dirección de Relaciones Internacionales y Convenios mediante un código único de verificación.'),
            ],
            'en' => [
                'eyebrow' => $this->sectionValue($page, 'certificates.hero', 'en', 'subtitle', 'Institutional verification'),
                'title' => $this->pageValue($page, 'en', 'title', 'Verify Certificate'),
                'description' => $this->sectionValue($page, 'certificates.hero', 'en', 'summary', 'Check the validity of certificates issued by the Directorate of International Relations and Agreements using a unique verification code.'),
            ],
        ];
    }

    private function certificates()
    {
        return CertificateVerification::query()
            ->whereNotIn('code', self::PROTECTED_CODES)
            ->orderByDesc('issue_date')
            ->orderBy('full_name')
            ->get()
            ->map(fn (CertificateVerification $certificate) => [
                'id' => $certificate->id,
                'is_active' => (bool) $certificate->is_active,
                'code' => $certificate->code,
                'full_name' => $certificate->full_name,
                'certificate_type' => $certificate->certificate_type ?? '',
                'certificate_type_en' => $certificate->certificate_type_en ?? '',
                'issue_date' => $certificate->issue_date?->format('Y-m-d'),
                'description_es' => $certificate->description ?? '',
                'description_en' => $certificate->description_en ?? '',
            ]);
    }

    private function uniqueCode(): string
    {
        do {
            $code = collect(range(1, 7))
                ->map(fn () => 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'[random_int(0, 31)])
                ->implode('');
        } while (
            in_array($code, self::PROTECTED_CODES, true)
            || CertificateVerification::query()->where('code', $code)->exists()
        );

        return $code;
    }

    private function pageValue(Page $page, string $locale, string $field, string $fallback): string
    {
        return $page->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function sectionValue(Page $page, string $key, string $locale, string $field, string $fallback): string
    {
        return $page->sections->firstWhere('section_key', $key)?->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function authorizeCertificateAccess(Page $page): void
    {
        abort_unless($page->slug === 'validar-certificado', 404);
        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $page), 403, 'No tienes permiso para editar esta página.');
    }
}
