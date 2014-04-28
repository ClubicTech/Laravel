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
                $rubric =  Rubric::all(); 
                foreach ($rubric as $rubrics){
                        $select_array[$rubrics->id] = $rubrics->name; 
                }

                $review = Review::all(); 
                foreach ($review as $reviews){
                        $select_review[$reviews->id] = $reviews->title; 
                }

                $tag = Tag::all();  
                foreach ($tag as $tags){
                        $select_tag[$tags->id] = $tags->tag_text; 
                }
                $inform = array( 'select_array' => $select_array, 
                                 'select_review' => $select_review,
                                 'select_tag' => $select_tag
                                );
		return View::make('ajaxAddNews',$inform);
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
                    
                    //$transaction = DB::transaction(function($news){
                        $news->save();
                        $news->saveTag($tag);
                        $news->saveReview($review);
                    //});
                 echo "You new News success add in BD!"; 
                 
            }
 	}
        
        
        public function changeNews($news)
	{
            
            foreach ($news->review as $item){
                $select_review_value[] = $item->id;
                $select_review_value[] = $item->title;
            }
            
            foreach($news->tag as $item){
                $select_tag_value[] = $item->id;
                $select_tag_value[] = $item->tag_text;
            }
    
            $rubric =  Rubric::all();      
            foreach ($rubric as $rubrics){
                    $select_array[$rubrics->id] = $rubrics->name; 
            }
            
            $review = Review::all();  
            foreach ($review as $reviews){
                    $select_review[$reviews->id] = $reviews->title; 
            }
            
            $tag = Tag::all();  
            foreach ($tag as $tags){
                    $select_tag[$tags->id] = $tags->tag_text; 
            }
            
            $news1 = array(
                            'news' => $news,
                            'select_tag_value' => $select_tag_value,
                            'select_tag' => $select_tag,
                            'select_review_value' => $select_review_value,
                            'select_review' => $select_review,
                            'select_array' => $select_array,
                           );
            return View::make('ajaxFormChangeNames',$news1);
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
                return "You change add!!";
            }
        }

}