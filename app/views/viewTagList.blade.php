<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Tag LIST</title>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h3>Hello its Tag list</h3><br>
    
        <div>
<?php echo View::make('Link'); ?>
    </div>

    
    
    <?php  
        $tag = Tag::paginate(3);  
        //$url = URL::route('products-list');
        
    ?>
    
    
    
    <div class="container">
            @foreach (array_chunk($tag->all(),3) as $items)
            <div class="row">
                @foreach($items as $item)
                <article class="col-md-5">
                    <table border="3px" width="800px" bgcolor="#E6E6FA" align="canter">
<!--                        <tr><td colspan="2" align="center"><a href="http://test1.com/products-list/{{$item->id}}" >Read more!!</a></td></tr> -->
                        <tr><td>Tag ID</td><td>{{$item->id}}</td></tr> 
                        <tr><td>Tag text's</td><td>{{$item->tag_text}}</td></tr>
                    </table>
                </article>
                @endforeach
            </div>
            @endforeach
        {{$tag->links()}}
            
    </div>
    
</body>
</html>

