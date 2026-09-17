<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminRolePermissionSetup;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        AdminRolePermissionSetup::ensureBaseRolesAndPermissions(auth()->user());

        return view('admin.dashboard.index', [
            'isAdmin' => auth()->user()->hasRole('Admin'),
        ]);
    }
}
