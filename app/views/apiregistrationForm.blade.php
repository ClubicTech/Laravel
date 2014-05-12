@extends('layouts.master')
    @section('header')
    	<title>Registration</title>
    @endsection
    
    @section('content')
        <?php
            $error_username = $errors->first('username');        
            $error_email = $errors->first('email');        
            $error_password = $errors->first('password');        
            

        ?>
<div class="container">
    
            @if (!$errors->isEmpty())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif
    
        {{ Form::open(array('url' => 'api-registration', 'method' => 'post')) }}
            @if (!empty($error_username))
                <div class="alert alert-danger">{{ $error_username }}</div>
            @endif
            @if (isset($issetusername))
                @if ($issetusername)
                    <div class="alert alert-danger">{{ $varningmessage }}</div>
                @endif
            @endif
            @if (!isset($username))
                <div> User name(Login): {{ Form::text('username', null, array('class' => 'form-control', 'placeholder' => 'login')) }}</div>
            @else
                <div> User name(Login): {{ Form::text('username', $username, array('class' => 'form-control', 'placeholder' => 'login')) }}</div>
            @endif
            
            @if (!empty($error_email))
                <div class="alert alert-danger">{{ $error_email }}</div>
            @endif
            @if (!isset($email))
                <div> E-mail: {{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'email')) }}</div>
            @else
                <div> E-mail: {{ Form::text('email', $email, array('class' => 'form-control', 'placeholder' => 'email')) }}</div>
            @endif
            
            @if (!empty($error_password))
                <div class="alert alert-danger">{{ $error_password }}</div>
            @endif
            @if (!isset($password))
                <div> You password:  {{ Form::password('password', array('class' => 'form-control', 'placeholde' => 'password')) }}</div>
            @else
                <div> You password:  {{ Form::password('password', array('class' => 'form-control', 'placeholde' => $password)) }}</div>
            @endif
            
            <div>{{ Form::submit('Registration',array('class' => 'btn btn-lg btn-primary btn-block')) }}</div>    
        {{ Form::close() }}
    @endsection
</div>