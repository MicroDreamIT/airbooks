<?php
/**
 * This file is a part of MicroDreamIT
 * (c) Shahanur Sharif <shahanur.sharif@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * or visit https://microdreamit.com
 * Created by Shahanur Sharif.
 * User: sharif
 * Date: 9/13/2018
 * Time: 3:59 PM
 */

namespace App\Http\Media;



use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GlobalMediaController
{

    public function index()
    {

    }

    public function store()
    {
        $file = request()->file('file');

        $type = $file->getClientMimeType();

        $filename = $file->getClientOriginalName();

        if(request()->input('suffix')){
            $filename = request()->input('suffix').'-'.$filename;
        }

        $filename = $this->filenameDuplicateCheck($filename);

        $media = Media::create([
           'accessibility'=>true,
           'mediable_type'=>'Global',
           'mediable_id' => 1,
           'original_file_name'=> $filename,
           'type'=>$type,
           'path'=>'global',
            'meta_name'=>request()->input('suffix')
        ]);

        Storage::disk('public')->putFileAs(
            'global/',
            $file,
            $filename
        );

        return $media;

    }

    public function getImages()
    {
        $media = Media::where('mediable_type', 'Global')->select();

        if(request()->input('filtering') && !request()->input('ordering')){
            $media->orderBy(request()->input('filtering'));
        }

        if(request()->input('ordering') && request()->input('filtering')){
            $media->orderBy(request()->input('filtering'),request()->input('ordering'));
        }

        if(request()->input('search')){
            $media->where('original_file_name', 'LIKE', '%'.request()->input('search').'%');
        }

        return $media->get();
    }

    public function delete()
    {
        $files = request()->all();



        foreach ($files as $file){

            $this->deleteFile($file['path'].'/'.$file['original_file_name']);
            $this->deleteFromDatabase($file['id']);
        }

    }

    private function deleteFile($path)
    {
        Storage::disk('public')->delete($path);
    }

    private function deleteFromDatabase($id)
    {
        Media::whereId($id)->delete();
    }

    public function userStore()
    {
//        auth()->loginUsingId(4, true);
        $file = request()->file('file');

        $type = $file->getClientMimeType();

        $filename = $file->getClientOriginalName();

        $filename = $this->filenameDuplicateCheck($filename);

        $path = 'user/'.auth()->id();
//        return [$type, $filename];

        $media = auth()->user()->medias()->create([
            'accessibility'=>true,
            'original_file_name'=> $filename,
            'type'=>$type,
            'path'=>$path,
            'meta_name'=>substr($filename, 0, strpos($filename, '.'))
        ]);

        Storage::disk('public')->putFileAs(
            $path,
            $file,
            $filename
        );

        return $media;
    }

    public function userImages()
    {

        $medias = Media::where('mediable_type','App\User')->where('mediable_id', auth()->id())->select();

        if(request()->input('userFiltering') && !request()->input('userOrdering')){
            $medias->orderBy(request()->input('userFiltering'));
        }

        if(request()->input('userOrdering') && request()->input('userFiltering')){
            $medias->orderBy(request()->input('userFiltering'),request()->input('userOrdering'));
        }

        if(request()->input('userSearch')){

            $medias->where('original_file_name', 'LIKE', '%'.request()->input('userSearch').'%');
        }

        return $medias->get();

    }

    public function userDelete()
    {

        $files = request()->all();



        foreach ($files as $file){
            if($file['mediable_type'] != 'App\User' && $file['mediable_id'] != auth()->id()){
                abort(403);
            }
            $this->deleteFile($file['path'].'/'.$file['original_file_name']);
            $this->deleteFromDatabase($file['id']);
        }
    }

    private function filenameDuplicateCheck($filename)
    {
        $media = Media::where('original_file_name', $filename);
//        dd($media->exists());
        if($media->exists()){
            $suffix = $media->first()->id + 1;
            $filename = $suffix.'-'.$filename;
        }
        return $filename;
    }


}