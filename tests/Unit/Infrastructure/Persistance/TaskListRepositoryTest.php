<?php

namespace Tests\Unit\Infrastructure\Persistance;

use App\Domain\Project\Project;
use App\Domain\Task\TaskList;
use App\Domain\Task\TaskListRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskListRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private TaskListRepositoryInterface $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = resolve(TaskListRepositoryInterface::class);
    }

    public function testGetAllTaskList(): void
    {
        /** @var Project $project */
        $project = Project::factory()->create();
        /** @var TaskList $taskListOne */
        [$taskListOne,] = TaskList::factory()->count(5)->create([
            'user_id' => $project->user_id,
            'project_id' => $project->id,
        ]);

        $result = $this->repository->getList($project->id);
        /** @var TaskList $taskList */
        $taskList = $result->first();

        $this->assertEquals(5, $result->count());
        $this->assertEquals($taskListOne->id, $taskList->id);
        $this->assertEquals($taskListOne->user_id, $taskList->user_id);
        $this->assertEquals($taskListOne->title, $taskList->title);
    }

    public function testCreateTaskList(): void
    {
        /** @var Project $project */
        $project = Project::factory()->create();
        $taskList = new TaskList([
            'user_id' => $project->user_id,
            'project_id' => $project->id,
            'title' => 'Title one',
        ]);

        $result = $this->repository->create($taskList);

        $this->assertNotNull($result);
        $this->assertInstanceOf(TaskList::class, $result);
        $this->assertEquals($taskList->title, $result->title);
    }

    public function testDeleteTaskList(): void
    {
        /** @var TaskList $taskList */
        $taskList = TaskList::factory()->create();

        $result = $this->repository->delete($taskList->project_id, $taskList->id);

        $this->assertIsBool($result);
        $this->assertEquals(true, $result);
    }
}
