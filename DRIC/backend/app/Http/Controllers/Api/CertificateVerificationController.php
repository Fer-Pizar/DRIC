<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CertificateVerification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CertificateVerificationController extends Controller
{
    public function verify(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'size:7', 'alpha_num'],
        ]);

        $certificate = CertificateVerification::query()
            ->where('code', strtoupper($validated['code']))
            ->where('is_active', true)
            ->first();

        if (!$certificate) {
            return response()->json([
                'message' => 'Certificate not found.',
            ], 404);
        }

        return response()->json([
            'data' => [
                'code' => $certificate->code,
                'full_name' => $certificate->full_name,
                'certificate_type' => $certificate->certificate_type,
                'description' => $certificate->description,
                'issue_date' => $certificate->issue_date?->format('Y-m-d'),
            ],
        ]);
    }
}