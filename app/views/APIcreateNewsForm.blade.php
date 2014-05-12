@extends('layouts.master')
@section('header')
<title>Add new news(API)</title>
@endsection

@section('content')
@if (!$errors->isEmpty())
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif
{{ Form::open(array('url' => 'api-create-news', 'method' => 'post')) }}
<div> Title: {{ Form::text('title') }}</div>
<div> Author: {{ Form::text('author') }}</div>
<div> Description: {{ Form::textarea('description') }}</div>

<div>{{ Form::submit('Add News(API)') }}</div>    
{{ Form::close() }}
@endsection
