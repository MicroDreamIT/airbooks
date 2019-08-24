<?php
/**
 * This file is a part of MicroDreamIT
 * (c) Shahanur Sharif <shahanur.sharif@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * or visit https://microdreamit.com
 * Created by Shahanur Sharif.
 * User: sharif
 * Date: 7/31/2018
 * Time: 6:16 AM
 */

namespace App\Http\Traits;


use App\Http\Controllers\MediaController;

trait DropZoneCreate
{
    private function removeFile($model, $media)
    {

        $this->mediaDestroy($media);
        $model->medias->delete();
    }

    /**
     * @param $media
     */
    private function mediaDestroy($media)
    {
        (new MediaController())->destroy($media);
    }
    /**
     * @param $model
     */
    private function createFile($model)
    {

        $getModelDirectoryPath = get_class($model);

        $getModelDirectoryToArray = explode('\\', $getModelDirectoryPath);

        $directory = end($getModelDirectoryToArray);

        if($this->input('file')){
            foreach($this->input('file') as $file){
                if(array_key_exists('dataURL', $file)){
                    (new MediaController())->store($model, $directory, $file);
                }
            }
        }

    }

    private function updateFile($model, $media)
    {
        foreach ($this->input('removeFiles') as $removeFile){
            $media = $media->whereId($removeFile['contentId'])->first();
            $this->mediaDestroy($media);
            $media->delete();
        }

        $this->createFile($model);

    }

    /**
     * @param $media
     * @param $model
     */
    protected function modelOnUpdate($media, $model)
    {

//        dd($media, $this->input('file'));

        if ($media && $this->input('file')==null ) {
            $this->removeFile($model, $media);
        }
//        update

        if($this->input('file')){
            if ($media && count($this->input('file'))) {
                foreach ($this->input('file') as $file) {

                    if (array_key_exists('dataURL', $file)) {
                        $this->updateFile($model, $media);
                    }
                }
            }
        }

        //create
        if (!$media && $this->input('file')) {
            $this->createFile($model);
        }
    }
}