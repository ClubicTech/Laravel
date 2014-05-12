@extends('layouts.master')
    @section('header')
    	<title>Serch News</title>
    @endsection
    
    @section('content')
    @if (!$errors->isEmpty())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
    </div>
        @endif
        {{ Form::open(array('url' => 'api-search-news', 'method' => 'post')) }}
            <div>Search text: {{ Form::text('text_search') }}</div>
            <div>{{ Form::submit('Search News') }}</div>    
        {{ Form::close() }}
    @endsection
