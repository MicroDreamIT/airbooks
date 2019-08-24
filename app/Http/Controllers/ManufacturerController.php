<?php

namespace App\Http\Controllers;

use App\Category;
use App\Country;
use App\Http\Requests\ManufacturerCreateRequest;
use App\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManufacturerController extends Controller
{

    public $tableName = 'manufacturers';

    public function index()
    {
        $query=DB::table('manufacturers')
            ->select('manufacturers.name', 'manufacturers.id', 'manufacturers.type', 'manufacturers.is_active')
            ->selectRaw("GROUP_CONCAT(ab_categories.name SEPARATOR ', ') as category_name")
            ->leftJoin('category_manufacturer', 'manufacturers.id','=','category_manufacturer.manufacturer_id')
            ->leftJoin('categories', 'category_manufacturer.category_id','=','categories.id');
        if (request()->input('type')){
            $query->where('manufacturers.type', request()->query('type'));
        }


        if(request()->query('searchValue')){
            $this->inputSearch($query,'manufacturers.type');
        }
        if(request()->query('category_id')){
            $query->where('category_manufacturer.category_id', request()->query('category_id'));
        }
        if(request()->query('is_active')){
            $query->where('manufacturers.is_active', request()->query('is_active'));
        }

        return $this->getListForUIJoin($query,'manufacturers.id');
    }



    public function create()
    {

    }

    public function store(ManufacturerCreateRequest $request)
    {

        $request->createPersist();
        return response()->json([
            'type'=>'success',
            'message'=>'Manufacturer has been created successfully'
        ]);

    }
    public function show($id)
    {
        return Manufacturer::with('categories', 'country', 'medias')
            ->whereType(request()->input('type'))->whereId($id)->first();
    }

    public function edit($id)
    {
         $manufacturer= Manufacturer::with(['categories', 'country', 'medias'])->whereId($id)->whereType(request()->input('type'))->first();
         $typeBasedCategory= Category::whereType($manufacturer->type)->whereIsActive(1)->get();
         $countries= Country::whereIsActive(1)->get();

         return response()->json([
             'categories'=>$typeBasedCategory,
             'countries'=>$countries,
             'manufacturer'=> $manufacturer]);
    }

    public function update(ManufacturerCreateRequest $request, $id)
    {
        $manufacturer = $request->updatePersist($id);
        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Manufacturer has been updated successfully'
            ],
            'redirection'=>'/admin/'.$manufacturer->type.'/manufacturer/'.$manufacturer->id
        ]);
    }

    public function destroy($id)
    {
        $manufacturer=Manufacturer::with('categories')->whereId($id)->first();
        $categoryIds=[];
        foreach ($manufacturer->categories as $category){
            $categoryIds[]=$category->id;
        }
        $manufacturer->categories()->detach($categoryIds);
        $type=$manufacturer->type;
        $manufacturer->delete();
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Manufacturer has been deleted successfully'
            ],
            'redirection'=>'/admin/'.$type.'/manufacturer'
        ]);
    }

    public function lists()
    {
        $manufacturer = Manufacturer::with('categories', 'country')->whereType(request()->query()['type']);

            foreach (request()->except(['resultPerPage','page']) as $key => $value) {
                $manufacturer->where($key, $value);
            }

        return response()->json(
            $manufacturer->paginate(request()->query()['resultPerPage'])
        );


    }

    public function getCategoryAndCountry($type){
        return response()->json([
            'countries'=>Country::whereIsActive(1)->get(),
            'categories'=>Category::whereIsActive(1)->whereType($type)->get(),
        ]);
    }

    public function getManufacturer($type){
        return response()->json([
            'manufacturers'=>Manufacturer::whereType($type)->whereIsActive(1)->get(),

        ]);
    }



}
