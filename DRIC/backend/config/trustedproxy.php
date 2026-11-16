<?php

return [
    // Empty locally; set to REMOTE_ADDR or a known proxy CIDR behind HTTPS proxies.
    'proxies' => env('TRUSTED_PROXIES'),
];
