<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Throwable;

class AppointmentRequestController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:80'],
            'topic' => ['required', 'string', 'max:160'],
            'date' => ['nullable', 'date'],
            'message' => ['required', 'string', 'max:3000'],
            'consent' => ['accepted'],
            'locale' => ['nullable', 'string', 'in:es,en'],
        ]);

        $locale = $validated['locale'] ?? 'es';
        $subject = $locale === 'en'
            ? "DRIC appointment request - {$validated['name']}"
            : "Solicitud de cita DRIC - {$validated['name']}";

        if (in_array(config('mail.default'), ['log', 'array'], true)) {
            return response()->json([
                'message' => 'Email delivery is not configured for real SMTP sending.',
            ], 500);
        }

        try {
            Mail::send('emails.appointment-request', [
                'appointment' => $validated,
                'locale' => $locale,
                'subjectLine' => $subject,
            ], function ($message) use ($subject, $validated): void {
                $message
                    ->to(
                        config('dric.appointments.recipient_email'),
                        config('dric.appointments.recipient_name')
                    )
                    ->replyTo($validated['email'], $validated['name'])
                    ->subject($subject);
            });
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'The appointment request could not be sent.',
            ], 500);
        }

        return response()->json([
            'message' => 'Appointment request sent successfully.',
        ]);
    }
}
