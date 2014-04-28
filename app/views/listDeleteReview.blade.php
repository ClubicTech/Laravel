@extends('layouts.master')
    @section('header')
        <title>delete Review</title>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
    @endsection
    
    @section('content')
     <?php  $review = Review::paginate(10); ?>
     <div class="container">
         @foreach (array_chunk($review->all(),10) as $items)
        <div class="row">
            {{ Form::open(array('url' => 'delete-review', 'method' => 'post')) }} 
                @foreach($items as $item)
                    <table border="3px" width="800px" bgcolor="#E6E6FA" align="canter">
                        <tr><td width="300px" >Title</td><td width="300px" >Author</td><td rowspan="2" width="200px"  >Delete: {{ Form::checkbox("delete_review[]", $item->id) }}</td></tr>  
                        <tr><td>{{$item->title}}</td><td>{{$item->author}}</td></tr>  
                    </table>
                <br>
                @endforeach
               <div>{{ Form::submit('Delete Review') }}</div>
            {{ Form::close() }}
        </div>
        @endforeach
        {{$review->links()}}    
    </div>
    @endsection