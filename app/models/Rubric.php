<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Rubric extends Eloquent{
    protected $table = 'rubric'; 
    public $timestamps = false;

    public function review(){
         return $this->hasMany('Review');
    }

    public function news(){
         return $this->hasMany('News');
    }

    
}