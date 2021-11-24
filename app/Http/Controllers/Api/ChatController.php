<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ResponseJson;
use App\Models\User;
use App\Models\Room;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    use ResponseJson;

    public function __construct(User $table, User $room)
    {
        $this->table = $table;
        $this->room = $room;
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
                $data = $this->room->getRooms($user->uuid);
            } else {
                // create new user
                $data = $this->table->insert($request->all());
                // DB::commit();
            }

            return $this->responseWithCondition($data, 'success', 200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }

    }
}
