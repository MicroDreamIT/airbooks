<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $guarded=['id','file'];

    public function manufacturer(){
        return $this->belongsTo(Manufacturer::class);
    }

    public function medias()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    public function aircrafts()
    {
        return $this->hasMany(Aircraft::class);
    }
}
