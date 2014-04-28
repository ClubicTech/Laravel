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
            return View::make('viewReviewList');
        }

        public static function getViewsOneReview($review)  
        {
                
            $review1 = array(
                            'id'=>$review->id,
                            'rubric_id'=>$review->rubric_id,
                            'title'=>$review->title,
                            'description'=>$review->description,
                            'author'=>$review->author
                        );
            echo View::make('viewOneReview',$review1);
	}
        
        public function formAddReview()
        {
            $rubric =  Rubric::all();
            foreach ($rubric as $rubrics){
                    $select_array[$rubrics->id] = $rubrics->name; 
            }

            $new = News::all();  
            foreach ($new as $news){
                    $select_news[$news->id] = $news->title; 
            }

            $tag = Tag::all();  
            foreach ($tag as $tags){
                    $select_tag[$tags->id] = $tags->tag_text; 
            }
            $info = array( 'select_array' => $select_array,
                           'select_news' => $select_news,
                           'select_tag' => $select_tag 
                         );
            return View::make('formAddReview',$info);     
        }
        
        public function addReview()
        {
            
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
        
        public function deleteReview()
        {
            $delete_review = Input::get('delete_review');
            foreach($delete_review as $key_mass => $valueIdReview){
                $ObDeleteNews = Review::find($valueIdReview);
                $ObDeleteNews->delete();
            }
            
            echo View::make('deleteReview');
        }
    
        
        
}



