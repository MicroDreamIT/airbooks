<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aircraft extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'uid',
        'MSN',
        'YOM',
        'seating_first_class',
        'seating_business',
        'seating_economy',
        'offer_for',
        'mgh',
        'per_block_hour',
        'cpd',
        'price',
        'terms',
        'availability',
        'status',
        'aircraft_registration',
        'description',
        'isActiveStatus',
        'status_reason',
        'promote_status',
        'is_featured',
        'is_published',
        'views'
    ];

    protected $with=['likes', 'attaches','favourites'];
    protected $appends = [
        'modelType', 'linkify','hasLike'
    ];

    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }

    public function getHasLikeAttribute()
    {

        if(auth()->guest()){
            return false;
        }

        foreach ($this->relations['likes'] as $like){
            return $like->user_id==auth()->id();
        }
    }

    public function getLinkifyAttribute()
    {
        return strtolower($this->id.'-'.str_replace(' ','-',$this->title));
    }

    public function getModelTypeAttribute()
    {
        return 'aircraft';
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }

    public function attaches()
    {
        return $this->morphMany(Attach::class, 'attachable');
    }

    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favouritable');
    }

    public function leads()
    {
        return $this->morphMany(Lead::class, 'leadable');
    }


    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function engineType()
    {
        return $this->belongsTo(Type::class, 'engine_type_id');
    }

    public function registeredIn()
    {
        return $this->belongsTo(Country::class, 'registration_country');
    }

    public function primaryContact()
    {
        return $this->belongsTo(Contact::class,'primary_contact');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function engineManufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'engine_manufacturer_id');
    }

    public function modeled()
    {
        return $this->belongsTo(Modeled::class, 'model_id');
    }

    public function engineModel()
    {
        return $this->belongsTo(Modeled::class, 'engine_model_id');
    }


    public function owner()
    {
        return $this->belongsTo(Company::class,'owner_id');
    }

    public function previousOperator()
    {
        return $this->belongsTo(Company::class,'previous_operator');
    }

    public function currentOperator()
    {
        return $this->belongsTo(Company::class,'current_operator');
    }

    public function manager()
    {
        return $this->belongsTo(Company::class,'manager_id');
    }

    public function seller()
    {
        return $this->belongsTo(Company::class,'seller_id');
    }

    public function currentLocation()
    {
        return $this->belongsTo(Country::class,'current_location');
    }

    public function configuration()
    {
        return $this->belongsTo(Configuration::class,'configuration_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);

    }

    public function medias()
    {
        return $this->morphMany(Media::class, 'mediable');
    }


}
