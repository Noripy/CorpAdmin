<?php

namespace Tests\Feature\View;

use Tests\TestCase;

class WelcomeViewTest extends TestCase
{
    public function test_welcome_page_links_to_employees_index(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee(route('employees.index'), false);
    }
}
