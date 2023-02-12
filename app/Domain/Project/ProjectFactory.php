<?php

namespace App\Domain\Project;

use App\Domain\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ProjectFactory
{
    use Validator;

    /**
     * @throws ValidationException
     */
    public static function fromArray(array $data): Project
    {
        $rules = [
            'title' => 'required|string|min:1|max:255',
            'user_id' => 'required|integer|exists:App\Models\User,id',
        ];

        $validData = self::validateData($data, $rules);

        return (new Project())->fill([
            'title' => $validData['title'],
            'user_id' => $validData['user_id'],
        ]);
    }
}
