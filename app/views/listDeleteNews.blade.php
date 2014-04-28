@extends('layouts.master')
    @section('header')
        <title>delete news</title>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
    @endsection
    
    @section('content')
    <div class="container">
     <?php   $news = News::paginate(10); ?>
    </div>
    <div class="container">
         @foreach (array_chunk($news->all(),10) as $items)
        <div class="row">
            {{ Form::open(array('url' => 'delete-news', 'method' => 'post')) }} 
                @foreach($items as $item)
                  <table border="3px" width="800px" bgcolor="#E6E6FA" align="canter">
                    <tr><td width="300px" >Title</td><td width="300px" >Author</td><td rowspan="2" width="200px">Delete:  {{ Form::checkbox("delete_news[]", $item->id) }}</td></tr>  
                    <tr><td>{{$item->title}}</td><td>{{$item->author}}</td></tr>  
                  </table>
                <br>
                <br>
                @endforeach
                <div>{{ Form::submit('Delete News') }}</div>
            {{ Form::close() }}
        </div>
        @endforeach
        {{ $news->links() }}    
    </div>
    @endsection    