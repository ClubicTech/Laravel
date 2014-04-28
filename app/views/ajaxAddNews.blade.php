@extends('layouts.master')
        @section('header')
        <title>AJAX</title>
        {{ HTML::script('http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js') }}
        {{ HTML::script('js/ajax.js') }}
        @endsection
   @section('content') 
    {{Form::open(array('url' => 'ajax-add-news', 'method' => 'post','id'=>'ajax_form'));}}
        <div id="error_title"></div>
        <div>Title: {{ Form::text('title','',array('id'=>'title')) }}</div>
        <div id="error_author"></div> 
        <div>Author: {{ Form::text('author','',array('id'=>'author')) }}</div>
        <div id="error_description"></div>
        <div>Description: {{ Form::textarea('description','',array('id'=>'description')) }}</div>
        <div id="error_rubric_id"></div>
        <div>Rubric: {{ Form::select('rubric_id', $select_array, array('', ''), array('id'=>'rubric_id')) }}</div>
        <div id="error_review"></div>
        <div>Choose review for this news: {{ Form::select("review[]", $select_review,  array('', ''), array('multiple','id'=>'review')) }}</div>
        <div id="error_tag"></div>
        <div>{{"Choose tag for this news: ".Form::select("tag[]", $select_tag,  array('', ''), array('multiple','id'=>'tag'));}}</div>
        <div><button type="button" onclick="SendRequest('ajax-add-news');">Add News</button></div>
    {{Form::close();}}
        <div id="loader"></div>
    @endsection    