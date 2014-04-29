@extends('layouts.master')
    @section('header')
        <title>One News</title>
    @endsection    
    @section('content')
            <h3>One News</h3>
            <div class="container">
                <div class="row">
                    <article class="col-md-4">
                        <table border="3px" width="800px" bgcolor="#E6E6FA" align="canter">
                            <tr><td>News ID</td><td>{{ $id }}</td></tr> 
                            <tr><td>News title</td><td>{{ $title }}</td></tr>  
                            <tr><td>Author this News</td><td>{{ $author }}</td></tr> 
                            <tr><td>News Description</td><td>{{ $description }}</td></tr> 
                        </table>
                    </article>
                </div>
            </div>
    @endsection