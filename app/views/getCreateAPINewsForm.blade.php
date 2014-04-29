@extends('layouts.master')
    @section('header')
    	<title>Add new news(API)</title>
    @endsection
    
    @section('content')
        <?php
            $error_title = $errors->first('title');        
            $error_author = $errors->first('author');        
            $error_description = $errors->first('description');        

        ?>
            @if ($success)
                <div class="error"> You News Add Success!! </div>
            @endif
        {{ Form::open(array('url' => 'create-news-api', 'method' => 'post')) }}
            @if (!empty($error_title))
                <div class="error">{{ $error_title }}</div>
            @endif
            <div> Title: {{ Form::text('title') }}</div>
            @if (!empty($error_author))
                <div class="error">{{ $error_author }}</div>
            @endif
            <div> Author: {{ Form::text('author') }}</div>
            @if (!empty($error_description))
                <div class="error">{{ $error_description }}</div>
            @endif
            <div> Description: {{ Form::textarea('description') }}</div>

            <div>{{ Form::submit('Add News(API)') }}</div>    
        {{ Form::close() }}
    @endsection
