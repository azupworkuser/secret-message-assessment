<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RegisterRoomRequest;
use App\Models\Room;
use App\Models\RoomMember;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\URL;

class RegisterController extends BaseController
{
    public function register(RegisterRequest $request)
    {
        $user = new User($request->validated());
        $user->save();

        $faker = Faker::create();
        $room = new Room([
            'title' => $faker->company()
        ]);
        $room->save();

        RoomMember::create([
            'room_id' => $room->id,
            'user_id' => $user->id
        ]);

        return redirect()->route('rooms.index', ['room' => $room])
            ->with('user_id', $user->id)
            ->with('room_url', URL::route('rooms.index', ['room' => $room]));
    }

    public function registerRoom(RegisterRoomRequest $request)
    {
        $room = Room::findOrFail($request->room_id);
        if (count($room->members) >= 2) {
            return redirect()->back()->with('error', 'Room is full.');
        }

        $user = new User($request->validated());
        $user->save();

        RoomMember::create([
            'room_id' => $room->id,
            'user_id' => $user->id
        ]);

        return redirect()->route('rooms.index', ['room' => $room])
            ->with('user_id', $user->id)
            ->with('room_url', URL::route('rooms.index', ['room' => $room]));
    }
}
