<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accesslog extends Model
{
    protected $fillable = ['payload'];

    protected $casts = ['payload'=>'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
