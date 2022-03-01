<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class TeamMember extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'email',
        'type',
    ];

    /**
     * projects team member works on.
     *
     * @return BelongsToMany
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot([
            'role',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * project managed by project manager.
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * messages of user.
     *
     * @return MorphToMany
     */
    public function messages(): MorphToMany
    {
        return $this->morphToMany(Message::class, 'messageable');
    }

    /**
     * task team member has.
     *
     * @return HasOne
     */
    public function task(): HasOne
    {
        return $this->hasOne(Task::class);
    }
}
