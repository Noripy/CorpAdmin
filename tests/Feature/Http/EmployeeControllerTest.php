<?php

namespace Tests\Feature\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_employees_index_returns_successful_response(): void
    {
        $this->withoutVite();

        $response = $this->get('/employees');

        $response->assertStatus(200);
    }
}
