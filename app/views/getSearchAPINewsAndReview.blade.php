@extends('layouts.master')
    @section('header')
    	<title>SEARCH News & Reviews</title>
    @endsection
    
    @section('content')
        <?php
            $text_tag = $errors->first('text_tag');        
            

        ?>

        {{ Form::open(array('url' => 'review-news-api-search', 'method' => 'post')) }}
            @if (!empty($text_tag))
                <div class="error"> Enter a TAG search</div>
            @endif
            <div>Tag for search: {{ Form::text('text_tag') }}</div>
            <div>{{ Form::submit('Search News&Reviews') }}</div>    
        {{ Form::close() }}
    @endsection
