<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Base
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'email', 'identifier'];

    /**
     * Get all of the rooms.
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(RoomMember::class);
    }
}
