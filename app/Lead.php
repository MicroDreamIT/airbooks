<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $guarded=[];

    public function user(){
        return $this->belongsTo(User::class,'creator_id');
    }



    public function leadable()
    {
        return $this->morphTo();
    }
}
