<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>add new news</title>
</head>
<body>
{{View::make('Link');}}
    <?php
      $new = News::all();      
      $select_news = array();
      foreach ($new as $news){
              $select_news[$news->id] = $news->title; 
      }
      
      $review = Review::all();  
      $select_review = array();
      foreach ($review as $reviews){
              $select_review[$reviews->id] = $reviews->title; 
      }
        $tag_text = $errors->first('tag_text');          
        $error_review = $errors->first('review');  
        $error_news = $errors->first('news');  
      
    ?>

    {{Form::open(array('url' => 'add-tag', 'method' => 'post')); }}
        <?php
        if(!empty($tag_text)){
            echo '<br><br><br><div class="error">'.$tag_text.'</div>';
        }    
        ?>
        <div>{{"Tag text: ".Form::text('tag_text');}}</div>
        
        <?php
        if(!empty($error_review)){
            echo '<br><br><br><div class="error">'.$error_review.'</div>';
        }    
        ?>  
        <div>{{"Choose review for this news: ".Form::select("review[]", $select_review,  array('', ''), array('multiple')); }}</div>
        
        <?php
        if(!empty($error_news)){
            echo '<br><br><br><div class="error">'.$error_news.'</div>';
        }
        ?>  
        <div>{{"Choose news for this tag: ".Form::select("news[]", $select_news,  array('', ''), array('multiple')); }}</div>
            
        <div>{{Form::submit('Add Tag'); }}</div>
    
    {{Form::close();}}
        
</body>
</html>
