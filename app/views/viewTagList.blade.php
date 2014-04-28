@extends('layouts.master')
    @section('header')
        <title>Tag LIST</title>
    @endsection    
    @section('content')
    <h3>Hello its Tag list</h3><br>
    <?php  $tag = Tag::paginate(3); ?>
    <div class="container">
            @foreach (array_chunk($tag->all(),3) as $items)
            <div class="row">
                @foreach($items as $item)
                <article class="col-md-5">
                    <table border="3px" width="800px" bgcolor="#E6E6FA" align="canter">
                        <tr><td>Tag ID</td><td>{{$item->id}}</td></tr> 
                        <tr><td>Tag text's</td><td>{{$item->tag_text}}</td></tr>
                    </table>
                </article>
                @endforeach
            </div>
            @endforeach
        {{$tag->links()}}
    </div>
    @endsection 