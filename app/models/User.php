<?php
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User extends Eloquent implements UserInterface, RemindableInterface {
    protected $table = 'users'; 
    public $timestamps = false;
    /**
    * Get the unique identifier for the user.
    *
    * @return mixed
    */
   public function getAuthIdentifier()
   {
       return $this->getKey();
   }

   /**
    * Get the password for the user.
    *
    * @return string
    */
   public function getAuthPassword()
   {
       return $this->password;
   }

   /**
    * Get the e-mail address where password reminders are sent.
    *
    * @return string
    */
   public function getReminderEmail()
   {
       return $this->email;
   }
  
   
      /**
    * Get the username for this user.
    *
    * @return string
    */
   public function getReminderUserName()
   {
       return $this->username;
   }

}