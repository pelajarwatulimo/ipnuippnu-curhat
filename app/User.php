<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;


    protected $dates = ['created_at', 'updated_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function message()
    {
        return $this->hasMany(Message::class);
    }

    public function message_answer()
    {
        return $this->hasMany(MessageAnswer::class);
    }

    public function broadcast()
    {
        return $this->hasMany(Broadcast::class);
    }

    public function panggilan()
    {
        $nama = $this->name;
        $nama = explode(' ', $nama);
        if( count($nama) == 1 )
            return $this->name;

        $panggilan = $nama[0];
        foreach( config('namaindo') as $nama )
        {
            if( preg_match($nama, $this->name) )
            {
                $this->name = preg_replace($nama, "", $this->name);
                break;
            }
        }

        return explode(" ", $this->name)[0];
    }

    public function avatar()
    {
        if( $this->avatar == null )
            return 'default.jpg';

        return $this->avatar;
    }

    public function jabatan()
    {
        $jabatan = preg_replace("/^\[(.*)\]/", '', $this->jabatan);
        return $jabatan;
    }

}
