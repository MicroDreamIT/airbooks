<?php

namespace App\Http\Controllers;

use App\Alternatepart;
use App\Company;
use App\Condition;
use App\Contact;
use App\Country;
use App\Http\Requests\PartRequest;
use App\Http\Requests\PartUpdateRequest;
use App\Http\Traits\searchTrait;
use App\Part;
use App\Release;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartController extends Controller
{
    use searchTrait;

    public function index()
    {

        $query = Part::with('contact.company.country', 'condition', 'release', 'currentLocation', 'user')->select();

        if (request()->has('fromSection') && request()->input('fromSection') == 'user') {
            $query->where('user_id', auth()->id());
        }
        if (request()->input('is_active')) {
            $query->where('is_active', request()->input('is_active'));
        }
        if (request()->has('numbers')) {

            $query->where(function ($query){
                foreach (json_decode(request()->input('numbers')) as $key => $value) {
                    if ($key == 0) {
                        $query->where('part_number', 'like',$value.'%')
                            ->orWhere('alternate_part_number', 'like',$value.'%');
                    } else {
                        $query->orWhere('alternate_part_number', 'like',$value.'%')
                            ->orWhere('part_number', $value);
                    }
                }
            });
        }

        return $this->getListForUI($query, request());
    }


    public function create()
    {
        return response()->json([
            'companies' => Company::whereIsActive(1)->orderBy('name')->select('id', 'name')->get(),
            'user' => Contact::where('user_id', auth()->user()->id)->first(),
            'countries' => Country::whereIsActive(1)->orderBy('name')->select('id', 'name')->get(),
            'conditions' => Condition::whereIsActive(1)->orderBy('name')->select('id', 'name')->get(),
            'releases' => Release::whereIsActive(1)->orderBy('name')->select('id', 'name')->get(),
        ]);
    }


    public function store(PartRequest $request)
    {
        $request->createPersist();
        return response()->json([
            'type' => 'success',
            'message' => 'Parts has been created successfully'
        ]);
    }

    public function show($id)
    {
        $parts = Part::with([
            'contact:id,first_name,last_name',
            'currentLocation:id,name',
            'condition:id,name',
            'release:id,name',
            'owner:id,name',
            'seller:id,name',
            'currentLocation:id,name',
        ])->whereId($id)->first();

        $parts->update([
            'views' => $parts->views + 1
        ]);

        return $parts;
    }


    public function edit($id)
    {
        $part=Part::find($id);
        if(Auth::user()->hasRoleType()=='admin' || $part->user_id==auth()->id()) {
            return response()->json([
                'companies' => Company::whereIsActive(1)->orderBy('name')->select('id', 'name')->get(),
                'countries' => Country::whereIsActive(1)->orderBy('name')->select('id', 'name')->get(),
                'conditions' => Condition::whereIsActive(1)->orderBy('name')->select('id', 'name')->get(),
                'releases' => Release::whereIsActive(1)->orderBy('name')->select('id', 'name')->get(),
                'part' => Part::with([
                    'contact:id,first_name,last_name',
                    'currentLocation:id,name',
                    'condition:id,name',
                    'release:id,name',
                    'owner:id,name',
                    'seller:id,name',


                ])->whereId($id)->first()

            ]);
        }
    }


    public function update(PartUpdateRequest $request, $id)
    {
        $request->updatePersist($id);

        return response()->json([
            'message' => [
                'type' => 'success',
                'message' => 'Part has been Updated successfully'
            ],
            'redirection' => '/user/parts'
        ]);
    }

    public function destroy($id)
    {
        $part = Part::find($id);
        $part->delete();
        return response()->json([
            'message' => [
                'type' => 'danger',
                'message' => 'Part has been deleted successfully'
            ],
            'redirection' => 'user/parts'
        ]);
    }

    public function getSearchData()
    {
        $query = Part::with('contact.company', 'condition', 'release', 'currentLocation', 'user')->select();

        if (request()->input('is_active_by_user')) {
            $query->where('is_active', request()->input('is_active_by_user'));
        }

        if (request()->input('condition')) {
            $this->filterCondition($query);
        }

        if (request()->input('country')) {
            $this->filterLocationUsingCountry($query);
        }

        if (request()->input('partsSearchTitle')) {
            $query->where(function ($query){
                foreach (request()->input('partsSearchTitle') as $key => $value) {
                    if ($key == 0) {
                        $query->where('part_number', 'like',$value.'%')
                            ->orWhere('alternate_part_number', 'like',$value.'%');
                    } else {
                        $query->orWhere('alternate_part_number', 'like',$value.'%')
                            ->orWhere('part_number', $value);
                    }
                }
            });
        }


        $query = $this->getDataBySearchQuery($query);
        return $query->paginate(20);
    }
}
