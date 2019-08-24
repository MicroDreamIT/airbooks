<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'likable_id',
        'likable_type',
    ];

    protected $table = 'likes';

    public function likable()
    {
        return $this->morphTo();
    }

    public function contact(){
        return $this->belongsTo(Contact::class,'likable_id','id');
    }
}
