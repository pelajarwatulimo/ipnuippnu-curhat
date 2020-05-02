<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ranting extends Model
{

    protected $dates = ['created_at', 'updated_at'];
    protected $table = 'ranting';
}
