<?php

namespace Tests\Unit\Domain\Task;

use App\Domain\Task\TaskList;
use App\Domain\Task\TaskListFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class TaskListFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function testFromArrayWithValidData(): void
    {
        /** @var TaskList $taskList */
        $taskList = TaskList::factory()->create();
        $data = [
            'user_id' => $taskList->user_id,
            'project_id' => $taskList->project_id,
            'title' => $taskList->title,
        ];

        $result = TaskListFactory::fromArray($data);

        $this->assertInstanceOf(TaskList::class, $result);
        $this->assertEquals($taskList->user_id, $result->user_id);
        $this->assertEquals($taskList->project_id, $result->project_id);
    }

    public function testFromArrayWithInvalidData(): void
    {
        $this->expectException(ValidationException::class);

        $data = [
            'user_id' => 1,
            'project_id' => 1,
            'title' => null,
        ];

        TaskListFactory::fromArray($data);
    }
}
