<?php

namespace App\Http\Controllers;

use App\Models\Room;

class RoomController extends BaseController
{
    public function view(Room $room)
    {
        return view('rooms.index', [
            'room' => $room
        ]);
    }

    public function join(string $token)
    {
        $roomId = decrypt($token);
        $room = Room::findOrFail($roomId);
        return view('rooms.join', [
            'room' => $room
        ]);
    } 
}
