<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modeled extends Model
{
    protected $table = 'models';
    protected $guarded=['id','file'];

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function engineModels()
    {
        return $this->hasMany(Aircraft::class, 'engine_model_id');
    }

    public function aircrafts()
    {
        return $this->hasMany(Aircraft::class, 'model_id');
    }

    public function medias()
    {
        return $this->morphOne(Media::class, 'mediable');
    }
}
