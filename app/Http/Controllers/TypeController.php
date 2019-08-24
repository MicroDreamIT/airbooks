<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeCreateRequest;
use App\Manufacturer;
use App\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public $tableName='types';

    public function index()
    {
        $query = $this->joinData('types', 'manufacturers', 'manufacturer_id');

        if (request()->input('type')){
            $query->where('types.type', request()->query('type'));
        }
        if(request()->query('searchValue')){

            $this->inputSearch($query,'types.type');
        }
        if(request()->query('manufacturer_id')){
            $query->where('types.manufacturer_id', request()->query('manufacturer_id'));
        }
        if(request()->query('is_active')){
            $query->where('types.is_active', request()->query('is_active'));
        }
        return $this->getListForUIJoin($query);
    }


    public function create()
    {

    }


    public function store(TypeCreateRequest $request)
    {

        $request->createPersist();
        return response()->json([
            'type' => 'success',
            'message' => 'Type has been created successfully'
        ]);
    }

    public function show($id)
    {

        return Type::with('manufacturer', 'medias')->whereType(request()->input('type'))->whereId($id)->first();
    }

    public function edit($id)
    {
        return response()->json([
            'manufacturerList' => Manufacturer::whereType(request()->input('type'))->get(),
            'typeList' => Type::with('manufacturer','medias')->whereType(request()->input('type'))->whereId($id)->first()
        ]);
    }

    public function update(TypeCreateRequest $request, $id)
    {
        $type=$request->updatePersist($id);
        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Type has been updated successfully'
            ],
            'redirection'=>'/admin/'.$type->type.'/type/'.$type->id
        ]);
    }

    public function destroy($id)
    {
        $typeData=Type::find($id);
        $type=$typeData->type;
        $typeData->delete();
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Type has been deleted successfully'
            ],
            'redirection'=>'/admin/'.$type.'/type'
        ]);
    }

    public function getType($type)
    {
        return response()->json([
            'typeList' => Type::whereType($type)->whereIsActive(1)->get()

        ]);

    }

    public function lists()
    {
        $type = Type::whereType(request()->query()['type']);

            foreach (request()->except(['resultPerPage', 'page']) as $key => $value) {
                $type->where($key, $value);
            }

        return response()->json(
            $type->orderBy('created_at')->paginate(request()->query()['resultPerPage'])
        );


    }

}
