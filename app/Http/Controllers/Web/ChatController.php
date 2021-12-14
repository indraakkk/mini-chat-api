<?php

namespace App\Http\Controllers\Web;

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

    public function index()
    {
        $data = [
            [
                "url" => "/api/v1/chats",
                "description" => "Login or create new user",
                "method" => "POST",
            ],
            [
                "url" => "/api/v1/create",
                "description" => "Create room",
                "method" => "POST",
            ],
            [
                "url" => "/api/v1/send",
                "description" => "Send chat",
                "method" => "POST",
            ],
            [
                "url" => "/api/v1/list/{uuid}",
                "description" => "List room of user",
                "method" => "GET",
            ],
            [
                "url" => "/api/v1/chats",
                "description" => "List chat of user",
                "method" => "POST",
            ],
            [
                "url" => "/api/v1/chats",
                "description" => "List chat of user",
                "method" => "POST",
            ],
        ];

        return $this->responseWithCondition($data, 'success', 200);
    }
}
