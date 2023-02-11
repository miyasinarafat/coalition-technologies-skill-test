<?php

namespace App\Infrastructure\Persistance;

use App\Domain\Task\Task;
use App\Domain\Task\TaskList;
use App\Domain\Task\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{
    /**
     * @param Task $task
     * @return TaskList|null
     */
    public function create(Task $task): ?Task
    {
        if (! $task->save()) {
            return null;
        }

        return $task;
    }

    /**
     * @param int $task
     * @param Task $candidateTask
     * @return Task
     */
    public function update(int $task, Task $candidateTask): Task
    {
        /** @var Task $dbTask */
        $dbTask = Task::query()->find($task);

        $dbTask->title = $candidateTask->title;
        $dbTask->description = $candidateTask->description;
        $dbTask->save();

        return $dbTask;
    }

    /**
     * @param int $task
     * @param int $position
     * @return Task
     */
    public function move(int $task, mixed $position): Task
    {
        /** @var Task $dbTask */
        $dbTask = Task::query()->find($task);
        $dbTask->update(['position' => round($position, 5)]);

        return $dbTask;
    }

    /**
     * @param int $projectId
     * @param int $id
     * @return Task|null
     */
    public function getById(int $projectId, int $id): ?Task
    {
        /** @var Task $task */
        $task = Task::query()
            ->where('project_id', $projectId)
            ->where('id', $id)
            ->first();

        if (! $task) {
            return null;
        }

        return $task;
    }

    /**
     * @param int $projectId
     * @param int $listId
     * @param int $taskId
     * @return bool|null
     */
    public function delete(int $projectId, int $listId, int $taskId): ?bool
    {
        $task = Task::query()
            ->where('project_id', $projectId)
            ->where('list_id', $listId)
            ->where('id', $taskId)
            ->first();

        return $task?->delete();
    }
}
