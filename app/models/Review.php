<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Review extends Eloquent{
    protected $table = 'review'; 
    public $timestamps = false;

    // связимаем модель Обзоров(Review) с рубрикой многие к одному
    public function rubric(){
        return $this->belongsTo('Rubric');
    }
    
    // связимаем модель Обзоров(Review) с Тегом(Tag) многие к многим
    public function tag(){
        return $this->belongsToMany('Tag','prom_tag_review');
    }
    // связимаем модель Обзоров(Review) с Новостями(News) многие к многим
    public function news(){
        return $this->belongsToMany('News','prom_new_review');
    }
    
    
     public function saveTag($tag){
        $id = $this->id;
         foreach ($tag as $k=>$v){
            $tag = Tag::find($v);
            $review = Review::find($id);
            $review->tag()->save($tag);
        }
    }
    
    public function saveNews($news){
        $id = $this->id;
         foreach ($news as $k=>$v){
            $news = News::find($v);
            $review= Review::find($id);
            $review->news()->save($news);
        }
    }
    
    
}