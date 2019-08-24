<?php

namespace App\Http\Controllers;

use App\Category;
use App\Exports\CategoryExport;
use App\Exports\Export;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class CategoryController extends Controller
{

    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $query=Category::select();
        if (request()->input('type')){
            $query->whereType($request->type);
        }

        return $this->getListForUI($query, $request);
    }


    public function create()
    {

    }


    public function store(CategoryRequest $request)
    {
        $request->createPersist();
        return response()->json([
            'type'=>'success',
            'message'=>'Category has been created successfully'
        ]);
    }


    public function show($id)
    {
        return Category::with('medias')->whereType(request()->query('type'))->whereId($id)->first();
    }


    public function edit($id)
    {
//        return $id;
//       return Category::find($id);
    }


    public function update(CategoryRequest $request, $id)
    {
        $category = $request->updatePersist($id);

        return response()->json([
            'message'=>[
            'type'=>'success',
            'message'=>'Category has been Updated successfully'
        ],
            'redirection'=>'/admin/'.$category->type.'/category/'.$category->id
        ]);
    }


    public function destroy($id)
    {
        $category=Category::find($id);
        $type=$category->type;
        $category->delete();
        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Category has been deleted successfully'
            ],
            'redirection'=>'/admin/'.$type.'/category'
        ]);
    }

    public function lists()
    {

        $category = Category::whereType(request()->query()['type']);

            foreach(request()->except(['resultPerPage', 'page']) as $key=>$value){
                $category->where($key,  $value);
            }

        return response()->json(

            $category->paginate(request()->query()['resultPerPage'])
        );


    }


}
