<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>add new news</title>
</head>
<body>
<?php echo View::make('Link'); ?>
    <?php
            $select_review_value = array();
            foreach ($review as $item){
                $select_review_value[] = $item->id;
                $select_review_value[] = $item->title;
                
            }
            
            $select_tag_value = array();
            foreach($tag as $item){
                $select_tag_value[] = $item->id;
                $select_tag_value[] = $item->tag_text;
            }
    
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

    <?php echo Form::open(array('url' => 'change-news', 'method' => 'post')); 
    ?>  
        <?php
        if(!empty($error_title)){
            echo '<div class="error">'.$error_title.'</div>';
        }    
        ?>
        <div><?php echo "Title: ".Form::text('title',$title); ?></div>
        <?php
        if(!empty($error_author)){
            echo '<div class="error">'.$error_author.'</div>';
        }    
        ?>
        <div><?php echo "Author: ".Form::text('author',$author); ?></div>
        <div><?php echo Form::hidden('id',$id); ?></div>
        <?php
        if(!empty($error_description)){
            echo '<div class="error">'.$error_description.'</div>';
        }    
        ?> 
        <div><?php echo "Description: ".Form::textarea('description',$description); ?></div>
      <?php
        if(!empty($error_rubric_id)){
            echo '<div class="error">'.$error_rubric_id.'</div>';
        }    
        ?>  
        <div><?php echo "Rubric: ".Form::select('rubric_id', $select_array,array($rubric_id, $rubric_id)); ?></div>
        <?php
        if(!empty($error_review)){
            echo '<div class="error">'.$error_review.'</div>';
        }    
        ?>  
        <div><?php echo "Choose review for this news: ".Form::select("review[]", $select_review, $select_review_value, array('multiple')); ?></div>
        <?php
        if(!empty($error_tag)){
            echo '<div class="error">'.$error_tag.'</div>';
        }
        ?>  
        <div><?php echo "Choose tag for this news: ".Form::select("tag[]", $select_tag,  $select_tag_value, array('multiple')); ?></div>
            
        <div><?php echo Form::submit('Change News'); ?></div>
    
    <?php echo Form::close(); ?>
        
</body>
</html>
