<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModelCreateRequest;
use App\Modeled;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModeledController extends Controller
{

    public $tableName = 'models';

    public function index()
    {
       $query = $this->joinData('models', 'types', 'type_id');

        if (request()->input('type')){
            $query->where('models.type', request()->query('type'));
        }


        if(request()->query('searchValue')){

            $this->inputSearch($query,'models.type');
        }
        if(request()->query('type_id')){
            $query->where('models.type_id', request()->query('type_id'));
        }
        if(request()->query('is_active')){
            $query->where('types.is_active', request()->query('is_active'));
        }

        return $this->getListForUIJoin($query);
    }


    public function create()
    {
        //
    }


    public function store(ModelCreateRequest $request)
    {
        $request->createPersist();
        return response()->json([
            'type'=>'success',
            'message'=>'Model has been created successfully'
        ]);
    }


    public function show($id)
    {
        return Modeled::with('type', 'medias')->whereType(request()->input('type'))->whereId($id)->first();
    }


    public function edit($id)
    {
        return response()->json([
            'types' => Type::whereType(request()->input('type'))->whereIsActive(1)->get(),
            'model' => Modeled::with('type','medias')->whereType(request()->input('type'))->whereId($id)->first()
        ]);
    }


    public function update(ModelCreateRequest $request, $id)
    {
        $model=$request->updatePersist($id);
        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Model has been updated successfully'
            ],
            'redirection'=>'/admin/'.$model->type.'/model/'.$model->id
        ]);
    }

    public function destroy($id)
    {
        $model=Modeled::find($id);
        $type=$model->type;
        $model->delete();
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Model has been deleted successfully'
            ],
            'redirection'=>'/admin/'.$type.'/model'
        ]);
    }

    public function lists(){
        $model = Modeled::whereType(request()->query()['type']);

            foreach (request()->except(['resultPerPage','page']) as $key => $value) {
                $model->where($key, $value);
            }
        return response()->json(
            $model->paginate(request()->query()['resultPerPage'])
        );


    }




}
