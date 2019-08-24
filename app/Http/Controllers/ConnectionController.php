<?php

namespace App\Http\Controllers;

use App\Connection;
use App\Http\Traits\SortTrait;
use App\Like;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{

    use SortTrait;
    public function index(Request $request)
    {

        $query = Like::with('contact')->whereUserId(auth()->user()->id)->whereLikableType('App\\Contact');
//
        if(request()->query('searchValue')){
            $value=request()->query('searchValue');
            $query->whereHas('contact',function ($query) use ($value){
                $query->whereRaw("concat(first_name, ' ', last_name) like '%$value%' ");
            });
        }

        if ($request->input('paging')) {

            if(request()->query('sortName')=='first_name'){
                $data = $query->orderBy('id','DESC')->get();

            }else{
                $data = $query->orderBy('id','DESC')->paginate($request->input('resultPerPage'));
            }

        } else {
            $data = $query->orderBy('id','DESC')->get();
        }

        if(request()->query('sortName')=='first_name') {
            $data=$this->getSortDataConnection($data);

        }

        return response()->json($data);
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show(Connection $connection)
    {
        //
    }


    public function edit(Connection $connection)
    {
        //
    }


    public function update(Request $request, Connection $connection)
    {
        //
    }

    public function destroy(Request $request,$id)
    {
        $connection=Like::whereLikableId($request->id)->whereLikableType('App\\'.ucfirst($request->modelType))->first();
        $connection->delete();
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Connection has been deleted successfully'
            ],
        ]);
    }
}
