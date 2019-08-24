<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attach extends Model
{
    protected $fillable = [
        'type',
        'path',
        'original_file_name',
        'is_featured',
        'is_active',
        'user_id',
        'accessibility',
        'mediable_type',
        'mediable_id'
    ];

    protected $table = 'attaches';

    public function attachable()
    {
        return $this->morphTo();
    }
}
