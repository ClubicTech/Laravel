<?php

class AjaxController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Ajax Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('view-news', 'HomeController@showWelcome');
	|
	*/
    
	public function ajaxAddNews()
	{
		echo View::make('ajaxAddNews');
	}
	
        public function ajaxAdd()
	{
            if(Request::ajax()){
                    $tag = Input::get('tag');
                    $review = Input::get('review');
                    $id =  Input::get('id');
                                        
                    $news = new News();
                    $news->title = Input::get('title');
                    $news->rubric_id = Input::get('rubric_id');
                    $news->author = Input::get('author');
                    $news->description = Input::get('description');
                    $news->save();
                    $news->saveTag($tag);
                    $news->saveReview($review);
                echo "You new News success add in BD!";  
            }else{
            }
 	}
        
        
        public static function changeNews($news)
	{
		        $news1 = array(
                            'id'=>$news->id,
                            'rubric_id'=>$news->rubric_id,
                            'title'=>$news->title,
                            'description'=>$news->description,
                            'author'=>$news->author,
                            'tag'=>$news->tag,  
                            'review'=>$news->review,
                        );
            echo View::make('ajaxFormChangeNames',$news1);
	}
        
        
        public static function ajaxAddChangeNews()
	{
            if(Request::ajax()){
                    $tag = Input::get('tag');
                    $review = Input::get('review');
                    $id =  Input::get('id');
                                        
                    $news = News::find($id);
                    
                    $news->title = Input::get('title');
                    $news->rubric_id = Input::get('rubric_id');
                    $news->author = Input::get('author');
                    $news->description = Input::get('description');
                    $news->save();
                    $news->saveTag($tag);
                    $news->saveReview($review);
                echo "You change add!!";
            }else{}
            
        }

}