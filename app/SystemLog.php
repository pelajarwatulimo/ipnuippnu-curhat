<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    public static function lapor($isi, $type = 'act')
    {
        $a = new SystemLog;
        $a->type = $type;
        $a->value = $isi;
        $a->save();
        return $a;
    }
}
