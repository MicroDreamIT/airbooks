<?php



Route::get('/company/edit','CompanyController@edit');

Route::patch('/company/update/{id}', 'CompanyController@updateFromUser');

Route::resource('likes', 'LikeController');
Route::post('favourites', 'FavouriteController@store');
Route::post('front-email', function(){

    return (new \App\Http\GlobalMethods())->sendMailFromUser();
} );
Route::post('front-email-parts', function(){

    return (new \App\Http\GlobalMethods())->sendMailFromUserForParts();
} );

Route::get('user', function () {
    return response()->json(\App\User::with('subscriptions','contact')
        ->where('id',auth()->id())
        ->where('is_active', 1)
        ->where('email_verified', '')
        ->first());

})->middleware(['auth','roleUser','webJson']);

Route::group(['middleware' => ['auth','roleUser','webJson','emailVerified_active']], function () {
    Route::resource('attach','AttachController');
    Route::patch('/{field}/{model}/{id}/edit', function ($field,$model, $id){
        return (new \App\Http\GlobalMethods())->changeBoolean($field, $model, $id);
    });

    Route::get('all-categories', function () {
        return response()->json(\App\Category::orderBy('name')->where('is_active', 1)->get());
    });

    Route::get('all-manufacturers', function () {
        return response()->json(\App\Manufacturer::orderBy('name')->where('is_active', 1)->get());
    });



    Route::resource('aircraft', 'AircraftController')->except('index');
    Route::resource('engine', 'EngineController')->except('index');
    Route::resource('apu', 'ApuController')->except('index');
    Route::resource('part', 'PartController')->except('index');
    Route::resource('wanted', 'WantedController')->except('index');
    Route::resource('suggestion', 'SuggestionController')->except('index');
    Route::resource('favourite', 'FavouriteController')->except('index');
    Route::resource('connection', 'ConnectionController')->except('index');
    Route::resource('lead', 'LeadController')->except('index');

    Route::resource('contact', 'ContactController')->except('index');

    Route::get('/get-dashboard-data', 'UserDashboardController@index');
    Route::post('/profile-setting', 'ContactController@updateProfileDeatils');
    Route::get('/payment-history', 'PaymentHistoryController@show');
    Route::get('/get-plan-details', 'PaymentHistoryController@getPlanDetails');

});