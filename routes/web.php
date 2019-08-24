<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

*/

//Route::get('migrations', 'MigrationsController@index');

Route::post('send-verify-email', function(\Illuminate\Http\Request $request){

    if(auth()->check()){
        $user= \App\User::whereId(auth()->id())->first();
        (new \App\Http\SendMail())->sendVerifyEmail($user, $user->contact);
        return back();
    }
});


Route::get('email-verification', function (){

        $user = \App\User::where('id', request()->query('id'))
            ->where('email_verified', request()->query('token'))
            ->first();

        if($user){
            $user->update(['email_verified'=>'', 'is_active'=>true]);
            $contact=\App\Contact::whereUserId($user->id)->first();
            $contact->is_published = 1;
            $contact->save();
            auth()->loginUsingId($user->id, true);
//            $email, $name, $url, $template
            (new \App\Http\SendMail())->cannedEmail($user->email, $contact->first_name.' '.$contact->last_name,null,'user-activation');
            return redirect('/user/dashboard');
        }else{
            return redirect('/');
        }


});


Route::post('store-cookies', function(){
    Cookie::queue('cookieStore', true, 2628000);
    return back();
});

Route::get('ajax/promomix', function(){
    return (new \App\Http\GlobalMethods())->promomix();
});

Route::get('ajax/promomix-without-featured/{table}/{field}/{value}', function($table,$field,$value){
    return (new \App\Http\GlobalMethods())->promomixWithoutFeatured($table,$field,$value);
});

Route::get('countries', function(){
    return response()->json(\App\Country::select('id', 'name')->get());
});

Route::get('/sidebar-search/{modelName}', function($modelName){
    return (new \App\Http\SideBarSearch())->getSideBarList($modelName);
});
Route::get('/forntend/airport/edit/{airport}', 'AirportController@edit');
Route::patch('/forntend/airport/{airport}', 'AirportController@update');



Route::get('getStateNameByCountry', 'StateController@getStateNameByCountry');
Route::get('getCityNameByState', 'CityController@getCityNameByState');
Route::get('getRegionNameByContinent', 'RegionController@getRegionNameByContinent');
Route::get('getCountryNameByRegion', 'CountryController@getCountryNameByRegion');

Auth::routes(['email_verified'=>'', 'is_active'=>1]);
//ctf0\MediaManager\MediaRoutes::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('configurations', function(){
    return response()->json(
        \Illuminate\Support\Facades\DB::table('configurations')->get()
    );
});
Route::group(['middleware' =>'webJsonFront'], function () {
    Route::get('ajax/getChart', function (){
        return (new \App\Http\ChartData())->getChart();
    });
    Route::get('ajax/aircrafts', 'AircraftController@index');
    Route::get('ajax/engine', 'EngineController@index');
    Route::get('ajax/apu', 'ApuController@index');
    Route::get('ajax/part', 'PartController@index');
    Route::get('ajax/wanted', 'WantedController@index');
    Route::get('ajax/favourite', 'FavouriteController@index');
    Route::get('ajax/connection', 'ConnectionController@index');
    Route::get('ajax/lead', 'LeadController@index');
    Route::get('ajax/suggestion', 'SuggestionController@index');
    Route::get('ajax/aircraft/search','AircraftController@getSearchData');
    Route::get('ajax/engine/search','EngineController@getSearchData');
    Route::get('ajax/apu/search','ApuController@getSearchData');
    Route::get('ajax/wanted/search','WantedController@getSearchData');
    Route::get('ajax/news/search','NewsController@getSearchData');
    Route::get('ajax/event/search','EventController@getSearchData');
    Route::get('ajax/event/interested/{event_id}','EventController@getInterestedData');
    Route::get('ajax/airport/search','AirportController@getSearchData');
    Route::get('ajax/contact/search','ContactController@getSearchData');
    Route::get('ajax/company/search','CompanyController@getSearchData');
    Route::get('ajax/parts/search','PartController@getSearchData');
    Route::post('ajax/support-email', function(){
//        return request()->all();
        (new \App\Http\SendMail())->contactMail('from support mail');
    });

    Route::get('ajax/front/events', function(){
        \App\Event::paginate(10);
    });
    Route::get('ajax/front/news', function(){
        \App\News::paginate(10);
    });
});

Route::group(['middleware' => ['webJsonFront','frontAsset']], function () {

    Route::post('setting/subscriber', 'SubscriberController@store');

    Route::get('/ajax/news/{id}','NewsController@show');
    Route::get('/ajax/event/{id}','EventController@show');
    Route::get('/ajax/wanted/{id}','WantedController@show');
    Route::get('/ajax/apu/{id}','ApuController@show');
    Route::get('/ajax/engine/{id}','EngineController@show');
    Route::get('/ajax/aircraft/{id}','AircraftController@show');
    Route::get('/ajax/contact/{id}','ContactController@show');
    Route::get('/ajax/company/{id}','CompanyController@show');
    Route::get('/ajax/airport/{id}','AirportController@show');
    Route::get('/ajax/cms/{pageUrl}','CmsController@getCmsContentBySecton');

    Route::get('category', 'CategoryController@index');
    Route::get('manufacturer', 'ManufacturerController@index');
    Route::get('type', 'TypeController@index');
    Route::get('model', 'ModeledController@index');
    Route::get('company/speciality', 'SpecialityController@index');
    Route::get('company/title', 'TitleController@index');
    Route::get('contacts', 'ContactController@index');
    Route::get('company', 'CompanyController@index');
    Route::get('news', 'NewsController@index');
    Route::get('event', 'EventController@index');
    Route::get('airport/airfield', 'AirfieldController@index');
    Route::get('airport', 'AirportController@index');
    Route::get('canned-email', 'CannedemailController@index');
    Route::get('location/state', 'StateController@index');
    Route::get('location/city', 'CityController@index');
    Route::get('location/country', 'CountryController@index');
    Route::get('setting/subscriber', 'SubscriberController@index');
    Route::get('seolist', function(){
        return \App\Seo::with('medias')->get();
    });
    Route::get('location/continent', 'ContinentController@index');
    Route::get('location/region', 'RegionController@index');
    Route::get('cms', 'CmsController@index');
    Route::get('parts/condition', 'ConditionController@index');
    Route::get('parts/release', 'ReleaseController@index');
    Route::get('commercial/plan', 'PlanController@index');
    Route::get('configuration', 'ConfigurationController@index');
    Route::get('commercial/get-plan', 'PlanController@getPlan');
    Route::get('role-permission', 'PermissionController@index');

});


Route::get('/{all}', function () {
    return view('welcome');
})->where(['all'=>'.*']);


Route::get('departments', function(){
});
Route::get('titles', function(){
});

//function render($path) {
//    $renderer_source = Illuminate\Support\Facades\File::get(base_path('node_modules/vue-server-renderer/basic.js'));
//    $app_source = Illuminate\Support\Facades\File::get(public_path('js/entry-server.js'));
//    $v8 = new V8Js();
//    ob_start();
//    $js =
//        <<<EOT
//var process = { env: { VUE_ENV: "server", NODE_ENV: "production" } };
//this.global = { process: process };
//var url = "$path";
//EOT;
//    $v8->executeString($js);
//    $v8->executeString($renderer_source);
//    $v8->executeString($app_source);
//    return ob_get_clean();
//}



