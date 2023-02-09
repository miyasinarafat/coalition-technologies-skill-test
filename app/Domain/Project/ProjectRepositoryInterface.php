<?php

namespace App\Domain\Project;

use Illuminate\Pagination\LengthAwarePaginator;

interface ProjectRepositoryInterface
{
    /**
     * @param int $userId
     * @param int $page
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getList(int $userId, int $page = 1, int $perPage = 12): LengthAwarePaginator;

    /**
     * @param Project $project
     * @return Project|null
     */
    public function create(Project $project): ?Project;

    /**
     * @param Project $project
     * @param Project $candidateProject
     * @return Project
     */
    public function update(Project $project, Project $candidateProject): Project;

    /**
     * @param Project $project
     * @return bool|null
     */
    public function delete(Project $project): ?bool;
}
