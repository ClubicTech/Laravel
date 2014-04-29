@extends('layouts.master')
   @section('content') 
        <?php
            $error_title = $errors->first('title');        
            $error_author = $errors->first('author');        
            $error_description = $errors->first('description');        
        ?>
         @if ($success)
            <div class="error"> You changes add success!! </div>
          @endif
         @if (!$success && !empty($message) )
            <div class="error"> {{ $message }} </div>
          @endif
          
       {{ Form::open(array('url' => 'change-news-api/'.$id, 'method' => 'post')); }}
          @if (!empty($error_title))
            <div class="error">{{ $error_title }}</div>
          @endif
            <div>Title: {{ Form::text('title',$title) }}</div>

          @if (!empty($error_author))
            <div class="error">{{ $error_author }}</div>
          @endif       
            <div>Author: {{ Form::text('author',$author) }}</div>
            <div>{{ Form::hidden('id',$id) }}</div>
          @if (!empty($error_description))
            <div class="error">{{ $error_description }}</div>
          @endif
            <div>Description: {{ Form::textarea('description',$description) }}</div>
                   
            <div>{{ Form::submit('Change News') }}</div>
        {{ Form::close() }}
    @endsection