<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ExpireIdleAdminSession;
use App\Http\Middleware\PreventAdminBackHistory;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function (): void {
            Route::middleware(['web', 'auth', \Illuminate\Session\Middleware\AuthenticateSession::class, PreventAdminBackHistory::class, ExpireIdleAdminSession::class])
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->prependToGroup('web', \App\Http\Middleware\UseSpanishForAdmin::class);
        $middleware->redirectGuestsTo('/admin/login');
        $middleware->redirectUsersTo('/admin');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->respond(function (\Symfony\Component\HttpFoundation\Response $response) {
            $status = $response->getStatusCode();
            if (!request()->is('admin', 'admin/*') || $status < 400 || $status === 422) {
                return $response;
            }

            if (!request()->expectsJson() && in_array($status, [403, 404, 419], true)) {
                return $response;
            }

            $message = match ($status) {
                401 => 'Inicia sesión para continuar.',
                403 => 'No tienes permiso para realizar esta acción.',
                404 => 'No se encontró la página solicitada.',
                405 => 'Esta acción no está disponible.',
                419 => 'Tu sesión venció. Recarga la página e inténtalo nuevamente.',
                429 => 'Demasiados intentos. Espera un momento antes de volver a intentarlo.',
                503 => 'El servicio está temporalmente en mantenimiento. Inténtalo más tarde.',
                default => 'No se pudo completar la solicitud. Inténtalo nuevamente o contacta con la administración.',
            };

            $response->setContent(request()->expectsJson()
                ? json_encode(['message' => $message], JSON_UNESCAPED_UNICODE)
                : view('errors.admin-request', compact('message', 'status'))->render());
            $response->headers->set('Content-Type', request()->expectsJson() ? 'application/json' : 'text/html; charset=UTF-8');

            return $response;
        });
    })->create();
