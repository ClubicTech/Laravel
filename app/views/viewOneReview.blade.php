@extends('layouts.master')
    @section('header')
        <title>One Review</title>
    @endsection    
    @section('content')
            <h3>One Review</h3>
            <div class="container">
                <div class="row">
                    <article class="col-md-4">
                        <table border="3px" width="800px" bgcolor="#E6E6FA" align="canter">
                            <tr><td>Review ID</td><td>{{ $id }}</td></tr> 
                            <tr><td>Review rubric ID</td><td>{{ $rubric_id }}</td></tr> 
                            <tr><td>Review title</td><td>{{ $title }}</td></tr>  
                            <tr><td>Author this Review</td><td>{{ $author }}</td></tr> 
                            <tr><td>Review Description</td><td>{{ $description }}</td></tr> 
                        </table>
                    </article>
                </div>
            </div>
    @endsection
