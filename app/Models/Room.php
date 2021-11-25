<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUuid;

class Room extends Model
{
    use GenerateUuid;

    protected $table = 'rooms';

    protected $fillable = [
        'uuid','room_id','unread','user_uuid'
    ];

    public function get()
    {
        return $this->get();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    public function createRoom($arr)
    {
        return $this->create($arr);
    }

    public function userRooms($uuid)
    {
        return $this->where('user_uuid', $uuid)->get();
    }

    public function findRoom($filter)
    {
        return $this->where($filter)->first();
    }
}
