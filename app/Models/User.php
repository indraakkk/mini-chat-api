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
}
