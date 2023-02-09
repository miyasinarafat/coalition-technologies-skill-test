<?php

namespace App\Domain\Project;

use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/***
 * @property-read int id
 * @property int user_id
 * @property string title
 */
class Project extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title'];

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return ProjectFactory::new();
    }
}
