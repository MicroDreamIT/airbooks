<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected  $guarded = ['id', 'file', 'removeFiles'];

    public function aircrafts()
    {
        return $this->hasMany(Aircraft::class, 'registered_in');
    }


    public function medias()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    public function states(){

       return $this->hasMany(State::class);
    }

    public function region(){

        return $this->belongsTo(Region::class);
    }
    public function continent(){

        return $this->belongsTo(Continent::class);
    }
}
