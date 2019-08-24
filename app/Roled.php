<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roled extends Model
{
    protected $table='roles';

    public function users()
    {
        return $this->belongsToMany(User::class,'role_user', 'user_id','role_id')->withTimestamps();
    }




}
