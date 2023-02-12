<?php

namespace App\Domain\Task;

use App\Domain\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TaskListFactory
{
    use Validator;

    /**
     * @throws ValidationException
     */
    public static function fromArray(array $data): TaskList
    {
        $rules = [
            'title' => 'required|string|min:1|max:255',
            'user_id' => 'required|integer|exists:App\Models\User,id',
            'project_id' => 'required|integer|exists:App\Domain\Project\Project,id',
        ];

        $validData = self::validateData($data, $rules);

        return (new TaskList())->fill([
            'title' => $validData['title'],
            'user_id' => $validData['user_id'],
            'project_id' => $validData['project_id'],
        ]);
    }
}
