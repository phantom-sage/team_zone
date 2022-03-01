<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
    ];

    /**
     * users the messages belongs to them.
     *
     * @return MorphToMany
     */
    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'messagealbe');
    }

    /**
     * team member the messages belongs to them.
     *
     * @return MorphToMany
     */
    public function team_members(): MorphToMany
    {
        return $this->morphedByMany(TeamMember::class, 'messagealbe');
    }
}
