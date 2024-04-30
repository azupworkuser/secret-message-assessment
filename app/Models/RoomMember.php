<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

class RoomMember extends Base
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['room_id', 'user_id'];

    public function room(): HasOne
    {
        return $this->hasOne(Room::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
