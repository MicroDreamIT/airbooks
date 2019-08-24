<?php

namespace App\Http\Controllers;

use App\Cannedemail;
use App\Http\Requests\CannedemailRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CannedemailController extends Controller
{
    public $basePath = 'resources/views/emails/canned/';
    public $header = '@component(\'mail::message\')';
    public $footer = 'Thank you,<br> The Airbook Team <br>XBS | Aviation City - Dubai World Central<br>Dubai South, United Arab Emirates <br>https://airbook.aero | support@airbook.aero @endcomponent';

    public function index()
    {
        $query = Cannedemail::select();
        return $this->getListForUI($query, request());
    }


    public function create()
    {
        //
    }


    public function store(CannedemailRequest $request)
    {
        $message = $this->header . str_replace('=&gt;', '=>', str_replace('&#39;', '\'', $request->input('message'))) . $this->footer;

        $location = $this->basePath.str_replace(' ', '-', $request->input('message_type')).'.blade.php';

        fwrite(fopen(base_path($location), 'wb'), $message);

        $request->merge(['location'=>$location]);

        $request->createPersist();

        return response()->json([
            'type'=>'success',
            'message'=>'Canned Email has been created successfully'
        ]);
    }


    public function show($id)
    {

        return Cannedemail::whereId($id)->first();
    }


    public function edit($id)
    {
        return Cannedemail::whereId($id)->first();
    }

    public function update(CannedemailRequest $request, $id)
    {

        $model =Cannedemail::find($id);

        $message = $this->header . str_replace('=&gt;', '=>', str_replace('&#39;', '\'', $request->input('message'))) . $this->footer;

        fwrite(fopen(base_path($model->location), 'wb'), $message);

        $request->updatePersist($model);

        return response()->json([
            'message'=>[
                'type'=>'success',
                'message'=>'Canned Email has been Updated successfully'
            ],
            'redirection'=>'/admin/canned-email'
        ]);
    }


    public function destroy($id)
    {

        $model = Cannedemail::find($id);

        unlink(base_path($model->location));

        $model->delete();


        return response()->json([
            'message'=>[
                'type'=>'danger',
                'message'=>'Canned Email has been deleted successfully'
            ],
            'redirection'=>'/admin/canned-email'
        ]);
    }

    public function lists(){
        $cannedEmail = Cannedemail::select();
        foreach(request()->except(['resultPerPage', 'page']) as $key=>$value){
            $cannedEmail->where($key,  $value);
        }
        return response()->json(
            $cannedEmail->paginate(request()->query()['resultPerPage'])
        );
    }
}
