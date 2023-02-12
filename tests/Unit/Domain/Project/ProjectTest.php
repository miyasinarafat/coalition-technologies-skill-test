<?php

namespace Tests\Unit\Domain\Project;

use App\Domain\Project\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function testProjectCreate(): void
    {
        /** @var Project $project */
        $project = Project::factory()->create();

        $this->assertInstanceOf(Project::class, $project);
        $this->assertNotNull($project->title);
    }
}
