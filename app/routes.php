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

Route::get('one-news/{news}', function(News $news){
    return NewsController::getViewsOneNews($news);
});

Route::model('review', 'Review');

Route::get('one-review/{review}', function(Review $review){
    return ReviewController::getViewsOneReview($review);
});

Route::post('add-news', 'NewsController@addNews');
Route::get('add-news', 'NewsController@formAddNews');

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


//----------------------------------------------------------------------
//----------------------------------------------------------------------

Route::get('/', function()
{
	return View::make('hello');
});

Route::model('news', 'News');

Route::get('change-news/{news}', function(News $news){
    return NewsController::changeNews($news);
});
Route::post('change-news', 'NewsController@addChangeNews');
