<?php

namespace App\Support;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class PagePermissionMap
{
    public static function pagePermissions(): array
    {
        return [
            'convenios' => 'editar.convenios',
            'noticias' => 'editar.noticias',
            'normativas' => 'editar.normativas',
            'proyectos' => 'editar.proyectos',
            'becas-movilidad' => 'editar.becas_movilidad',
            'membresias' => 'editar.membresias',
            'inicio' => 'editar.inicio',
            'presentacion' => 'editar.presentacion',
            'informes-gestion' => 'editar.informes_gestion',
        ];
    }

    public static function permissionForPage(Page $page): ?string
    {
        return self::pagePermissions()[$page->slug] ?? null;
    }

    public static function canEditPage(User $user, Page $page): bool
    {
        if ($user->hasRole('Admin')) {
            return true;
        }

        $permission = self::permissionForPage($page);

        return $permission !== null && $user->can($permission);
    }

    public static function scopeVisibleToUser(Builder $query, User $user): Builder
    {
        if ($user->hasRole('Admin')) {
            return $query;
        }

        $allowedSlugs = collect(self::pagePermissions())
            ->filter(fn (string $permission) => $user->can($permission))
            ->keys()
            ->all();

        return $query->whereIn('slug', $allowedSlugs);
    }
}
