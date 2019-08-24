<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded =['id','file','removeFiles'];
    protected $with = ['medias','likes','favourites'];

    protected $appends = [
        'modelType','linkify'
    ];


    public function getModelTypeAttribute()
    {
        return 'companies';
    }
    public function contact()
    {
        return $this->hasOne(Contact::class, 'company_id');
    }
    public function getLinkifyAttribute()
    {
        return strtolower($this->id.'-'.str_replace(' ','-',$this->name));
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }

    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favouritable');
    }

    public function specialities(){
        return $this->belongsToMany(Speciality::class);
    }
    public function city(){
        return $this->belongsTo(City::class);
    }
    public function state(){
        return $this->belongsTo(State::class);
    }
    public function country(){
        return $this->belongsTo(Country::class);
    }
    public function medias()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    public function previousOperators()
    {
        return $this->hasMany(Aircraft::class, 'previousOperator');
    }

    public function currentOperators()
    {
        return $this->hasMany(Aircraft::class, 'current_operator');
    }

    public function managers()
    {
        return $this->hasMany(Company::class,'manager');
    }

    public function sellers()
    {
        return $this->hasMany(Company::class,'seller');
    }

    public function owners()
    {
        return $this->hasMany(Aircraft::class,'owner');
    }
}
