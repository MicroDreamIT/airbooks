<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Billable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, Billable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','email_verified', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $with=['contact.company'];

    public function mediaString()
    {
        $auth = auth()->user();
        if($auth->contact->medias){
            $image = $auth->contact->medias;
            return '/storage/'. $image->path . '/' . $image->original_file_name;
        }else{
            return false;
        }
    }

    public function contacts()
    {
        return $this->belongsTo(Contact::class, 'creator_id');
    }

    public function contact()
    {
        return $this->hasOne(Contact::class, 'user_id');
    }
    public function roles()
    {
        return $this->belongsToMany(Roled::class,'role_user','role_id','user_id')->withTimestamps();
    }

    public function hasRoleType()
    {
        $data=DB::table('users')
            ->leftJoin('role_user','users.id','=','role_user.user_id')
            ->leftJoin('roles','roles.id','=','role_user.role_id')
            ->select('users.id as user_id','roles.id as role_id','roles.name')
            ->where('users.id','=',Auth::user()->id)
            ->first();
        return $data->name;
    }


    public function checkin()
    {
        return 'asdf';

    }

    public function getAllPermissionData(){
         $userId=auth()->user()->id;
         $role=DB::table('role_user')->select('roles.name','role_id')
             ->leftJoin('roles','role_user.role_id','=','roles.id')
             ->whereUserId($userId)->first();

            $permissions=DB::table('permissions as p')
                 ->select('p.name')
                ->leftjoin('permission_user as pu','pu.permission_id','=','p.id')
                 ->where('pu.user_id',$userId)
                ->get();
            $permissionList=[];

        foreach ($permissions as $permission){
            $permissionList[]=$permission->name;
        };

        $roleAndPermission=[$role->name,$permissionList];
        return $roleAndPermission;

    }


    public function medias()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'user_id');
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class, 'user_id');
    }

    public function accesslogs()
    {
        return $this->hasMany(Accesslog::class);
    }


}
