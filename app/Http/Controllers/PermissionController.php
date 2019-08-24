<?php

namespace App\Http\Controllers;

use App\Roled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function index()
    {
         $query=DB::table('users')
            ->select('contacts.first_name', 'contacts.last_name','users.id')
            ->selectRaw("GROUP_CONCAT(ab_permissions.name SEPARATOR ', ') as permission_name")
            ->leftJoin('contacts', 'users.id','=','contacts.user_id')

            ->leftJoin('role_user', 'users.id','=','role_user.user_id')
            ->leftJoin('roles', 'roles.id','=','role_user.role_id')
            ->leftJoin('permission_user', 'permission_user.user_id','=','users.id')                              ->leftJoin('permissions', 'permissions.id','=','permission_user.permission_id')
             ->where('roles.name','sub-admin')
             ->groupBy('users.id');

        if(request()->query('searchValue')){
            $value=request()->input('searchValue');
            $query->where(function ($query) use ($value){
                $query->whereRaw("concat(first_name, ' ', last_name) like '%$value%' ");
                $query->orWhere('permissions.name','like','%'.$value.'%');
                $query->orWhere('roles.name','like','%'.$value.'%');
            });
        }
         return $query->paginate();


//        return $this->getListForUIJoin($query,'manufacturers.id');
    }

    public function create()
    {
        return response()->json([
            'users'=>DB::table('users')
                ->leftjoin('role_user','role_user.user_id','=','users.id')
                ->leftjoin('roles','roles.id','=','role_user.role_id')
                ->leftjoin('contacts','users.id','=','contacts.user_id')
                ->select('users.id','contacts.first_name','contacts.last_name','role_user.role_id')
                ->where('roles.name','sub-admin')
                ->get(),
            'permissions'=>\Spatie\Permission\Models\Permission::all()
        ]);
    }


    public function store(Request $request)
    {
        $permissionCheck = DB::table('permission_user')->where('role_id',$request->user['role_id'])->get();
        if($permissionCheck->count()<1){
            foreach($request->permission as $permission){
                DB::table('role_has_permissions')->insert([
                    'permission_id'=>$permission['id'],
                    'role_id'=>$request->user['role_id']
                ]);
            }
            return response()->json([
                'type'=>'success',
                'message'=>'Permission assigned successfully'
            ]);
        }else{
            return response()->json([
            'type'=>'danger',
            'message'=>'User has already permission please Edit It.'
        ]);
        }


    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $permission=DB::table('users')
            ->leftJoin('role_user','users.id','=','role_user.user_id')
            ->leftJoin('permission_user','users.id','=','permission_user.user_id')
            ->leftJoin('permissions','permission_user.permission_id','=','permissions.id')
            ->select('permissions.name','permissions.id')
            ->where('users.id',$id)
            ->get();

        return response()->json([
            'users'=>DB::table('users')
                ->leftjoin('contacts','users.id','=','contacts.user_id')
                ->leftjoin('role_user','users.id','=','role_user.user_id')
                ->select('users.id','role_user.role_id','contacts.first_name','contacts.last_name')
                ->where('users.id',$id)
                ->first(),

            'permissions'=>\Spatie\Permission\Models\Permission::all(),
            'permission'=>$permission,
        ]);
    }


    public function update(Request $request, $id)
    {
       DB::table('permission_user')->where('user_id',$id) ->delete();
        foreach($request->permission as $permission){
            DB::table('permission_user')->insert([
                'permission_id'=>$permission['id'],
                'user_id'=>$id
            ]);
        }
        return response()->json([
            'type'=>'success',
            'message'=>'Permission assigned successfully'
        ]);

    }


    public function destroy($id)
    {
        //
    }
}
