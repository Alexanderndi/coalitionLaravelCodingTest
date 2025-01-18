<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_new_project()
    {
        $data = [
            'name' => 'New Project',
        ];

        $response = $this->post(route('projects.store'), $data);

        $this->assertDatabaseHas('projects', $data);

        $response->assertRedirect(route('projects.index'));

        $response->assertSessionHas('success', 'Project created successfully!');
    }
}

