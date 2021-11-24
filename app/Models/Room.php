<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUuid;

class Room extends Model
{
    use GenerateUuid;

    protected $table = 'rooms';

    protected $fillable = [
        'uuid', 'name', 'value', 'user_uuid'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }
}
