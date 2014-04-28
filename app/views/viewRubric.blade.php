@extends('layouts.master')
    @section('header')
        <title>Rubric</title>
    @endsection    
    @section('content')
    <h3>Hello its Review list</h3><br>
    <?php  $rubric = Rubric::paginate(3); ?>
    <div class="container">
            @foreach (array_chunk($rubric->all(),3) as $items)
            <div class="row">
                @foreach($items as $item)
                <article class="col-md-5">
                    <table border="3px" width="800px" bgcolor="#E6E6FA" align="canter">
                        <tr><td>Rubric ID</td><td>{{$item->id}}</td></tr> 
                        <tr><td>Rubric root_ID</td><td>{{$item->root_id}}</td></tr> 
                        <tr><td>Rubric name's</td><td>{{$item->name}}</td></tr> 
                        <tr><td>Rubric description's</td><td>{{$item->description}}</td></tr>
                    </table>
                </article>
                @endforeach
            </div>
            @endforeach
        {{$rubric->links()}}
    </div>
    @endsection        
