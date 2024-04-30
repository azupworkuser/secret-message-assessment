<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\URL;

class Room extends Base
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title'];

    /**
     * Get all of the room members.
     */
    public function members(): HasMany
    {
        return $this->hasMany(RoomMember::class);
    }

    /**
     * Get all of the room messages.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(RoomMessage::class);
    }

    public function getUrlAttribute(): string
    {
        return URL::route('rooms.join', [
            'token' => encrypt($this->id)
        ]);
    }
}
