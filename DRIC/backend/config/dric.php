<?php

return [
    'admin' => [
        'email' => env('DRIC_ADMIN_EMAIL'),
        'idle_timeout_minutes' => (int) env('ADMIN_IDLE_TIMEOUT_MINUTES', 60),
    ],

    'appointments' => [
        'recipient_email' => env('DRIC_APPOINTMENT_RECIPIENT_EMAIL'),
        'recipient_name' => env('DRIC_APPOINTMENT_RECIPIENT_NAME', 'DRIC'),
    ],
];
