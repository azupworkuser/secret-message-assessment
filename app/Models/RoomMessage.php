<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomMessage extends Base
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'room_id', 
        'sender_id', 
        'recipient_id', 
        'body',
        'recipient_decription_key',
        'sender_decription_key',
        'read_once',
        'read_count',
        'expire_time'
    ];

    /**
     * The attributes that are castable.
     *
     * @var array
     */
    protected $casts = [
        'body' => 'encrypted',
        'recipient_decription_key' => 'encrypted',
        'sender_decription_key' => 'encrypted'
    ];

    public function room(): HasOne
    {
        return $this->hasOne(Room::class);
    }

    public function sender(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }

    public function recipient(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'recipient_id');
    }
}
