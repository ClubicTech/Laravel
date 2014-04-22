<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>One reviews title</title>

<!--        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">-->

</head>
<body>
    	<div class="welcome">
            <div>
            </div>
            <h3>One News</h3>
<?php echo View::make('Link'); ?>
	</div>
    
            <div class="container">
                <div class="row">
                    <article class="col-md-4">
                        <table border="3px" width="800px" bgcolor="#E6E6FA" align="canter">
                            <tr><td>Review ID</td><td>{{$id}}</td></tr> 
                            <tr><td>Review rubric ID</td><td>{{$rubric_id}}</td></tr> 
                            <tr><td>Review title</td><td>{{$title}}</td></tr>  
                            <tr><td>Author this Review</td><td>{{$author}}</td></tr> 
                            <tr><td>Review Description</td><td>{{$description}}</td></tr> 
                        </table>
                    </article>
                </div>
            </div>
    
</body>
</html>
