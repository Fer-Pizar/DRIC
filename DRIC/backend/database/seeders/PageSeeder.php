<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'inicio',
                'page_type' => 'static',
                'status' => 'draft',
                'published_at' => null,
                'sort_order' => 1,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'slug' => 'presentacion',
                'page_type' => 'static',
                'status' => 'draft',
                'published_at' => null,
                'sort_order' => 2,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'slug' => 'convenios',
                'page_type' => 'static',
                'status' => 'draft',
                'published_at' => null,
                'sort_order' => 3,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'slug' => 'proyectos',
                'page_type' => 'static',
                'status' => 'draft',
                'published_at' => null,
                'sort_order' => 4,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'slug' => 'becas-movilidad',
                'page_type' => 'static',
                'status' => 'draft',
                'published_at' => null,
                'sort_order' => 5,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'slug' => 'internacionalizacion',
                'page_type' => 'static',
                'status' => 'draft',
                'published_at' => null,
                'sort_order' => 6,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'slug' => 'membresias',
                'page_type' => 'static',
                'status' => 'draft',
                'published_at' => null,
                'sort_order' => 7,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'slug' => 'noticias',
                'page_type' => 'static',
                'status' => 'draft',
                'published_at' => null,
                'sort_order' => 8,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'slug' => 'normativas',
                'page_type' => 'static',
                'status' => 'draft',
                'published_at' => null,
                'sort_order' => 10,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'slug' => 'informes-gestion',
                'page_type' => 'static',
                'status' => 'draft',
                'published_at' => null,
                'sort_order' => 11,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'slug' => 'contacto',
                'page_type' => 'static',
                'status' => 'draft',
                'published_at' => null,
                'sort_order' => 12,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'slug' => 'validar-certificado',
                'page_type' => 'static',
                'status' => 'draft',
                'published_at' => null,
                'sort_order' => 13,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'slug' => 'campus-life',
                'page_type' => 'static',
                'status' => 'draft',
                'published_at' => null,
                'sort_order' => 14,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'slug' => 'premios-eventos-cursos-concursos',
                'page_type' => 'static',
                'status' => 'draft',
                'published_at' => null,
                'sort_order' => 15,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'slug' => 'informacion-nacionales-extranjeros',
                'page_type' => 'static',
                'status' => 'draft',
                'published_at' => null,
                'sort_order' => 16,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
            ],
        ];

        foreach ($pages as $page) {
            $existing = Page::query()->where('slug', $page['slug'])->first();

            if ($existing) {
                $existing->fill([
                    'page_type' => $page['page_type'],
                    'sort_order' => $page['sort_order'],
                    'parent_id' => $existing->parent_id ?? $page['parent_id'],
                    'created_by' => $existing->created_by,
                    'updated_by' => $existing->updated_by,
                ])->save();

                continue;
            }

            Page::create($page);
        }
    }
}
