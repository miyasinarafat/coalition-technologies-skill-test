<?php

namespace App\Infrastructure\Persistance;

use App\Domain\Task\TaskList;
use App\Domain\Task\TaskListRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskListRepository implements TaskListRepositoryInterface
{
    /**
     * @param int $projectId
     * @return Collection
     */
    public function getList(int $projectId): Collection
    {
        return TaskList::query()
            ->where('project_id', $projectId)
            ->with(['tasks' => fn ($query) => $query->orderBy('position')])
            ->orderBy('created_at')
            ->get();
    }

    /**
     * @param TaskList $list
     * @return TaskList|null
     */
    public function create(TaskList $list): ?TaskList
    {
        if (! $list->save()) {
            return null;
        }

        return $list;
    }

    /**
     * @param int $projectId
     * @param int $listId
     * @return bool|null
     */
    public function delete(int $projectId, int $listId): ?bool
    {
        $list = TaskList::query()
            ->where('project_id', $projectId)
            ->where('id', $listId)
            ->first();

        return $list?->delete();
    }
}
