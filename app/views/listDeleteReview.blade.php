<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>delete news</title>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!--    <h3>Hello its News list</h3><br>
    -->
        <div>
<?php echo View::make('Link'); ?>
    </div>

    
    <div class="container">

    <?php  
        //$news = News::all();
        ?>
     <?php  
        $review = Review::paginate(10);
    ?>
    
</div>
    

    <div class="container">
         @foreach (array_chunk($review->all(),10) as $items)
        <div class="row">
                 <?php echo Form::open(array('url' => 'delete-review', 'method' => 'post'));?> 
                @foreach($items as $item)
                    <table border="3px" width="800px" bgcolor="#E6E6FA" align="canter">
                        <tr><td width="300px" >Title</td><td width="300px" >Author</td><td rowspan="2" width="200px"  >Delete: <?php echo Form::checkbox("delete_review[]", $item->id); ?></td></tr>  
                        <tr><td>{{$item->title}}</td><td>{{$item->author}}</td></tr>  
                    </table>
                <br>
                <br>
                    @endforeach
                        <div><?php echo Form::submit('Delete Review'); ?></div>
                <?php echo Form::close();?>
        </div>
        @endforeach
        {{$review->links()}}    
    </div>
    
    
    
    
</body>
</html>

