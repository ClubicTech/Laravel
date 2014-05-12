@extends('layouts.master')
   @section('content') 
   

        @if (!$errors->isEmpty())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif
        @if(isset($id) && !empty($id))
        {{ Form::open(array('url' => 'api-change-news/'.$id, 'method' => 'post')); }}

            <div>Title: {{ Form::text('title',$title) }}</div>
            <div>Author: {{ Form::text('author',$author) }}</div>
            <div>Description: {{ Form::textarea('description',$description) }}</div>
                   
            <div>{{ Form::submit('Change News') }}</div>
        {{ Form::close() }}
        @else
          <div class="alert alert-danger"><p>You mast autorisation!!</p></div>
        @endif
        

    @endsection