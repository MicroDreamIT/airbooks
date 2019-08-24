<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
   protected $table='cms';
    protected $guarded=['id','file', 'removeFiles'];

    public function medias()
    {
        return $this->morphOne(Media::class, 'mediable');
    }


}
