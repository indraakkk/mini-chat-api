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

    public function sendChatProcess($request)
    {
        DB::beginTransaction();

        try {
            // find  room and update receive unread count
            $filter = [
                'user_uuid' => $request->to_user_uuid,
                'room_id'   => $request->room_id
            ];
            $updateUnreads = $this->updateUnreads($filter, 1);

            $data = [
                'message' => $request->message,
                'room_id' => $request->room_id,
                'user_uuid' => $request->user_uuid
            ];

            $send = $this->chat->storeChat($data);


            if ($send) {
                $filter = [
                    'user_uuid' => $request->user_uuid,
                    'room_id'   => $request->room_id
                ];

                $updateUnreads = $this->updateUnreads($filter, 0);
                DB::commit();

                return $this->chat->getByRoomId($request->room_id);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function sendChat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to_user_uuid' => 'required',
            'user_uuid' => 'required',
            'room_id'   => 'required',
            'message'   => 'required'
        ]);

        if($validator->fails())
            throw new ValidationException($validator);

        $send = $this->sendChatProcess($request);

        return $this->responseWithCondition($send, 'success', 200);
    }

    public function updateUnreads($filter, $state)
    {
        $room = $this->room->findRoom($filter);

        if ($state) {
            $room->unread = $room->unread + 1;
        } else {
            $room->unread = $state;
        }
        $room->save();

        return true;
    }

    public function listUserRooms($uuid)
    {
        try {
            $data = $this->table->getByUuid($uuid);
            return $this->responseWithCondition($data, 'success', 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function listUserChat(Request $request)
    {
        try {
            $filter = [
                'user_uuid' => $request->user_uuid,
                'room_id'   => $request->room_id
            ];

            $updateUnreads = $this->updateUnreads($filter, 0);

            $data = $this->chat->getByRoomId($request->room_id);

            return $this->responseWithCondition($data, 'success', 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
