<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Add new Review</title>
</head>
<body>
{{View::make('Link');}}
    <?php
      $rubric =  Rubric::all();      
      $select_array = array();
      foreach ($rubric as $rubrics){
              $select_array[$rubrics->id] = $rubrics->name; 
      }
      
      $new = News::all();  
      $select_review = array();
      foreach ($new as $news){
              $select_news[$news->id] = $news->title; 
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
        $error_news = $errors->first('news');  
        $error_tag = $errors->first('tag');  
      
    ?>

    {{Form::open(array('url' => 'add-review', 'method' => 'post'));}} 
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
        <div>{{"Author: ".Form::text('author'); }}</div>
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
        if(!empty($error_news)){
            echo '<div class="error">'.$error_news.'</div>';
        }    
        ?>  
        <div>{{"Choose news for this review: ".Form::select("news[]", $select_news,  array('', ''), array('multiple')); }}</div>
        <?php
        if(!empty($error_tag)){
            echo '<div class="error">'.$error_tag.'</div>';
        }
        ?>  
        <div>{{"Choose tag for this news: ".Form::select("tag[]", $select_tag,  array('', ''), array('multiple'));}}</div>
            
        <div>{{Form::submit('Add Review');}}</div>
    
    {{Form::close();}}
        
</body>
</html>
