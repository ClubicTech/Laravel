@extends('layouts.master')
    @section('header')
    	<title>Add Rubric news</title>
    @endsection
    
    @section('content')
    <?php
        $error_name = $errors->first('name');        
        $error_description = $errors->first('description');        
        $error_rubric_id = $errors->first('rubric_id');        
      
    ?>
    {{ Form::open(array('url' => 'add-rubric', 'method' => 'post')) }}
        @if (!empty($error_name))
            <div class="error">{{ $error_name }}</div>
        @endif
        <div>Name: {{ Form::text('name') }}</div>
        @if (!empty($error_description))
            <div class="error">{{ $error_description }}</div>
        @endif
        <div> Description: {{ Form::textarea('description') }}</div>
        @if (!empty($error_rubric_id))
            <div class="error">{{ $error_rubric_id }}</div>
        @endif 
        <div>Rubric: {{ Form::select('rubric_id', $select_array) }}</div>            
        <div>{{ Form::submit('Add new Rubric') }}</div>    
    {{ Form::close() }}
 @endsection