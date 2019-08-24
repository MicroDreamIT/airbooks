<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $guarded=['id','file', 'categories'];


    public function engineManufacturers()
    {
        return $this->hasMany(Aircraft::class, 'engine_manufacturer_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function aircrafts()
    {
        return $this->hasMany(Aircraft::class, 'manufacturer_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function medias()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

}
