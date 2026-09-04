<?php

namespace App\Support;

class AdminPermissionCatalog
{
    public static function permissions(): array
    {
        return [
            'general' => [
                'label' => 'Acceso general',
                'items' => [
                    'ver.panel' => 'Ver panel administrativo',
                    'ver.paginas' => 'Ver páginas',
                ],
            ],
            'gestion' => [
                'label' => 'Gestión administrativa',
                'items' => [
                    'gestionar.usuarios' => 'Gestionar usuarios',
                    'gestionar.roles' => 'Gestionar roles y permisos',
                    'gestionar.medios' => 'Gestionar fotos y archivos',
                    'gestionar.auditoria' => 'Ver auditoría',
                ],
            ],
            'tabs' => [
                'label' => 'Pestañas editables del sitio',
                'items' => [
                    'editar.convenios' => 'Editar Convenios',
                    'editar.noticias' => 'Editar Noticias',
                    'editar.normativas' => 'Editar Normativas',
                    'editar.proyectos' => 'Editar Proyectos',
                    'editar.becas_movilidad' => 'Editar Becas y Movilidad',
                    'editar.internacionalizacion' => 'Editar Internacionalización',
                    'editar.membresias' => 'Editar Membresías',
                    'editar.inicio' => 'Editar Inicio',
                    'editar.presentacion' => 'Editar Presentación',
                    'editar.informes_gestion' => 'Editar Informes de gestión',
                    'editar.validar_certificado' => 'Editar Verificación de certificados',
                ],
            ],
        ];
    }

    public static function defaultRoles(): array
    {
        $allPermissions = array_keys(self::flatPermissions());

        return [
            'Admin' => [
                'label' => 'Admin',
                'description' => 'Acceso completo para Dirección.',
                'permissions' => $allPermissions,
            ],
            'Editor_Convenios' => [
                'label' => 'Editor Convenios',
                'description' => 'Edición de Convenios, Noticias y Normativas.',
                'permissions' => [
                    'ver.panel',
                    'ver.paginas',
                    'editar.convenios',
                    'editar.noticias',
                    'editar.normativas',
                ],
            ],
            'Editor_Internacionalizacion' => [
                'label' => 'Editor Internacionalización',
                'description' => 'Edición de Proyectos, Becas y Movilidad, Membresías, Noticias y Normativas.',
                'permissions' => [
                    'ver.panel',
                    'ver.paginas',
                    'editar.proyectos',
                    'editar.becas_movilidad',
                    'editar.internacionalizacion',
                    'editar.membresias',
                    'editar.noticias',
                    'editar.normativas',
                ],
            ],
            'Editor_Media' => [
                'label' => 'Editor Media',
                'description' => 'Edición de Inicio, Presentación, Informes de gestión, fotos y archivos.',
                'permissions' => [
                    'ver.panel',
                    'ver.paginas',
                    'gestionar.medios',
                    'editar.inicio',
                    'editar.presentacion',
                    'editar.informes_gestion',
                    'editar.validar_certificado',
                ],
            ],
        ];
    }

    public static function flatPermissions(): array
    {
        return collect(self::permissions())
            ->flatMap(fn (array $group) => $group['items'])
            ->all();
    }
}
