@extends('layouts.master')
    @section('content')
        @if ($success)
            <h1>You news DELETE successes!!</h1>
            <div class="error"> {{ $message }} </div>
        @endif
        @if (!$success && !empty($message) )
            <h1>You news NOT DELETE!!</h1>
            <div class="error"> {{ $message }} </div>
        @endif    	
    @endsection 