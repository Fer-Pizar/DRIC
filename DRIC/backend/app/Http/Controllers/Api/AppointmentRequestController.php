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
        $english = $request->input('locale') === 'en';
        app()->setLocale($english ? 'en' : 'es');
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:80'],
            'topic' => ['required', 'string', 'max:160'],
            'date' => ['nullable', 'date'],
            'message' => ['required', 'string', 'max:3000'],
            'consent' => ['accepted'],
            'locale' => ['nullable', 'string', 'in:es,en'],
        ], [
            'name.required' => $english ? 'Enter your full name.' : 'Escribe tu nombre completo.',
            'email.required' => $english ? 'Enter your email address.' : 'Escribe tu correo electrónico.',
            'email.email' => $english ? 'Enter a valid email address.' : 'Ingresa un correo electrónico válido.',
            'topic.required' => $english ? 'Select an appointment topic.' : 'Selecciona el motivo de la cita.',
            'message.required' => $english ? 'Describe your request.' : 'Describe tu consulta.',
            'consent.accepted' => $english ? 'Agree to the use of your data to handle this request.' : 'Acepta el uso de tus datos para gestionar la solicitud.',
            'max.string' => $english ? 'This field is too long.' : 'Este campo es demasiado largo.',
        ]);

        $locale = $validated['locale'] ?? 'es';
        $subject = $locale === 'en'
            ? "DRIC appointment request - {$validated['name']}"
            : "Solicitud de cita DRIC - {$validated['name']}";

        $recipient = config('dric.appointments.recipient_email');
        if (!is_string($recipient) || !filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['message' => $english ? 'Appointment delivery is unavailable.' : 'El envío de solicitudes no está disponible.'], 503);
        }

        if (in_array(config('mail.default'), ['log', 'array'], true)) {
            return response()->json([
                'message' => $english ? 'Email delivery is unavailable.' : 'El envío de correo no está disponible.',
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
                'message' => $english ? 'The appointment request could not be sent.' : 'No se pudo enviar la solicitud de cita.',
            ], 500);
        }

        return response()->json([
            'message' => $english ? 'Appointment request sent successfully.' : 'Solicitud de cita enviada correctamente.',
        ]);
    }
}
