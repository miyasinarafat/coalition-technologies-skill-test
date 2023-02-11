<?php

namespace Database\Factories;

use App\Domain\Task\Task;
use App\Domain\Task\TaskList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Task\Task>
 */
class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        /** @var TaskList $column */
        $list = TaskList::factory()->create();

        return [
            'user_id' => $list->user_id,
            'project_id' => $list->project_id,
            'list_id' => $list->id,
            'title' => $this->faker->title(),
            'description' => $this->faker->paragraph(),
            'position' => 1,
        ];
    }
}
