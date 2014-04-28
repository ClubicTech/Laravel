@extends('layouts.master')
    @section('header')
    	<title>Add TAG news</title>
    @endsection
    
    @section('content')
        <?php
            $tag_text = $errors->first('tag_text');          
            $error_review = $errors->first('review');  
            $error_news = $errors->first('news');  
        ?>
        {{ Form::open(array('url' => 'add-tag', 'method' => 'post')) }}
            @if (!empty($tag_text))
            <div class="error">{{ $tag_text }}</div>
            @endif
            <div> Tag text: {{ Form::text('tag_text') }}</div>
            @if (!empty($error_review))
            <div class="error">{{ $error_review }}</div>
            @endif  
            <div> Choose review for this news: {{ Form::select("review[]", $select_review,  array('', ''), array('multiple')) }}</div>
            @if (!empty($error_news))
            <div class="error">{{ $error_news }}</div>
            @endif 
            <div>Choose news for this tag: {{ Form::select("news[]", $select_news,  array('', ''), array('multiple')) }}</div>
            <div>{{ Form::submit('Add Tag') }}</div>
        {{ Form::close() }}
    @endsection