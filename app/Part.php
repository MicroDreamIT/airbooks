<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    protected $fillable = [
        'uid',
        'title',
        'part_number',
        'alternate_part_number',
        'quantity',
        'promote_status',
        'description',
        'views'
    ];
    protected $appends = [
        'modelType'
    ];

    public function getModelTypeAttribute()
    {
        return 'part';
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function contact(){
        return $this->belongsTo(Contact::class, 'primary_contact');
    }

    public function condition(){
        return $this->belongsTo(Condition::class);
    }

    public function leads()
    {
        return $this->morphMany(Lead::class, 'leadable');
    }

    public function release(){
        return $this->belongsTo(Release::class);
    }
    public function currentLocation(){
        return $this->belongsTo(Country::class,'location');
    }

    public function owner(){
        return $this->belongsTo(Company::class,'owner');
    }

    public function seller(){
        return $this->belongsTo(Company::class,'seller');
    }

}
