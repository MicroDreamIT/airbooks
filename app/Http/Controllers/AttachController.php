<?php

namespace App\Http\Controllers;

use App\Attach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachController extends Controller
{

    /**
     * @param $model
     */
    public function uploadFile($model)
    {
        $previous_files = $model->attaches()->get()->toArray();

        $this->addNewFiles($previous_files, $model);

        $this->deletePreviousFiles($model);
    }

    /**
     * @param $model
     */
    public function createFile($model)
    {
        if (count((array)request()->input('attaches')) > 0) {
            foreach (request()->input('attaches') as $attach) {

                $model->attaches()->create([
                    'path' => $attach['response'],
                    'original_file_name' => $attach['name'],
                    'user_id' => auth()->id(),
                    'accessibility' => true
                ]);
            }
        }
    }


    public function addNewFiles($previous_files, $model)
    {
        if (count( (array)request()->input('attaches')) > 0) {
            foreach (request()->input('attaches') as $newFile) {
//                var_dump(in_array($newFile, $previous_files));
                if (!in_array($newFile, $previous_files)) {
                    $model->attaches()->create([
                        'path' => $newFile['response'],
                        'original_file_name' => $newFile['name'],
                        'user_id' => auth()->id(),
                        'accessibility' => true
                    ]);
                }
            }
        }
    }

    /**
     * @param $model
     */
    public function deletePreviousFiles($model)
    {
//        dd((array)request()->input('removeFileList'));
        if (count( (array)request()->input('removeFileList')) > 0) {
            foreach (request()->input('removeFileList') as $removeFile) {
                if (array_key_exists('contentId', $removeFile)) {
                    $model->attaches()->where('id', $removeFile['contentId'])->delete();
                }
            }
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        return Storage::disk('public')
            ->putFile(auth()->id().'/attachment/'.$request->input('model'),
                $request->file('file')
            );
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Attach  $attach
     * @return \Illuminate\Http\Response
     */
    public function show(Attach $attach)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attach  $attach
     * @return \Illuminate\Http\Response
     */
    public function edit(Attach $attach)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attach  $attach
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attach $attach)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attach  $attach
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attach $attach)
    {
        //
    }
}
