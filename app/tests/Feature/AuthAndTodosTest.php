<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAndTodosTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_view_empty_todos_list(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('todos.index'));

        $this->get(route('todos.index'))
            ->assertOk()
            ->assertSee('My Todos');
    }

    public function test_user_can_create_todo_and_mark_complete(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $create = $this->post(route('todos.store'), [
            'title' => 'Write tests',
            'due_date' => now()->addDay()->toDateString(),
            'description' => 'Ensure coverage',
        ]);
        $create->assertRedirect(route('todos.index'));

        $todo = Todo::first();
        $this->assertNotNull($todo);
        $this->assertFalse($todo->is_completed);

        $complete = $this->patch(route('todos.complete', $todo));
        $complete->assertRedirect(route('todos.index'));

        $this->assertTrue($todo->fresh()->is_completed);
    }

    public function test_user_cannot_edit_others_todo(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $todo = Todo::factory()->for($owner)->create();

        $this->actingAs($intruder);

        $this->get(route('todos.edit', $todo))->assertForbidden();
    }

    public function test_validation_errors_on_create_missing_title_and_due_date(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->from(route('todos.create'))->post(route('todos.store'), [
            // both title and due_date missing
            'description' => 'x',
        ]);

        $response->assertRedirect(route('todos.create'));
        $response->assertSessionHasErrors(['title', 'due_date']);
    }

    public function test_update_validation_errors_when_missing_title_or_due_date(): void
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create([
            'title' => 'A',
            'due_date' => now()->toDateString(),
        ]);

        $this->actingAs($user);

        $resp1 = $this->from(route('todos.edit', $todo))->put(route('todos.update', $todo), [
            'title' => '',
            'due_date' => now()->toDateString(),
        ]);
        $resp1->assertRedirect(route('todos.edit', $todo));
        $resp1->assertSessionHasErrors(['title']);

        $resp2 = $this->from(route('todos.edit', $todo))->put(route('todos.update', $todo), [
            'title' => 'Ok',
            // due_date missing
        ]);
        $resp2->assertRedirect(route('todos.edit', $todo));
        $resp2->assertSessionHasErrors(['due_date']);
    }

    public function test_index_scopes_to_authenticated_user_only(): void
    {
        $u1 = User::factory()->create();
        $u2 = User::factory()->create();

        Todo::factory()->for($u1)->create(['title' => 'U1 Task 1']);
        Todo::factory()->for($u1)->create(['title' => 'U1 Task 2']);
        Todo::factory()->for($u2)->create(['title' => 'U2 Task 1']);

        $this->actingAs($u1);
        $this->get(route('todos.index'))
            ->assertOk()
            ->assertSeeText('U1 Task 1')
            ->assertSeeText('U1 Task 2')
            ->assertDontSeeText('U2 Task 1');
    }

    public function test_non_owner_cannot_mark_complete(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $todo = Todo::factory()->for($owner)->create(['is_completed' => false]);

        $this->actingAs($intruder);
        $this->patch(route('todos.complete', $todo))->assertForbidden();
    }

    public function test_unchecking_is_completed_sets_false_on_update(): void
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create([
            'title' => 'Task',
            'due_date' => now()->toDateString(),
            'is_completed' => true,
        ]);

        $this->actingAs($user);
        $resp = $this->put(route('todos.update', $todo), [
            'title' => 'Task',
            'due_date' => now()->toDateString(),
            // omit is_completed checkbox
        ]);
        $resp->assertRedirect(route('todos.index'));
        $this->assertFalse($todo->fresh()->is_completed);
    }
}
