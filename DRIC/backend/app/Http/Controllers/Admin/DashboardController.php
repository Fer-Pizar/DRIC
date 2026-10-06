<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Support\AdminRolePermissionSetup;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        AdminRolePermissionSetup::ensureBaseRolesAndPermissions(auth()->user());
        $topbarLogoPath = SiteSetting::value('topbar_logo_path');
        $frontendUrl = rtrim(config('app.frontend_url', env('FRONTEND_URL', 'http://127.0.0.1:3000')), '/');

        return view('admin.dashboard.index', [
            'isAdmin' => auth()->user()->hasRole('Admin'),
            'topbarLogoUrl' => $topbarLogoPath
                ? url('storage/'.ltrim($topbarLogoPath, '/'))
                : $frontendUrl.'/images/brand/DRIC_logo.png',
            'hasCustomTopbarLogo' => (bool) $topbarLogoPath,
            'frontendUrl' => $frontendUrl,
            'footerSettings' => SiteSetting::footerSettings(),
        ]);
    }
}
