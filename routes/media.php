<?php
/**
 * This file is a part of MicroDreamIT
 * (c) Shahanur Sharif <shahanur.sharif@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * or visit https://microdreamit.com
 * Created by Shahanur Sharif.
 * User: sharif
 * Date: 9/15/2018
 * Time: 11:36 AM
 */

Route::get('all-images', function(){
   return (new \App\Http\Media\GlobalMediaController())->getImages();
});

Route::post('upload', function(){
   return (new \App\Http\Media\GlobalMediaController())->store();
});

Route::post('delete', function(){
    return (new \App\Http\Media\GlobalMediaController())->delete();
});

Route::post('user/delete', function(){
    return (new \App\Http\Media\GlobalMediaController())->userDelete();
});

Route::get('user/all-images', function (){
    return (new \App\Http\Media\GlobalMediaController())->userImages();
});

Route::post('user/upload', function (){
    return (new \App\Http\Media\GlobalMediaController())->userStore();
});