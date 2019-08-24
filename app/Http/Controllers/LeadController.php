<?php

namespace App\Http\Controllers;

use App\Http\Traits\SortTrait;
use App\Lead;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{

    use SortTrait;
    public function index(Request $request)
    {
        $user=auth()->user();

        $query = Lead::with('leadable.user.contact.company','user.contact.company');

        if($request->input('user')){
            $query->whereUserId($user->id);
        }

        if ($request->input('paging')) {
            if(!request()->query('searchValue')){
                $data = $query->orderBy('id','DESC')->paginate($request->input('resultPerPage'));
            }else{
                $data = $query->orderBy('id','DESC')->get();
            }

        } else {
            $data = $query->orderBy('id','DESC')->get();
        }

        $sort=request()->query('sortName');

        if($sort=='title'||$sort=='contact'||$sort=='company'||$sort=='lead_status'||$sort=='created_at') {

            $data=$this->getSortDataLead($data);

        }

        if(request()->query('searchValue')){

            $data=$this->getSearchBasedDataLead($data);


        }


        return response()->json($data);
    }


    public function create()
    {
        //
    }

    public function store()
    {
        if(!array_key_exists('id', request()->input('modelData')) && count(request()->input('modelData'))>0 ){
            foreach (request()->input('modelData') as $item) {
                $lead=new Lead();
                $lead->leadable_id=$item['id'];
                $lead->leadable_type='App\\'.ucfirst($item['modelType']);
                $lead->user_id= $item['user']['id'];
                $lead->creator_id=auth()->user()->id;
                $lead->lead_status='Unread';
                $lead->message=request()->input('message');
                $lead->save();
            }
        }else{
            $lead=new Lead();
            $lead->leadable_id=request()->input('modelData')['id'];
            $lead->leadable_type='App\\'.ucfirst(request()->input('modelData')['modelType']);
            $lead->user_id= request()->input('modelData')['user']['id'];
            $lead->creator_id=auth()->user()->id;
            $lead->lead_status='Unread';
            $lead->message=request()->input('message');
            $lead->save();
        }

    }


    public function show(Request $request)
    {
        //
    }


    public function edit(Request $request,$id)
    {

    }


    public function update(Request $request,$id)
    {
        $lead=Lead::find($id);
        $lead->update(['lead_status' =>'Read']);
    }

    public function destroy(Request $request,$id)
    {
        Lead::destroy($id);
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Lead has been deleted successfully'
            ],
            'redirection'=>'/user/lead'
        ]);
    }
}


