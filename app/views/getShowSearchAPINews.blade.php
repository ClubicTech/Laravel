@extends('layouts.master')
    @section('header')
        <title>Show search News</title>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
    @endsection    
    @section('content')
    <h3>Hello its News list</h3><br>

    <div class="container">
        @if ($success)
            <div class="row">
                @foreach($news as $item)
                <article class="col-md-5">
                    <table border="3px" width="800px" bgcolor="#E6E6FA" align="canter">
                        <tr><td colspan="2" align="center"><a href="http://test1.com/one-news-api/{{$item->id}}" >Read more this news(API)</a></td></tr> 
                        <tr><td>News ID</td><td>{{$item->id}}</td></tr> 
                        <tr><td>News rubric ID</td><td>{{$item->rubric_id}}</td></tr> 
                        <tr><td>News titled</td><td>{{$item->title}}</td></tr> 
                        <tr><td>News description's</td><td>{{$item->description}}</td></tr> 
                        <tr><td>News author</td><td>{{$item->author}}</td></tr> 
                    </table>
                </article>
                @endforeach
            </div>
        @endif
        @if (!$success)
            <div class="row">{{ $message }}</div>
        @endif
    </div>
    @endsection