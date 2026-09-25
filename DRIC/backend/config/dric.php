<?php

return [
    'admin' => [
        'idle_timeout_minutes' => (int) env('ADMIN_IDLE_TIMEOUT_MINUTES', 60),
    ],

    'appointments' => [
        'recipient_email' => env('DRIC_APPOINTMENT_RECIPIENT_EMAIL', 'mafer.pizar@gmail.com'),
        'recipient_name' => env('DRIC_APPOINTMENT_RECIPIENT_NAME', 'DRIC'),
    ],
];
