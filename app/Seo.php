<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $fillable = [
        'model_id',
        'model_type',
        'method',
        'title',
        'description',
        'is_active'
    ];

    public function medias()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

}
