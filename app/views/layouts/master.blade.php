<!doctype html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
        @section('header')
        <title>General title</title>
        @show
    </head>
    <body>
        <div class="menu">
            @section('menu')
            @include('layouts.link')
            @show
        </div>
        
        <div class="body">
            @section('body')

            @show        
            @section('content')
            @show
        </div>
    </body>
</html>