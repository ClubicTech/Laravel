<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>add new news</title>
</head>
<body>
{{View::make('Link');}}
    <?php
      $rubric =  Rubric::all();      
      $select_array = array();
      foreach ($rubric as $rubrics){
              $select_array[$rubrics->id] = $rubrics->name; 
      }
      
      $review = Review::all();  
      $select_review = array();
      foreach ($review as $reviews){
              $select_review[$reviews->id] = $reviews->title; 
      }
      
      $tag = Tag::all();  
      $select_tag = array();
      foreach ($tag as $tags){
              $select_tag[$tags->id] = $tags->tag_text; 
      }

        $error_title = $errors->first('title');        
        $error_author = $errors->first('author');        
        $error_description = $errors->first('description');        
        $error_rubric_id = $errors->first('rubric_id');        
        $error_review = $errors->first('review');  
        $error_tag = $errors->first('tag');  
      
    ?>

    {{Form::open(array('url' => 'add-news', 'method' => 'post'))}}
        <?php
        if(!empty($error_title)){
            echo '<div class="error">'.$error_title.'</div>';
        }    
        ?>
        <div>{{"Title: ".Form::text('title');}}</div>
        <?php
        if(!empty($error_author)){
            echo '<div class="error">'.$error_author.'</div>';
        }    
        ?>
        <div>{{"Author: ".Form::text('author');}}</div>
        <?php
        if(!empty($error_description)){
            echo '<div class="error">'.$error_description.'</div>';
        }    
        ?> 
        <div>{{"Description: ".Form::textarea('description');}}</div>
      <?php
        if(!empty($error_rubric_id)){
            echo '<div class="error">'.$error_rubric_id.'</div>';
        }    
        ?>  
        <div>{{"Rubric: ".Form::select('rubric_id', $select_array);}}</div>
        <?php
        if(!empty($error_review)){
            echo '<div class="error">'.$error_review.'</div>';
        }    
        ?>  
        <div>{{"Choose review for this news: ".Form::select("review[]", $select_review,  array('', ''), array('multiple'));}}</div>
        <?php
        if(!empty($error_tag)){
            echo '<div class="error">'.$error_tag.'</div>';
        }
        ?>  
        <div>{{"Choose tag for this news: ".Form::select("tag[]", $select_tag,  array('', ''), array('multiple'));}}</div>
            
        <div>{{Form::submit('Add News'); }}</div>
    
    {{Form::close();}}
        
</body>
</html>
