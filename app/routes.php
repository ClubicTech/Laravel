<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

//----------------------------------------------------------------------
//----------------------------------------------------------------------


Route::get('news', 'NewsController@viewNews');

Route::get('review', 'ReviewController@viewReview');

Route::get('rubric', 'RubricController@viewRubric');

Route::get('tag', 'TagController@viewTag');

Route::model('news', 'News');
Route::get('one-news/{news}', 'NewsController@getViewsOneNews');

Route::model('review', 'Review');
Route::get('one-review/{review}', 'ReviewController@getViewsOneReview');

Route::post('add-news', 'NewsController@addNews');
Route::get('add-news', 'NewsController@formAddNews');


Route::get('/', 'HomeController@showWelcome');

//--------------------------------------------------------------------------------------------
Route::get('api.test1/news', 'NewsController@getJSONNews');

Route::get('api.test1/news/{id}', 'NewsController@getOneJSONNews');


Route::get('api.test1/news/search/{name}', 'NewsController@searchJSONNews');

Route::get('api.test1/news/tag/search/{tag}', 'NewsController@searchJSONNewsTag');


// -------------------------   -------------------------   ---------------------
// -------------------------   -------------------------   ---------------------





Route::get('login', 'AuthController@getLogin');
Route::post('login', 'AuthController@setLogin');

Route::get('registration', 'AuthController@registrationForm');
Route::post('registration', 'AuthController@registrationUser');



Route::group(array('before' => 'auth'), function () {
    
    Route::get('logout', 'AuthController@logout');
    
    Route::get('change-news-api/{id}', 'RequestAPIController@formMakeChanges');
    Route::post('change-news-api/{id}', 'RequestAPIController@savingChangesNews');

    Route::get('get-all-api-news', 'RequestAPIController@showAllNews');
    Route::get('one-news-api/{id}', 'RequestAPIController@displayOneNews');

    Route::get('news-api-search', 'RequestAPIController@formSearchNews');
    Route::post('news-api-search', 'RequestAPIController@showSearchNews');

    Route::get('review-news-api-search', 'RequestAPIController@formSearchNewsAndReview');
    Route::post('review-news-api-search', 'RequestAPIController@showSearchNewsAndReview');

    Route::get('delete-news-api/{id}', 'RequestAPIController@removalNews');

    Route::get('create-news-api', 'RequestAPIController@formCreatingNews');
    Route::post('create-news-api', 'RequestAPIController@addingCreatedNews');

    Route::get('api.test1/news/delete/{id}', 'NewsController@deteteJSONNews');
    Route::delete('api.test1/news/delete/{id}', 'NewsController@deteteJSONNews');

    Route::post('api.test1/news/change/{id}', 'NewsController@changeJSONNews');

    Route::post('api.test1/news/create', 'NewsController@createJSONNews');

    Route::get('add-review', 'ReviewController@formAddReview');
    Route::post('add-review', 'ReviewController@addReview');

    Route::get('add-rubric', 'RubricController@formAddRubric');
    Route::post('add-rubric', 'RubricController@addRubric');

    Route::get('add-tag', 'TagController@formAddTag');
    Route::post('add-tag', 'TagController@addTag');

    Route::get('delete-news', 'NewsController@listDeleteNews');
    Route::post('delete-news', 'NewsController@deleteNews');

    Route::get('delete-review', 'ReviewController@listDeleteReview');
    Route::post('delete-review', 'ReviewController@deleteReview');

    Route::model('news', 'News');
    Route::get('change-news/{news}', "NewsController@changeNews");
    Route::post('change-news', 'NewsController@addChangeNews');



    Route::get('ajax-change-news/{news}', 'AjaxController@changeNews');
//Route::post('ajax-change/{news}', 'AjaxController@ajaxAddChangeNews');

    Route::post('ajax-change-news/ajax-change', array('as' => 'ajax-change',
        'ajax-change-news' => function () {
    echo AjaxController::ajaxAddChangeNews();
}
    ));

    Route::get('ajax-add-news', 'AjaxController@ajaxAddNews');
    Route::post('ajax-add-news', "AjaxController@ajaxAdd");
});









