<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Rubric</title>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h3>Hello its Rubric list</h3><br>
    
        <div>
<?php echo View::make('Link'); ?>
    </div>

   <div class="container">

    <?php  
        $rubric = Rubric::paginate(3);  
        //$url = URL::route('products-list');
        
    ?>
    
    
</div>
    
    
    <div class="container">
            @foreach (array_chunk($rubric->all(),3) as $items)
            <div class="row">
                @foreach($items as $item)
                <article class="col-md-5">
                    <table border="3px" width="800px" bgcolor="#E6E6FA" align="canter">
<!--                        <tr><td colspan="2" align="center"><a href="http://test1.com/products-list/{{$item->id}}" >Read more!!</a></td></tr> -->
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
     
</body>
</html>

