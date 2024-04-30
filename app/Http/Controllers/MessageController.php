<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddMessageRequest;
use App\Http\Requests\MarkAsReadRequest;
use App\Models\Room;
use App\Models\RoomMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class MessageController extends BaseController
{
    /**
     * Responsible to Return the list of room members and their messages
     * @param Room $room
     */
    public function index(Room $room)
    {
        return Response::json([
            'members' => $room->members->map(function ($member) {
                return [
                    'id' => $member->user->id,
                    'room_id' => $member->room_id,
                    'first_name' => $member->user->first_name,
                    'last_name' => $member->user->last_name,
                    'identifier' => $member->user->identifier
                ];
            }),
            'messages' => $room->messages->map(function ($message) {
                return [
                    'sender' => $message->sender,
                    'recipient' => $message->recipient,
                    'body' => $message->body,
                    'recipient_decription_key'=> $message->recipient_decription_key,
                    'sender_decription_key'=> $message->sender_decription_key,
                    'read_once' => ($message->read_count > 0 && $message->read_once),
                    'created_at' => $message->created_at
                ];
            })
        ]);
    }

    /**
     * Responsible to send new message
     * @param AddMessageRequest $request
     */    
    public function add(AddMessageRequest $request)
    {
        $room = Room::findOrFail($request->room_id);
        $data = $request->validated();
        
        $data['read_once'] = $data['read_once'] > 0;
        if (!$data['read_once'] && $data['expire_days'] > 0) {
            $data['expire_time'] = Carbon::now()->addDays($data['expire_days'])->timestamp;
        }

        $message = new RoomMessage($data);
        $message->save();

        return redirect()->route('rooms.index', ['room' => $room]);
    }

    /**
     * Responsible to mark the message as Read once the message is read by the recipient.
     * Will also increase the read_count
     * @param MarkAsReadRequest $request
     */
    public function markAsRead(MarkAsReadRequest $request)
    {
        $room = Room::findOrFail($request->room_id);
        $room->messages->each(function ($message) use ($request) {
            if ($message->recipient_id == $request->login_id) {
                $message->update([
                    'read_count' => $message->read_count + 1
                ]);
            }

            if (!empty($message->expire_time) && $message->expire_time <= Carbon::now()->timestamp) {
                $message->delete();
            }
        });

        return Response::json();
    }
}
