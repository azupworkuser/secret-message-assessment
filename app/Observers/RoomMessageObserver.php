<?php

namespace App\Observers;

use App\Models\RoomMessage;

class RoomMessageObserver
{
    /**
     * Handle the RoomMessage "updated" event.
     */
    public function updated(RoomMessage $roomMessage): void
    {
        if ($roomMessage->read_count > 0 && $roomMessage->read_once) {
            $roomMessage->delete();
        }
    }
}
