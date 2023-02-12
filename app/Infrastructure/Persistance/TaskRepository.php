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
     * @param Task $task
     * @param Task $candidateTask
     * @return Task
     */
    public function update(Task $task, Task $candidateTask): Task
    {
        $task->title = $candidateTask->title;
        $task->description = $candidateTask->description;
        $task->save();

        return $task;
    }

    /**
     * @param Task $task
     * @param int $list
     * @param int $position
     * @return Task
     */
    public function move(Task $task, int $list, mixed $position): Task
    {
        $task->update([
            'list_id' => $list,
            'position' => round($position, 5),
        ]);

        return $task;
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
