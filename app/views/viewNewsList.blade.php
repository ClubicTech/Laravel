@extends('layouts.master')
    @section('header')
        <title>delete Review</title>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
    @endsection    
    @section('content')
    <h3>Hello its News list</h3><br>
    <?php  $news = News::paginate(3); ?>
    <div class="container">
            @foreach (array_chunk($news->all(),3) as $items)
            <div class="row">
                @foreach($items as $item)
                <article class="col-md-5">
                    <table border="3px" width="800px" bgcolor="#E6E6FA" align="canter">
                        <tr><td colspan="2" align="center"><a href="http://test1.com/one-news/{{$item->id}}" >Read more this news</a></td></tr> 
                        <tr><td colspan="2" align="center"><a href="http://test1.com/change-news/{{$item->id}}" >Change this news</a></td></tr> 
                        <tr><td colspan="2" align="center"><a href="http://test1.com/ajax-change-news/{{$item->id}}" >AJAX Change this news</a></td></tr> 
                        <tr><td>News ID</td><td>{{$item->id}}</td></tr> 
                        <tr><td>News rubric ID</td><td>{{$item->rubric_id}}</td></tr> 
                        <tr><td>News titled</td><td>{{$item->title}}</td></tr> 
                        <tr><td>News description's</td><td>{{$item->description}}</td></tr> 
                        <tr><td>News author</td><td>{{$item->author}}</td></tr> 
                    </table>
                </article>
                @endforeach
            </div>
            @endforeach
    {{$news->links()}}
    </div>
    @endsection
