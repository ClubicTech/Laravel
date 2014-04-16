<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class News extends Eloquent{
    protected $table = 'news'; 
    public $timestamps = false;
    
    // связимаем модель Новостей(News) с Рубрикой(Rubric) многие к одному
    public function rubric(){
        return $this->belongsTo('Rubric');
    }
    
    // связимаем модель Новостей(News) с Тег(Tag) многие к многим
    public function tag(){
        return $this->belongsToMany('Tag','prom_tag_new');
    }
    
    // связимаем модель Новостей(News) с Обзоры(Review) многие к многим
    public function review(){
        return $this->belongsToMany('Review','prom_new_review');
    }
    
    public function saveTag($tag){
        $id = $this->id;
         foreach ($tag as $k=>$v){
            $tag = Tag::find($v);
            $news = News::find($id);
            $news->tag()->save($tag);
        }
    }
    
    public function saveReview($review){
        $id = $this->id;
         foreach ($review as $k=>$v){
            $review = Review::find($v);
            $news = News::find($id);
            $news->review()->save($review);
        }
    }
    
}