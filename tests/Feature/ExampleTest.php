<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response
            ->assertStatus(200)
            ->assertSee('tailwindcss v4.0.7', false)
            ->assertDontSee('cdn.tailwindcss.com', false)
            ->assertDontSee('/build/assets/', false);
    }
}
