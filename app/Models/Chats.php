<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUuid;

class Chat extends Model
{
    use GenerateUuid;

    protected $table = 'chats';

    protected $fillable = [
        'uuid','message','user_uuid','room_id'
    ];

    public function getByRoomId($id)
    {
        return $this->where('room_id', $id)->get();
    }
}
