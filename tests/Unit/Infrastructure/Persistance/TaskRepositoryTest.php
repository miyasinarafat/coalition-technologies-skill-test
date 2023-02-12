<?php

namespace Tests\Unit\Infrastructure\Persistance;

use App\Domain\Task\Task;
use App\Domain\Task\TaskList;
use App\Domain\Task\TaskRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private TaskRepositoryInterface $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = resolve(TaskRepositoryInterface::class);
    }

    public function testCreateTask(): void
    {
        /** @var TaskList $taskList */
        $taskList = TaskList::factory()->create();
        $task = new Task([
            'user_id' => $taskList->user_id,
            'project_id' => $taskList->project_id,
            'list_id' => $taskList->id,
            'title' => 'Title one',
            'description' => 'Task description.',
        ]);

        $result = $this->repository->create($task);

        $this->assertNotNull($result);
        $this->assertInstanceOf(Task::class, $result);
        $this->assertEquals($task->title, $result->title);
    }

    public function testUpdateTask(): void
    {
        /** @var Task $task */
        $task = Task::factory()->create();
        $candidateTask = new Task([
            'title' => 'Title one',
            'description' => 'Task description.',
        ]);

        $result = $this->repository->update($task, $candidateTask);

        $this->assertInstanceOf(Task::class, $result);
        $this->assertEquals($candidateTask->title, $result->title);
    }

    public function testMoveTask(): void
    {
        /** @var TaskList $taskList */
        $taskList = TaskList::factory()->create();
        /** @var Task $task */
        $task = Task::factory()->create();

        $result = $this->repository->move($task, $taskList->id, 1);

        $this->assertInstanceOf(Task::class, $result);
        $this->assertEquals($task->list_id, $result->list_id);
        $this->assertEquals(1, $result->position);
    }

    public function testGetTaskById(): void
    {
        /** @var Task $task */
        $task = Task::factory()->create();

        $result = $this->repository->getById($task->project_id, $task->id);

        $this->assertNotNull($result);
        $this->assertInstanceOf(Task::class, $result);
        $this->assertEquals($task->title, $result->title);
    }

    public function testDeleteTask(): void
    {
        /** @var Task $task */
        $task = Task::factory()->create();

        $result = $this->repository->delete($task->project_id, $task->list_id, $task->id);

        $this->assertIsBool($result);
        $this->assertEquals(true, $result);
    }
}
