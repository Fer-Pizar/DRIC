<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;

class SiteSettingController extends Controller
{
    public function show(): JsonResponse
    {
        $logoPath = SiteSetting::value('topbar_logo_path');
        $footerSettings = SiteSetting::footerSettings();

        return response()->json([
            'topbar_logo_url' => $logoPath ? url('storage/'.ltrim($logoPath, '/')) : null,
            'footer' => [
                'title' => $footerSettings['footer_title'],
                'address_line_1' => $footerSettings['footer_address_line_1'],
                'address_line_2' => $footerSettings['footer_address_line_2'],
                'umss_url' => $footerSettings['footer_umss_url'],
                'social_links' => [
                    'linkedin' => $footerSettings['footer_social_linkedin_url'],
                    'facebook' => $footerSettings['footer_social_facebook_url'],
                    'x' => $footerSettings['footer_social_x_url'],
                    'instagram' => $footerSettings['footer_social_instagram_url'],
                    'youtube' => $footerSettings['footer_social_youtube_url'],
                ],
            ],
        ]);
    }
}
