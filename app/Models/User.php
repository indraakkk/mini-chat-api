<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUuid;

class User extends Model
{
    use GenerateUuid;

    protected $table = 'users';

    protected $fillable = [
        'uuid', 'name', 'email'
    ];

    public function get()
    {
        return $this->all();
    }

    public function insert($arr)
    {
        return $this->create($arr);
    }

    public function login($arr)
    {
        return $this->where($arr)->first();
    }
}
