<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apu extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'uid',
        'title',
        'availability',
        'status',
        'serial_number',
        'part_number',
        'offer_for',
        'price',
        'lease_terms',
        'exchange_terms',
        'description',
        'status_reason',
        'lsv_description',
        'thrust_rating',
        'promote_status',
        'cycle_remaining',
        'is_featured',
        'views',
        'isActiveStatus',
    ];

    protected $with=['likes', 'favourites', 'attaches'];

    protected $appends = [
        'modelType', 'linkify'
    ];

    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }


    public function attaches()
    {
        return $this->morphMany(Attach::class, 'attachable');
    }

    public function getLinkifyAttribute()
    {
        return strtolower($this->id.'-'.str_replace(' ','-',$this->title));
    }

	public function likes()
	{
		return $this->morphMany(Like::class, 'likable');
	}
	public function favourites()
	{
		return $this->morphMany(Favourite::class, 'favouritable');
	}
    public function leads()
    {
        return $this->morphMany(Lead::class, 'leadable');
    }
	
	public function getModelTypeAttribute()
    {
        return 'apu';
    }


    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function manufacturer(){
        return $this->belongsTo(Manufacturer::class);
    }

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function model(){
        return $this->belongsTo(Modeled::class);
    }

    public function contact(){
        return $this->belongsTo(Contact::class, 'primary_contact');
    }

    public function currentLocation(){
        return $this->belongsTo(Country::class,'current_location');
    }

    public function owner(){
        return $this->belongsTo(Company::class,'owner_id');
    }

    public function seller(){
        return $this->belongsTo(Company::class,'seller_id');
    }
    public function listedBy(){
        return $this->belongsTo(User::class,'listed_by');
    }
	public function medias()
	{
		return $this->morphMany(Media::class, 'mediable');
	}
 
}
