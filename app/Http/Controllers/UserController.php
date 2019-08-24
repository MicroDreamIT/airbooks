<?php

namespace App\Http\Controllers;

use App\Company;
use App\Contact;
use App\Http\SendMail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public $tableName = 'users';

    public function index(){
        $query=DB::table('users')
            ->select('contacts.first_name', 'contacts.last_name','users.id','roles.name as role_name','users.is_active')
            ->selectRaw("GROUP_CONCAT(ab_permissions.name SEPARATOR ', ') as permission_name")
            ->leftJoin('contacts', 'users.id','=','contacts.user_id')

            ->leftJoin('role_user', 'users.id','=','role_user.user_id')
            ->leftJoin('roles', 'roles.id','=','role_user.role_id')
            ->leftJoin('permission_user', 'permission_user.user_id','=','users.id')                          ->leftJoin('permissions', 'permissions.id','=','permission_user.permission_id')
            ->where('roles.name','sub-admin');

        if(request()->query('searchValue')){
            $value=request()->input('searchValue');
            $query->where(function ($query) use ($value){
                $query->whereRaw("concat(first_name, ' ', last_name) like '%$value%' ");
                $query->orWhere('permissions.name','like','%'.$value.'%');
                $query->orWhere('roles.name','like','%'.$value.'%');
            });

        }
        return $this->getListForUIJoin($query,'users.id');
    }



    public function create(){
        $companies=Company::whereIsActive(1)->get();
        $permissions=DB::table('permissions')->get();

        return response()->json([
           'companies'=>$companies,
            'permissions'=>$permissions
        ]);
    }

    public function store(Request $request)
    {
            $this->validator(request()->all())->validate();
            $user=new User();
            $user->email = $request->email;
            $user->password = Hash::make($request['password']);
            $user->email_verified = '';
            $user->is_active = $request['is_active'];
            $user->save();

            $contact=new Contact();
            $contact->fill([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
            ]);
            $contact->creator()->associate(auth()->id());
            $contact->user()->associate($user->id);
            $contact->company()->associate($request->company['id']);
            $contact->save();

            DB::table('role_user')->insert(['user_id'=>$user->id,'role_id'=>3]);
            foreach($request->permission as $permission){
                DB::table('permission_user')->insert([
                    'user_id'=>$user->id,
                    'permission_id'=>$permission['id']
                ]);
            }

//            (new SendMail())->sendVerifyEmail($user, $contact);

            return response()->json([
                'type'=>'success',
                'message'=>'Admin user has been created successfully'
            ]);
    }

    public function edit($id){
        $companies=Company::whereIsActive(1)->get();
        $permissions=DB::table('permissions')->get();
        $adminUser=User::with('contact.company')->whereId($id)->first();
        $adminUserPermsions=DB::table('permission_user')
            ->join('permissions','permissions.id','=','permission_user.permission_id')
            ->select('permissions.name','permissions.id')
            ->where('permission_user.user_id','=',$id)->get();

        return response()->json([
            'companies'=>$companies,
            'permissions'=>$permissions,
            'adminUser'=>$adminUser,
            'adminUserPermsions'=>$adminUserPermsions,
        ]);
    }

    public function update(Request $request,$id)
    {
        DB::transaction(function () use($request,$id){
            $this->validator(request()->all())->validate();
            $user=User::find($id);
            $user->email = $request->email;
            if($request['password']){
                $user->password = Hash::make($request['password']);
            }
            $user->is_active = $request['is_active'];
            $user->save();

            $contact=Contact::whereUserId($id)->first();
            $contact->update([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
            ]);
            $contact->company()->associate($request->company['id']);
            $contact->save();
            DB::table('permission_user')->whereUserId($id)->delete();

            foreach($request->permission as $permission){
                DB::table('permission_user')->insert([
                    'user_id'=>$user->id,
                    'permission_id'=>$permission['id']
                ]);
            }

            return response()->json([
                'type'=>'success',
                'message'=>'Admin user has been updated successfully'
            ]);
        });
    }

    public function destroy($id)
    {
        $user=User::find($id);
        Contact::whereUserId($id)->delete();
        Contact::whereCreatorId($id)->delete();
        DB::table('permission_user')->whereUserId($id)->delete();
        DB::table('role_user')->whereUserId($id)->delete();
        $user->delete();
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Admin User has been deleted successfully'
            ],
        ]);
    }


    private function validator($all)
    {
        return Validator::make($all, [
            'email' => 'required|string|email|unique_with:users,ignore:'.request()->route('admin_user'),
            'first_name' => 'required',
            'last_name' => 'required',
        ]);
    }
    public function updatePassword(Request $request){

        $user=User::find(Auth::id());
        if(Hash::check($request->current_password, $user->password)){
            $user->update(["password"=>Hash::make($request->new_password)]);
            return response()->json([
                'type'=>'success',
                'message'=>'Password updated successfully'
            ]);

        }else{
            return response()->json([
                'type'=>'danger',
                'message'=>'Current Password is not correct.'
            ]);
        }
    }


    public function userList()
    {
        $query=User::join('role_user','role_user.user_id','users.id')
            ->join('roles','roles.id','role_user.role_id')
            ->join('contacts','contacts.user_id','users.id')
            ->select('users.is_active','users.id','users.email','users.created_at')
            ->where('roles.name','=','user');

        if(request()->query('searchValue')){
            $value=request()->input('searchValue');
            $query->where(function ($query) use ($value){
                $query->whereRaw("concat(first_name, ' ', last_name) like '%$value%' ");
                $query->orWhere('users.email','like','%'.$value.'%');
            });

        }
        return $this->getListForUIJoin($query,'users.id');

    }

}
