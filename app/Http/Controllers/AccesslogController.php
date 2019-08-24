<?php

namespace App\Http\Controllers;

use App\Accesslog;
use Illuminate\Http\Request;

class AccesslogController extends Controller
{

    public function index(Request $request)
    {
//        $query=Accesslog::with('user')->select();
        $query=Accesslog::join('users','users.id','accesslogs.id')
            ->join('contacts','contacts.id','accesslogs.user_id')
            ->select('users.id','contacts.first_name','contacts.last_name','accesslogs.payload','accesslogs.created_at');

//        if (request()->input('type')){
//            $query->whereType($request->type);
//        }
        if(request()->query('searchValue')){
            $value=request()->input('searchValue');
            $query->where(function ($query) use ($value){
                $query->whereRaw("concat(first_name, ' ', last_name) like '%$value%' ");
            });

        }
        return $this->getListForUI($query, $request);
    }

    public function store($request, $user)
    {

        $user->accesslogs()->create(['payload'=>$request->server()]);
    }
}
