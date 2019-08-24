<?php
/**
 * This file is a part of MicroDreamIT
 * (c) Shahanur Sharif <shahanur.sharif@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * or visit https://microdreamit.com
 * Created by Shahanur Sharif.
 * User: sharif
 * Date: 7/11/2018
 * Time: 4:58 PM
 */
Route::group(['middleware' => ['webJson']], function () {
    Route::get('categories-list', 'CategoryController@lists');
    Route::get('manufacturer-list', 'ManufacturerController@lists');
    Route::get('type-list', 'TypeController@lists');
    Route::get('model-list', 'ModeledController@lists');
    Route::get('speciality-list', 'SpecialityController@lists');
    Route::get('title-list', 'TitleController@lists');
    Route::get('company-list', 'CompanyController@lists');
    Route::get('news-list', 'NewsController@lists');
    Route::get('event-list', 'EventController@lists');
    Route::get('airfield-list', 'AirfieldController@lists');
    Route::get('airport-list', 'AirportController@lists');
    Route::get('canned-email-list', 'CannedemailController@lists');
    Route::get('state-list', 'StateController@lists');
    Route::get('city-list', 'CityController@lists');
    Route::get('country-list', 'CountryController@lists');
    Route::get('subscriber-list', 'SubscriberController@lists');
    Route::get('seo-list', 'SeoController@lists');
    Route::get('continent-list', 'ContinentController@lists');
    Route::get('region-list', 'RegionController@lists');
    Route::get('cms-list', 'CmsController@lists');
    Route::get('condition-list', 'ConditionController@lists');
    Route::get('release-list', 'ReleaseController@lists');
    Route::get('plan-list', 'PlanController@lists');
    Route::get('configuration-list', 'ConfigurationController@lists');
});
