<?php

namespace App\Http\Controllers;

use App\Models\Room;

class RoomController extends BaseController
{
    /**
     * Responsible for render the rooms index page.
     *
     * @param Room $room
     */
    public function view(Room $room)
    {
        return view('rooms.index', [
            'room' => $room
        ]);
    }

    /**
     * Responsible for show the join room form.
     *
     * @param string $token
     */
    public function join(string $token)
    {
        $roomId = decrypt($token);
        $room = Room::findOrFail($roomId);
        return view('rooms.join', [
            'room' => $room
        ]);
    } 
}
