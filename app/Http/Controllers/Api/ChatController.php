<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ResponseJson;
use App\Models\User;
use App\Models\Room;
use App\Models\Chat;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    use ResponseJson;

    public function __construct(User $table, Room $room, Chat $chat)
    {
        $this->table = $table;
        $this->room  = $room;
        $this->chat  = $chat;
    }

    public function loginOrCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'email' => 'required'
        ]);

        if($validator->fails())
            throw new ValidationException($validator);

        DB::beginTransaction();
        try {
            // check if user exist
            $user = $this->table->login($request->all());
            if ($user) {
                // return list of chat rooms
                $data = $this->table->getByUuid($user->uuid);
            } else {
                // create new user
                $data = $this->table->insert($request->all());
                DB::commit();
            }

            return $this->responseWithCondition($data, 'success', 200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function createChat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from_user_uuid' => 'required',
            'to_user_uuid'   => 'required'
        ]);

        if($validator->fails())
            throw new ValidationException($validator);

        DB::beginTransaction();

        try {
            $room_id = strval(rand(0000000000, 9999999999));
            $room_data = [
                [
                    'room_id'   => $room_id,
                    'unread'    => 0,
                    'user_uuid' => $request->from_user_uuid
                ],
                [
                    'room_id'   => $room_id,
                    'unread'    => 0,
                    'user_uuid' => $request->to_user_uuid
                ]
            ];

            foreach ($room_data as $key => $value) {
                $this->room->createRoom($value);
            }

            // $data = $this->room->createRoom($request->all());

            // if ($request->message) {
            //     $chat_data = [
            //         'room_id' => $room_id,
            //         'user_uuid' => $request->from_user_uuid,
            //         'message' => $request->message
            //     ];

                // run update room and send user chat
                // $this->sendChatProcess($request->all(), $chat_data);
            // }

            DB::commit();

            return $this->responseWithCondition($this->table->getByUuid($request->from_user_uuid), 'success', 200);

        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function sendChatProcess($request, $data)
    {
        DB::beginTransaction();

        try {
            // find  room
            $room = $this->room->findRoom($request->to_user_uuid, $room_id);
            $update = [
                'unread' => $room->unread + 1
            ];
            if ($update) {
                $this->chat->sendChat($data);
            }

            DB::commit();

            return true;

        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
}
