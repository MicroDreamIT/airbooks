
<?php

Route::patch('ajax/{field}/{model}/{id}/edit', function ($field,$model, $id){
    return (new \App\Http\GlobalMethods())->changeBoolean($field, $model, $id);
});

Route::patch('ajax/{field}/{model}/{id}/edit/by-admin', function ($field,$model, $id){
    return (new \App\Http\GlobalMethods())->changeBooleanWithAsset($field, $model, $id);
});


Route::get('manufacturer/create/{type}','ManufacturerController@getCategoryAndCountry')->middleware('webJson');
Route::get('type/create/{type}','ManufacturerController@getManufacturer')->middleware('webJson');
Route::get('model/create/{type}','TypeController@getType')->middleware('webJson');

//resource controller

Route::get('export/{modelName}/{typeName?}', function ($modelName,$typeName=null){
    return (new \App\Http\GlobalMethods())->exportData($modelName,$typeName);
})->middleware('role');

Route::get('with-pivot/export/{modelName}/{typeName?}', function ($modelName,$typeName=null){
    return (new \App\Http\GlobalMethods())->exportDataWithPivot($modelName,$typeName);
})->middleware('role');

Route::post('import/data/{modelName}', function ($modelName){
    $globalMethod=new \App\Http\GlobalMethods();
    return $globalMethod->importData($modelName);

})->middleware('role');

Route::group(['middleware' => ['auth','role','webJson']], function () {
    Route::get('/dashboard', function () {
        return view('admin.admin-dashboard');
    });

    Route::patch('{model}/single-update/{id}/{columnName}/edit', 'Controller@columnUpdate')->middleware('webJson');
    Route::resource('category', 'CategoryController')->except('index');
    Route::resource('manufacturer', 'ManufacturerController');
    Route::resource('type', 'TypeController')->except('index');
    Route::resource('model', 'ModeledController')->except('index');
    Route::resource('contacts', 'ContactController')->except('index');
    Route::resource('company/speciality', 'SpecialityController')->except('index');
    Route::resource('company/title', 'TitleController')->except('index');
    Route::resource('company', 'CompanyController')->except('index');
    Route::resource('news', 'NewsController')->except('index');
    Route::resource('event', 'EventController')->except('index');
    Route::resource('airport/airfield', 'AirfieldController')->except('index');
    Route::resource('airport', 'AirportController')->except('index');
    Route::resource('canned-email', 'CannedemailController')->except('index');
    Route::resource('location/state', 'StateController')->except('index');
    Route::resource('location/city', 'CityController')->except('index');
    Route::resource('location/country', 'CountryController')->except('index');
    Route::resource('setting/subscriber', 'SubscriberController')->except('index');
    Route::resource('setting/seo', 'SeoController');
    Route::resource('location/continent', 'ContinentController')->except('index');
    Route::resource('location/region', 'RegionController')->except('index');
    Route::resource('cms', 'CmsController')->except('index');
    Route::resource('parts/condition', 'ConditionController')->except('index');
    Route::resource('parts/release', 'ReleaseController')->except('index');
    Route::resource('commercial/plan', 'PlanController')->except('index');
    Route::resource('commercial/plan', 'PlanController')->except('index');
    Route::resource('configuration', 'ConfigurationController')->except('index');
    Route::resource('role-permission', 'PermissionController')->except('index');
    Route::resource('lead', 'LeadController')->except('index');
    Route::get('ajax/accesslogs', 'AccesslogController@index');
    Route::post('/account-setting', 'ContactController@accountSetting');
    Route::get('/airbooker', 'UserController@userList');
    Route::get('/get-dashboard-data', 'AdminDashboardController@index');
    Route::post('/update-password', 'UserController@updatePassword');
    Route::resource('/admin-user', 'UserController');
    Route::get('/user',function (){
        return response()->json(\App\User::with('contact.company','contact.country','contact.city','contact.state',
            'contact.jobTitle','contact.department','contact.medias')
            ->whereId(auth()->id())->whereIsActive(1)->where('email_verified','')->first());
    });

    Route::patch('ajax/{field}/{model}/{id}/edit/by-admin', function ($field,$model, $id){
        return (new \App\Http\GlobalMethods())->changeBooleanWithAsset($field, $model, $id);
    });

    Route::get('getUserWithPermission', function(){
        return (new \App\User())->getAllPermissionData();
        });


    Route::get('/{all}', function () {
        return view('admin.admin-dashboard');
    })->where(['all'=>'.*']);

});


//All


