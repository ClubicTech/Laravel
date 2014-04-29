@extends('layouts.master')
    @section('header')
    	<title>Serch News</title>
    @endsection
    
    @section('content')
        <?php
            $error_text = $errors->first('text_search');        
            

        ?>

        {{ Form::open(array('url' => 'news-api-search', 'method' => 'post')) }}
            @if (!empty($error_text))
                <div class="error"> Enter a text search</div>
            @endif
            <div>Search text: {{ Form::text('text_search') }}</div>
            <div>{{ Form::submit('Search News') }}</div>    
        {{ Form::close() }}
    @endsection
