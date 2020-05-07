<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['message', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function message_answer()
    {
        return $this->hasMany(MessageAnswer::class);
    }

    public function last_message()
    {
        if( $this->message_answer->count() > 0 )
        {
            $return = $this->message_answer->last();
            $return['message'] = app('profanityFilter')->filter($return['message']);
            return $return;
        }

        $return = $this;
        $return['message'] = app('profanityFilter')->filter($return['message']);
        return $return;
    }
}
