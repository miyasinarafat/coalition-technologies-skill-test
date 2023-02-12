<?php

namespace Tests\Unit\Domain\Task;

use App\Domain\Task\Task;
use App\Domain\Task\TaskFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class TaskFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function testFromArrayWithValidData(): void
    {
        /** @var Task $task */
        $task = Task::factory()->create();
        $data = [
            'user_id' => $task->user_id,
            'project_id' => $task->project_id,
            'list_id' => $task->list_id,
            'title' => $task->title,
        ];

        $result = TaskFactory::fromArray($data);

        $this->assertInstanceOf(Task::class, $result);
        $this->assertEquals($task->user_id, $result->user_id);
        $this->assertEquals($task->project_id, $result->project_id);
        $this->assertEquals($task->list_id, $result->list_id);
    }

    public function testFromArrayWithInvalidData(): void
    {
        $this->expectException(ValidationException::class);

        $data = [
            'user_id' => 1,
            'project_id' => 1,
            'list_id' => 1,
            'title' => null,
        ];

        TaskFactory::fromArray($data);
    }
}
