<?php

namespace App\Domain\Project;

use App\Domain\Task\TaskList;
use App\Models\User;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * @return HasMany
     */
    public function lists(): HasMany
    {
        return $this->hasMany(TaskList::class, 'project_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

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
