<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
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
        'mediable_id',
        'meta_name'
    ];

    protected $table = 'medias';

    public function mediable()
    {
        return $this->morphTo();
    }
}
