<?php

namespace App\Http\Controllers;

use App\Favourite;
use App\Http\Traits\SortTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class FavouriteController extends Controller
{

    use SortTrait;
    public function index(Request $request)
    {
        $userId=auth()->user()->id;
        $query = Favourite::with('favouritable')->whereUserId($userId)->where('favouritable_type','!=','App\\Event');


        if ($request->input('paging')) {
            if(!request()->query('searchValue')){
                $data = $query->orderBy('id','DESC')->paginate($request->input('resultPerPage'));
            }else{
                $data = $query->orderBy('id','DESC')->get();
            }

        } else {
            $data = $query->orderBy('id','DESC')->get();
        }

        if(request()->query('sortName')=='title') {
            $data=$this->getSortDataFavouritable($data);

        }

        if(request()->query('searchValue')){

           $data=$this->getSearchBasedDataFavourite($data);


        }

        return response()->json($data);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        if(auth()->guest()){
            return response()->json([
                'type'=>'danger',
                'message'=>'Please Login first then try again',

            ]);
        }
        $favouriteCheck = auth()->user()->favourites()
            ->where('favouritable_type', $request->input('path'))
            ->where('favouritable_id', $request->input('id'));

        if(!$favouriteCheck->exists()){
            $favourite = auth()->user()->favourites()->create([
                'favouritable_type'=>$request->input('path'),
                'favouritable_id'=>$request->input('id'),

            ]);

            if($request->input('path')!='App\\Event'){
                $message='Added to your favorite list';
            }else{
                $message='Added to your Interested list';
            }
            return response()->json([
                'favourite'=> $favourite,
               'type'=>'success',
               'message'=>$message,

            ]);
        }else{
            if($request->input('path')=='App\\Event'){
                $unfavouriteId = $favouriteCheck->first();
                $favouriteCheck->delete();

                return response()->json([
                    'unfavourite'=> $unfavouriteId->favouritable_id,
                    'type'=>'danger',
                    'message'=>'Done',

                ]);
            }else{
                if($request->input('path')!='App\\Event'){
                    $message="Oops! it's already in your favorite list";
                }else{
                    $message="Oops! it's already in your interested list";
                }
                return response()->json([
                    'type'=>'danger',
                    'message'=>$message,

                ]);
            }



        }
    }


    public function show(Favourite $favourite)
    {
        //
    }


    public function edit(Favourite $favourite)
    {
        //
    }


    public function update(Request $request, Favourite $favourite)
    {
        //
    }

    public function destroy(Request $request,$id)
    {
        $favourite=Favourite::whereFavouritableId($request->id)->whereFavouritableType('App\\'.ucfirst($request->modelType))->first();
        $favourite->delete();
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Favourite has been deleted successfully'
            ],
        ]);
    }


}
