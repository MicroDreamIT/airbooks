<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store($model, $directory, $file, $is_featured = false, $is_active=true)
    {

        $filename = $file['upload']['filename'];

        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file['dataURL']));

        $path = $directory . '/' . $filename;

        Storage::disk('public')->put($path, $image);

        $model->medias()->create(
            [
                'path' => $directory,
                'original_file_name' => $filename,
                'is_active'=>$is_active,
                'is_featured'=>$is_featured
            ]);


        return true;

    }

    public function show(Media $media)
    {
        //
    }

    public function edit(Media $media)
    {
        //
    }

    public function update($model, $directory, $file, $is_featured = false, $is_active=true)
    {
        //
    }

    public function destroy($media)
    {
        Storage::disk('public')->delete($media->path.'/'.$media->original_file_name);
    }
}
