<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Review LIST</title>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h3>Hello its Review list</h3><br>
    
        <div>
<?php echo View::make('Link'); ?>
    </div>

    
    
    <?php  
        $review = Review::paginate(3);  
        //$url = URL::route('products-list');
        
    ?>
    
    
    
    <div class="container">
            @foreach (array_chunk($review->all(),3) as $items)
            <div class="row">
                @foreach($items as $item)
                <article class="col-md-5">
                    <table border="3px" width="800px" bgcolor="#E6E6FA" align="canter">
                        <tr><td colspan="2" align="center"><a href="http://test1.com/one-review/{{$item->id}}" >Read more!!</a></td></tr> 
                        <tr><td>Review ID</td><td>{{$item->id}}</td></tr> 
                        <tr><td>Review rubric ID</td><td>{{$item->rubric_id}}</td></tr> 
                        <tr><td>Review titled</td><td>{{$item->title}}</td></tr> 
                        <tr><td>Review description's</td><td>{{$item->description}}</td></tr> 
                        <tr><td>Review author</td><td>{{$item->author}}</td></tr> 
                    </table>
                </article>
                @endforeach
            </div>
            @endforeach
        {{$review->links()}}
            
    </div>
     
    
    
    
</body>
</html>

