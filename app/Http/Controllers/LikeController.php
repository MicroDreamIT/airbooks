<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth')->only('store');
	}
	
	public function index()
	{
	
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
		$likeCheck = auth()->user()->likes()
			->where('likable_type', $request->input('path'))
			->where('likable_id', $request->input('id'));

		if($likeCheck->exists()){
            $id = $likeCheck->first()->likable_id;
		    $likeCheck->delete();
            if($request->input('path')=='App\Contact'){
                return response()->json([
                    'unlike'=>$id,
                    'type'=>'success',
                    'message'=>'Connection removed successfully',

                ]);
            }else{
                return response()->json([
                    'unlike'=>$id,
                    'type'=>'success',
                    'message'=>'Thanks for your remove like',

                ]);
            }

        }

		if(!$likeCheck->exists()){
			$liked= auth()->user()->likes()->create([
				'likable_type'=>$request->input('path'),
				'likable_id'=>$request->input('id'),
			]);

			if($request->input('path')=='App\Contact'){
                return response()->json([
                    'liked'=>$liked,
                    'type'=>'success',
                    'message'=>'Connection made successfully',

                ]);
            }else{
                return response()->json([
                    'liked'=>$liked,
                    'type'=>'success',
                    'message'=>'Thanks for your like',

                ]);
            }

		}else{
			return response()->json([
				'type'=>'danger',
				'message'=>'You have already liked it.'
			
			]);
		}
		
	}
	
	
	public function show(Like $like)
	{
		//
	}
	
	
	public function edit(Like $like)
	{
		//
	}
	
	
	public function update(Request $request, Like $like)
	{
		//
	}
	
	
	public function destroy(Like $like)
	{
		//
	}
}
