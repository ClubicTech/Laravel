@extends('layouts.master')
    @section('header')
        <title>Add new Review</title>
    @endsection
    
    @section('content')
        <?php
            $error_title = $errors->first('title');        
            $error_author = $errors->first('author');        
            $error_description = $errors->first('description');        
            $error_rubric_id = $errors->first('rubric_id');        
            $error_news = $errors->first('news');  
            $error_tag = $errors->first('tag');  
        ?>
        {{ Form::open(array('url' => 'add-review', 'method' => 'post')) }} 
            @if (!empty($error_title))
            <div class="error">{{ $error_title }}</div>
            @endif
            <div>Title: {{ Form::text('title') }}</div>
            @if (!empty($error_author))
            <div class="error">{{ $error_author }}</div>
            @endif
            <div> Author: {{ Form::text('author') }}</div>
            @if (!empty($error_description))
            <div class="error">{{ $error_description }}</div>
            @endif
            <div> Description: {{ Form::textarea('description') }}</div>
            @if (!empty($error_rubric_id))
            <div class="error">{{ $error_rubric_id }}</div>
            @endif
            <div> Rubric: {{ Form::select('rubric_id', $select_array) }}</div>
            @if (!empty($error_news))
            <div class="error">{{ $error_news }}</div>
            @endif
            <div> Choose news for this review: {{ Form::select("news[]", $select_news,  array('', ''), array('multiple')) }}</div>
            @if (!empty($error_tag))
            <div class="error">{{ $error_tag }}</div>
            @endif
            <div> Choose tag for this news: {{ Form::select("tag[]", $select_tag,  array('', ''), array('multiple')) }}</div>
            <div>{{ Form::submit('Add Review') }}</div>
        {{ Form::close() }}
    @endsection
