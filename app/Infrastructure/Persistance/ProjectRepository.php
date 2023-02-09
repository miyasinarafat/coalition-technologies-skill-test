<?php

namespace App\Infrastructure\Persistance;

use App\Domain\Project\Project;
use App\Domain\Project\ProjectRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectRepository implements ProjectRepositoryInterface
{
    /**
     * @param int $userId
     * @param int $page
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getList(int $userId, int $page = 1, int $perPage = 12): LengthAwarePaginator
    {
        return Project::query()
            ->where('user_id', $userId)
            ->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * @param Project $project
     * @return Project|null
     */
    public function create(Project $project): ?Project
    {
        if (! $project->save()) {
            return null;
        }

        return $project;
    }

    /**
     * @param Project $project
     * @param Project $candidateProject
     * @return Project
     */
    public function update(Project $project, Project $candidateProject): Project
    {
        $project->title = $candidateProject->title;
        $project->save();

        return $project;
    }

    /**
     * @param Project $project
     * @return bool|null
     */
    public function delete(Project $project): ?bool
    {
        return $project->delete();
    }
}
