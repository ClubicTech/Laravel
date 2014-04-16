<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NewsController extends BaseController {

	/*
        |
        |
        |
	*/

    public function viewNews()
        {
            echo View::make('viewNewsList');
	}

    public function formAddNews()
        {
            echo View::make('formAddNews');
	}

    public static function getViewsOneNews($news)
	{
                
                $news1 = array(
                            'id'=>$news->id,
                            'rubric_id'=>$news->rubric_id,
                            'title'=>$news->title,
                            'description'=>$news->description,
                            'author'=>$news->author
                        );
		echo View::make('viewOneNews',$news1);
	}
        
        
    public function addNews(){
        
         $validator = Validator::make(
                array(
                  'title' => Input::get('title'),
                  'rubric_id' => Input::get('rubric_id'),
                  'tag' => Input::get('tag'),
                  'author' => Input::get('author'),
                  'description' => Input::get('description'),
                  'review' => Input::get('review')
                ),
                array(
                  'title' => 'required',
                  'rubric_id' => 'required',
                  'tag' => 'required',
                  'author' => 'required',
                  'description' => 'required',
                  'review' => 'required'
                )
            );
            if($validator->fails()){
                return Redirect::to('add-news')->withErrors($validator);
            }else{
                    $tag = Input::get('tag');
                    $review = Input::get('review');
                            
                    $news = new News();
                    $news->title = Input::get('title');
                    $news->rubric_id = Input::get('rubric_id');
                    $news->author = Input::get('author');
                    $news->description = Input::get('description');
                    $news->save();
                    $news->saveTag($tag);
                    $news->saveReview($review);
                return View::make('viewSuccessAddNews');
            }
    }
        
    
        public function listDeleteNews()
        {
            echo View::make('listDeleteNews');
	}
        
        public function deleteNews(){
            $delete_news = Input::all();
            
              foreach($delete_news as $k=>$v){
                   if($k== 'delete_news'){
                       foreach($v as $k2=>$v1){
                            $news_mass_delete[] = $v1;    
                       }                       
                   }
              }
              
            foreach($news_mass_delete as $v){
                $ObDeleteNews = News::find($v);
                $ObDeleteNews->delete();
            }
            
            echo View::make('deleteNews');
        }
    
        
}