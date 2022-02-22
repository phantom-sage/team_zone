<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'deadline',
        'client_id',
    ];

    /**
     * owner of project.
     *
     * @return BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * Team members works on project.
     *
     * @return BelongsToMany
     */
    public function staff()
    {
        return $this->belongsToMany(TeamMember::class)->withPivot([
            'role',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * project manager.
     *
     * @return HasOne
     */
    public function manager()
    {
        return $this->hasOne(TeamMember::class);
    }
}
