<?php

namespace App\Domain\Task;

use App\Domain\Project\Project;
use App\Models\User;
use Database\Factories\TaskListFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/***
 * @property-read int id
 * @property int user_id
 * @property int project_id
 * @property string title
 * @property-read Collection $tasks
 * @property-read Project $project
 * @property-read User $user
 */
class TaskList extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'project_id', 'title'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'list_id', 'id');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return TaskListFactory::new();
    }
}
