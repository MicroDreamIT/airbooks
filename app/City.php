<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $guarded = ['id'];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function aircrafts()
    {
        return $this->hasMany(Aircraft::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
