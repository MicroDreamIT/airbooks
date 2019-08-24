<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriberRequest;
use App\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index()
    {
        $query = Subscriber::select();
        return $this->getListForUI($query, request());
    }


    public function create()
    {

    }


    public function store(SubscriberRequest $request)
    {
        $request->createPersist();
        return response()->json([
            'type'=>'success',
            'message'=>'Subscriber has been created successfully'
        ]);
    }


    public function show($id)
    {
        return Subscriber::whereId($id)->first();
    }


    public function edit($id)
    {
        return response()->json([
            'subscriber'=>Subscriber::whereId($id)->first()
        ]);

    }

    public function update(SubscriberRequest $request, $id)
    {
        $request->updatePersist($id);

        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Subscriber has been Updated successfully'
            ],
            'redirection'=>'/admin/setting/subscriber'
        ]);
    }


    public function destroy($id)
    {
        Subscriber::destroy($id);
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Subscriber has been deleted successfully'
            ],
            'redirection'=>'/admin/setting/subscriber'
        ]);
    }

    public function lists(){
        $subscriber = Subscriber::select();

        foreach(request()->except(['resultPerPage', 'page']) as $key=>$value){
            $subscriber->where($key,  $value);
        }

        return response()->json(
            $subscriber->paginate(request()->query()['resultPerPage'])
        );
    }
}
