<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * clients projects.
     * @return HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
