<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ReviewController extends BaseController {

	/*
        |
        |
        |
	*/

    public function viewReview()
        {
            echo View::make('viewReviewList');
	}

        //ReviewController::getViewsOneReview($review);
    public static function getViewsOneReview($review)  
        {
                
                $review1 = array(
                            'id'=>$review->id,
                            'rubric_id'=>$review->rubric_id,
                            'title'=>$review->title,
                            'description'=>$review->description,
                            'author'=>$review->author
                        );
                
                //print_r("<br>______________________________________<br>");
		echo View::make('viewOneReview',$review1);//->with($products);
	}
        
        public function formAddReview(){
            
            return View::make('formAddReview');
             
        }
        
        public function addReview(){
            
         $validator = Validator::make(
                array(
                  'title' => Input::get('title'),
                  'rubric_id' => Input::get('rubric_id'),
                  'tag' => Input::get('tag'),
                  'author' => Input::get('author'),
                  'description' => Input::get('description'),
                  'news' => Input::get('news')
                ),
                array(
                  'title' => 'required',
                  'rubric_id' => 'required',
                  'tag' => 'required',
                  'author' => 'required',
                  'description' => 'required',
                  'news' => 'required'
                )
            );
            if($validator->fails()){
                return Redirect::to('add-review')->withErrors($validator);
            }else{
                $tag = Input::get('tag');
                $news = Input::get('news');
                
                $review = new Review();
                $review->title = Input::get('title');
                $review->rubric_id = Input::get('rubric_id');
                $review->author = Input::get('author');
                $review->description = Input::get('description');
                $review->save();
                $review->saveTag($tag);
                $review->saveNews($news);
                return View::make('viewSuccessAddReview');                
                
            }
        }
        
        
        public function listDeleteReview()
        {
            echo View::make('listDeleteReview');
	}
        
        public function deleteReview(){
            $delete_review = Input::all();
            
              foreach($delete_review as $k=>$v){
                   if($k== 'delete_review'){
                       foreach($v as $k2=>$v1){
                            $review_mass_delete[] = $v1;    
                       }                       
                   }
              }
              
            foreach($review_mass_delete as $v){
                $ObDeleteNews = Review::find($v);
                $ObDeleteNews->delete();
            }
            
            echo View::make('deleteReview');
        }
    
        
        
}



