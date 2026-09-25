<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ExpireIdleAdminSession
{
    private const LAST_ACTIVITY_KEY = 'admin_last_activity_at';

    public function handle(Request $request, Closure $next): Response
    {
        $timeoutMinutes = max(1, (int) config('dric.admin.idle_timeout_minutes', 60));
        $timeoutSeconds = $timeoutMinutes * 60;
        $lastActivityAt = (int) $request->session()->get(self::LAST_ACTIVITY_KEY, now()->timestamp);

        if (now()->timestamp - $lastActivityAt >= $timeoutSeconds) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with('security_notice', 'Tu sesión se cerró por seguridad después de '.$timeoutMinutes.' minutos sin actividad. Ingresa nuevamente para continuar.');
        }

        $request->session()->put(self::LAST_ACTIVITY_KEY, now()->timestamp);

        return $next($request);
    }
}
