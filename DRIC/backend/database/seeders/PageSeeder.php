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
                'slug' => 'membresias',
                'page_type' => 'static',
                'status' => 'draft',
                'published_at' => null,
                'sort_order' => 6,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'slug' => 'eventos',
                'page_type' => 'static',
                'status' => 'draft',
                'published_at' => null,
                'sort_order' => 7,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'slug' => 'normativas',
                'page_type' => 'static',
                'status' => 'draft',
                'published_at' => null,
                'sort_order' => 8,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'slug' => 'informes-gestion',
                'page_type' => 'static',
                'status' => 'draft',
                'published_at' => null,
                'sort_order' => 9,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'slug' => 'contacto',
                'page_type' => 'static',
                'status' => 'draft',
                'published_at' => null,
                'sort_order' => 10,
                'parent_id' => null,
                'created_by' => null,
                'updated_by' => null,
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }
    }
}