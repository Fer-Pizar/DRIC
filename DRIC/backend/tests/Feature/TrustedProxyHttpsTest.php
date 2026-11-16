<?php

namespace Tests\Feature;

use Tests\TestCase;

class TrustedProxyHttpsTest extends TestCase
{
    public function test_admin_forms_use_https_behind_a_trusted_proxy(): void
    {
        config()->set('trustedproxy.proxies', 'REMOTE_ADDR');

        $this->withServerVariables([
            'REMOTE_ADDR' => '10.0.0.8',
            'HTTP_X_FORWARDED_PROTO' => 'https',
        ]);

        $this->get('http://dric-admin.up.railway.app/admin/login')
            ->assertOk()
            ->assertSee('action="https://dric-admin.up.railway.app/admin/login"', false);

        $this->get('http://dric-admin.up.railway.app/admin/pages/1/home-content')
            ->assertRedirect('https://dric-admin.up.railway.app/admin/login');
    }
}
