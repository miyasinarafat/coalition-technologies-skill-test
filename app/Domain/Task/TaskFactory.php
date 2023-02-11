<?php

namespace App\Domain\Task;

use App\Domain\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TaskFactory
{
    use Validator;

    /**
     * @throws ValidationException
     */
    public static function fromArray(array $data): Task
    {
        $rules = [
            'title' => 'required|string|min:1|max:255',
            'description' => 'nullable|string',
            'list_id' => 'required|integer|exists:App\Domain\Task\TaskList,id',
            'project_id' => 'required|integer|exists:App\Domain\Project\Project,id',
        ];

        $validData = self::validateData($data, $rules);

        return (new Task())->fill([
            'title' => $validData['title'],
            'description' => $validData['description'] ?? null,
            'list_id' => $validData['list_id'],
            'project_id' => $validData['project_id'],
            'user_id' => Auth::id(),
        ]);
    }
}
