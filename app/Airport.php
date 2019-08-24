<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    protected $guarded=['id'];
    protected $with=['likes','favourites'];
    protected $appends = [
        'linkify','modelType'
    ];


    public function getLinkifyAttribute()
    {
        return strtolower($this->id.'-'.str_replace(' ','-',$this->name));
    }

    public function getModelTypeAttribute()
    {
        return 'airport';
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function airfield()
    {
        return $this->belongsTo(Airfield::class, 'airfield_type_id');
    }

    public function currentLocations()
    {
        return $this->hasMany(Aircraft::class,'current_location');
    }
    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }

    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favouritable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);

    }

}
