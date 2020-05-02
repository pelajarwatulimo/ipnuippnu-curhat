<?php

namespace App;

use App\Events\MessageAnswerSuccess;
use Illuminate\Database\Eloquent\Model;

class MessageAnswer extends Model
{
    protected $dates = ['created_at', 'updated_at'];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
