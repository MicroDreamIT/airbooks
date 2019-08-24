<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $guarded=['id'];
    public function configurations()
    {
        return $this->hasMany(Aircraft::class,'configuration_id');
    }
}
