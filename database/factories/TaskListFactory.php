<?php

namespace Database\Factories;

use App\Domain\Project\Project;
use App\Domain\Task\TaskList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Task\TaskList>
 */
class TaskListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TaskList::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        /** @var Project $project */
        $project = Project::factory()->create();

        return [
            'user_id' => $project->user_id,
            'project_id' => $project->id,
            'title' => $this->faker->title(),
        ];
    }
}
