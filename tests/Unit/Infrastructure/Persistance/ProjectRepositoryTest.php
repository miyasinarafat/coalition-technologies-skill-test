<?php

namespace Tests\Unit\Infrastructure\Persistance;

use App\Domain\Project\Project;
use App\Domain\Project\ProjectRepositoryInterface;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ProjectRepositoryInterface $projectRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->projectRepository = resolve(ProjectRepositoryInterface::class);
    }

    public function testGetAllProject(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        /** @var Project $projectOne */
        [$projectOne,] = Project::factory()->count(5)->create([
           'user_id' => $user->id,
        ]);

        $result = $this->projectRepository->getList($user->id);
        /** @var Project $project */
        $project = $result->first();

        $this->assertEquals(5, $result->count());
        $this->assertEquals($projectOne->id, $project->id);
        $this->assertEquals($projectOne->user_id, $project->user_id);
        $this->assertEquals($projectOne->title, $project->title);
    }

    public function testCreateProject(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $project = new Project([
            'user_id' => $user->id,
            'title' => 'Title one',
        ]);

        $result = $this->projectRepository->create($project);

        $this->assertNotNull($result);
        $this->assertInstanceOf(Project::class, $result);
        $this->assertEquals($project->title, $result->title);
    }

    public function testUpdateProject(): void
    {
        /** @var Project $project */
        $project = Project::factory()->create();
        $candidateProject = new Project([
            'title' => 'Title one',
        ]);

        $result = $this->projectRepository->update($project, $candidateProject);

        $this->assertEquals($candidateProject->title, $result->title);
    }

    public function testDeleteProject(): void
    {
        /** @var Project $project */
        $project = Project::factory()->create();

        $result = $this->projectRepository->delete($project);

        $this->assertIsBool($result);
        $this->assertEquals(true, $result);
    }

    public function testGetProjectById(): void
    {
        /** @var Project $project */
        $project = Project::factory()->create();

        $result = $this->projectRepository->getById($project->id, $project->user_id);

        $this->assertNotNull($result);
        $this->assertInstanceOf(Project::class, $result);
        $this->assertEquals($project->title, $result->title);
    }
}
