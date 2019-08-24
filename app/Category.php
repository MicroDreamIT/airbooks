<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=['name', 'type', 'is_active', 'description'];

    public function medias()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    public function aircrafts()
    {
        return $this->hasMany(Aircraft::class);
    }

    public function manufacturers(){
        return $this->hasMany(Manufacturer::class);
    }

}
