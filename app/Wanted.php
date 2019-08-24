<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wanted extends Model
{
	protected $fillable = [
 
		'yom',
		'title',
        'uid',
		'part_number',
		'type',
		'terms',
		'is_active',
		'is_featured',
		'comments',
        'promote_status',
		'custom',
        'wanted_by',
        'views'
	];
	protected $with=['likes','favourites'];
	protected $casts = [
	    'custom'=>'array'
    ];
    protected $appends = [
        'modelType', 'linkify'
    ];

    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }

    public function getLinkifyAttribute()
    {
        return strtolower($this->id.'-'.str_replace([' ', '.'],'-',$this->title));
    }

    public function getModelTypeAttribute()
    {
        return 'wanted';
    }

	public function user(){
		return $this->belongsTo(User::class, 'user_id');
	}

	public function likes()
	{
		return $this->morphMany(Like::class, 'likable');
	}
    public function leads()
    {
        return $this->morphMany(Lead::class, 'leadable');
    }

	public function favourites()
	{
		return $this->morphMany(Favourite::class, 'favouritable');
	}

	public function contact(){
		return $this->belongsTo(Contact::class, 'primary_contact');
	}

	public function manufacturer(){
		return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
	}

	public function typed(){
		return $this->belongsTo(Type::class, 'type_id');
	}

	public function modeled(){
		return $this->belongsTo(Modeled::class, 'model_id');
	}
    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }
}

