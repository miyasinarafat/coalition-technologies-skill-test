<?php

namespace App\Domain\Task;

use Illuminate\Database\Eloquent\Collection;

interface TaskListRepositoryInterface
{
    /**
     * @param int $projectId
     * @return Collection
     */
    public function getList(int $projectId): Collection;

    /**
     * @param TaskList $list
     * @return TaskList|null
     */
    public function create(TaskList $list): ?TaskList;

    /**
     * @param int $projectId
     * @param int $listId
     * @return bool|null
     */
    public function delete(int $projectId, int $listId): ?bool;
}
