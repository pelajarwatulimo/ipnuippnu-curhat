<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
