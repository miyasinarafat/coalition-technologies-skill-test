<?php

namespace Tests\Unit\Domain\Task;

use App\Domain\Task\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function testTaskListCreate(): void
    {
        /** @var Task $task */
        $task = Task::factory()->create();

        $this->assertInstanceOf(Task::class, $task);
        $this->assertNotNull($task->title);
        $this->assertNotNull($task->description);
        $this->assertIsInt($task->position);
    }
}
