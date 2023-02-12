<?php

namespace App\Domain\Task;

interface TaskRepositoryInterface
{
    /**
     * @param Task $task
     * @return Task|null
     */
    public function create(Task $task): ?Task;

    /**
     * @param Task $task
     * @param Task $candidateTask
     * @return Task
     */
    public function update(Task $task, Task $candidateTask): Task;

    /**
     * @param Task $task
     * @param int $list
     * @param int $position
     * @return Task
     */
    public function move(Task $task, int $list, mixed $position): Task;

    /**
     * @param int $projectId
     * @param int $id
     * @return Task|null
     */
    public function getById(int $projectId, int $id): ?Task;

    /**
     * @param int $projectId
     * @param int $listId
     * @param int $taskId
     * @return bool|null
     */
    public function delete(int $projectId, int $listId, int $taskId): ?bool;
}
