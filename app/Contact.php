<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'first_name',
        'last_name',
        'gender',
        'business_phone',
        'mobile_phone',
        'skype',
        'linkedin',
        'address',
        'message',
        'contact_date',
        'preferred_contact_method',
        'religion',
        'birthday',
        'is_published',
        'is_primary',
        'is_public',
        'views',
        'email'
    ];
    protected $with=['medias', 'likes'];

    protected $appends = [
        'modelType','linkify','fullName'
    ];

    public function getLinkifyAttribute()
    {
        return strtolower($this->id.'-'.str_replace(' ','-',$this->first_name.'-'.$this->last_name));
    }

    public function getModelTypeAttribute()
    {
        return 'contact';
    }

    public function getFullNameAttribute($value)
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }
    public function leads()
    {
        return $this->morphMany(Lead::class, 'leadable');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }

    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favouritable');
    }

    public function jobTitle()
    {
        return $this->belongsTo(Title::class, 'job_title');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function medias()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function primaryContacts()
    {
        return $this->hasMany(Aircraft::class,'primary_contact');
    }
}
