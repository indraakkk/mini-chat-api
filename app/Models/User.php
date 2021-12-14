<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use GenerateUuid, HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'uuid', 'name', 'email'
    ];

    public function get()
    {
        return $this->with('rooms')->get();
    }

    public function getByUuid($uuid)
    {
        return $this->where('uuid', $uuid)->with('rooms')->get();
    }

    public function insert($arr)
    {
        return $this->create($arr);
    }

    public function login($arr)
    {
        return $this->where($arr)->first();
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'user_uuid', 'uuid');
    }
}
