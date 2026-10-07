<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_display_tasks_index()
    {
        Task::factory()->count(3)->create();

        $response = $this->get(route('tasks.index'));

        $response->assertStatus(200);
        $response->assertViewIs('tasks.index');
        $response->assertViewHas('tasks');
    }

    public function test_it_can_store_a_new_task()
    {
        $response = $this->post(route('tasks.store'), [
            'title' => 'Test Task',
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
            'is_completed' => false,
        ]);
    }

    public function test_it_validates_task_title_is_required()
    {
        $response = $this->post(route('tasks.store'), [
            'title' => '',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_it_validates_task_title_max_length()
    {
        $response = $this->post(route('tasks.store'), [
            'title' => str_repeat('a', 256),
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_it_can_toggle_task_completion()
    {
        $task = Task::factory()->create(['is_completed' => false]);

        $response = $this->patch(route('tasks.update', $task));

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'is_completed' => true,
        ]);
    }

    public function test_it_can_delete_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}
