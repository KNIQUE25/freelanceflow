<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiHealthTest extends TestCase
{
    public function test_api_ping_works(): void
    {
        $this->getJson('/api/ping')->assertOk()->assertJson(['status' => 'connected']);
    }
}
