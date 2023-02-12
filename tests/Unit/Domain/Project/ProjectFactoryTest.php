<?php

namespace Tests\Unit\Domain\Project;

use App\Domain\Project\Project;
use App\Domain\Project\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ProjectFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function testFromArrayWithValidData(): void
    {
        /** @var Project $project */
        $project = Project::factory()->create();
        $data = [
            'user_id' => $project->user_id,
            'title' => $project->title,
        ];

        $result = ProjectFactory::fromArray($data);

        $this->assertInstanceOf(Project::class, $result);
        $this->assertEquals($project->user_id, $result->user_id);
    }

    public function testFromArrayWithInvalidData(): void
    {
        $this->expectException(ValidationException::class);

        $data = [
            'user_id' => 1,
            'title' => null,
        ];

        ProjectFactory::fromArray($data);
    }
}
