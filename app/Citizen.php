<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    public function setBussAttribute($value){
        $this->attributes['buss'] = $value ? json_encode($value) : null;
    }
}
