<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the edit functionality.
     *
     * @return void
     */
    public function test_edit_task_form()
    {
        // Create a project and task
        $project = Project::factory()->create();
        $task = Task::factory()->create(['project_id' => $project->id]);

        // Make a GET request to the edit page
        $response = $this->get(route('tasks.edit', $task));

        // Check if the form is returned with the correct data
        $response->assertStatus(200)
            ->assertViewIs('tasks.edit')
            ->assertViewHas('task', $task)
            ->assertViewHas('projects', Project::all());
    }

    /**
     * Test the update functionality.
     *
     * @return void
     */
    public function test_update_task()
    {
        // Create a project and task
        $project = Project::factory()->create();
        $task = Task::factory()->create(['project_id' => $project->id]);

        // New data to update the task
        $newData = [
            'name' => 'Updated Task Name',
            'priority' => 5,
            'project_id' => $project->id,
        ];

        // Make a PUT request to update the task
        $response = $this->put(route('tasks.update', $task), $newData);

        // Check if the task is updated
        $task->refresh(); // Reload the task from the database
        $this->assertEquals($newData['name'], $task->name);
        $this->assertEquals($newData['priority'], $task->priority);
        $this->assertEquals($newData['project_id'], $task->project_id);

        // Check if the user is redirected to the task index with success message
        $response->assertRedirect(route('tasks.index'))
            ->assertSessionHas('success', 'Task updated successfully.');
    }

    /**
     * Test that validation errors occur if required fields are missing.
     *
     * @return void
     */
    public function test_update_task_validation()
    {
        // Create a project and task
        $project = Project::factory()->create();
        $task = Task::factory()->create(['project_id' => $project->id]);

        $response = $this->put(route('tasks.update', $task), [
            'name' => '',
            'priority' => 5,
            'project_id' => $project->id,
        ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['name']);
    }

    public function testProjectDeletesTasks()
    {
        // Set up a project with tasks
        $project = Project::factory()->create();
        $task1 = Task::factory()->create(['project_id' => $project->id]);
        $task2 = Task::factory()->create(['project_id' => $project->id]);
        $task3 = Task::factory()->create(['project_id' => $project->id]);

        // Assert that the project has tasks
        $this->assertCount(3, $project->tasks);

        // Delete the project
        $project->delete();

        // Assert that the tasks are deleted
        $this->assertCount(0, Task::where('project_id', $project->id)->get());
    }
}
