<?php

namespace Tests\Unit\Domain\Task;

use App\Domain\Task\TaskList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskListTest extends TestCase
{
    use RefreshDatabase;

    public function testTaskListCreate(): void
    {
        /** @var TaskList $taskList */
        $taskList = TaskList::factory()->create();

        $this->assertInstanceOf(TaskList::class, $taskList);
        $this->assertNotNull($taskList->title);
    }
}
