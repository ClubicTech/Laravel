@extends('layouts.master')
   @section('content') 
        <?php
            $error_title = $errors->first('title');        
            $error_author = $errors->first('author');        
            $error_description = $errors->first('description');        
            $error_rubric_id = $errors->first('rubric_id');        
            $error_review = $errors->first('review');  
            $error_tag = $errors->first('tag');  
        ?>
       {{ Form::open(array('url' => 'change-news', 'method' => 'post')); }}
          @if (!empty($error_title))
            <div class="error">{{ $error_title }}</div>
          @endif
            <div>Title: {{ Form::text('title',$news->title) }}</div>

          @if (!empty($error_author))
            <div class="error">{{ $error_author }}</div>
          @endif       
            <div>Author: {{ Form::text('author',$news->author) }}</div>
            <div>{{ Form::hidden('id',$news->id) }}</div>
          @if (!empty($error_description))
            <div class="error">{{ $error_description }}</div>
          @endif
            <div>Description: {{ Form::textarea('description',$news->description) }}</div>
            @if (!empty($error_rubric_id))
            <div class="error">{{ $error_rubric_id }}</div>
          @endif 
            <div>Rubric: {{ Form::select('rubric_id', $select_array,array($news->rubric_id, $news->rubric_id)) }}</div>
          @if (!empty($error_review))
            <div class="error">{{ $error_review }}</div>
          @endif
            <div>Choose review for this news: {{ Form::select("review[]", $select_review, $select_review_value, array('multiple')) }}</div>
          @if (!empty($error_tag))
            <div class="error">{{ $error_tag }}</div>
          @endif 
            <div>Choose tag for this news: {{ Form::select("tag[]", $select_tag,  $select_tag_value, array('multiple')) }}</div>

            <div>{{ Form::submit('Change News') }}</div>
        {{ Form::close() }}
    @endsection