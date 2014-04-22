<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Tag extends Eloquent{
    protected $table = 'tag'; 
    public $timestamps = false;
    
    // связимаем модель тега с новостями многие к многим
    public function news(){
        return $this->belongsToMany('News','prom_tag_new');
    }
    
    // связимаем модель тега с обзорами многие к многим
    public function review(){
        return $this->belongsToMany('Review','prom_tag_review');
    }
    
        
     public function saveReview($review){
        $id = $this->id;
         foreach ($review as $k=>$v){             
            $review = Review::find($v);
            $tag = Tag::find($id);
            $tag->review()->save($review);
            
        }
    }
    
    public function saveNews($news){
        $id = $this->id;
         foreach ($news as $k=>$v){
            $news = News::find($v);
            $tag = Tag::find($id);
            $tag->news()->save($news);
        }
    }
    
}