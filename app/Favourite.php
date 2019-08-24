<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{

    protected $fillable = [
        'favouritable_id',
        'favouritable_type',
        'user_id'
    ];

    protected $table = 'favourites';

    public function favouritable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class,'creator_id');
    }

}
