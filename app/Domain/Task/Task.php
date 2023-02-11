<?php

namespace App\Domain\Task;

use App\Domain\Project\Project;
use App\Models\User;
use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

/***
 * @property-read int id
 * @property int user_id
 * @property int project_id
 * @property int list_id
 * @property string title
 * @property string description
 * @property double position
 * @property-read TaskList $list
 * @property-read Project $project
 * @property-read User $user
 */
class Task extends Model
{
    use HasFactory;

    private const POSITION_GAP = 60000;
    private const POSITION_MIN = 0.00002;

    protected $fillable = [
        'user_id',
        'project_id',
        'list_id',
        'title',
        'description',
        'position',
    ];

    public static function booted(): void
    {
        static::creating(function ($model) {
            $model->position = self::query()
                    ->where('project_id', $model->project_id)
                    ->where('list_id', $model->list_id)
                    ->orderByDesc('position')
                    ->first()?->position + self::POSITION_GAP;
        });

        static::saved(function ($model) {
            if ($model->position < self::POSITION_MIN) {
                DB::statement("SET @previousPosition := 0");
                DB::statement("
                    UPDATE tasks
                    SET position = (@previousPosition := @previousPosition + ?)
                    WHERE list_id = ?
                    ORDER BY position
                ", [
                    self::POSITION_GAP,
                    $model->list_id,
                ]);
            }
        });
    }

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
     * @return BelongsTo
     */
    public function list(): BelongsTo
    {
        return $this->belongsTo(TaskList::class, 'list_id', 'id');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return TaskFactory::new();
    }
}
