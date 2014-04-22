<?php      $url = URL::route('ajax-change');     ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>AJAX add new news</title>
             <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
             <script src="/js/ajax-change.js"></script>

    
</head>
<body>
{{View::make('Link');}}
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

      ?>

    {{Form::open(array('url' => 'ajax-change-news/'.$id, 'method' => 'post','id'=>'ajax_form')); }}
        <div id="error_title"></div>
        <div>{{"Title: ".Form::text('title',$title,array('id'=>'title'));}}</div>
        
        <div id="error_author"></div>
        <div>{{"Author: ".Form::text('author',$author,array('id'=>'author'));}}</div>
        <div>{{Form::hidden('id',$id);}}</div>
        
        <div id="error_description"></div>
        <div>{{"Description: ".Form::textarea('description',$description,array('id'=>'description'));}}</div>
     
        <div>{{ "Rubric: ".Form::select('rubric_id', $select_array,array($rubric_id, $rubric_id),array('id'=>'rubric_id'));}}</div>
        
        <div id="error_review"></div>
        <div>{{"Choose review for this news: ".Form::select("review[]", $select_review, $select_review_value, array('multiple','id'=>'review'));}}</div>
       
        <div id="error_tag"></div>
        <div>{{"Choose tag for this news: ".Form::select("tag[]", $select_tag,  $select_tag_value, array('multiple','id'=>'tag'));}}</div>
            
        <div><button type="button" onclick="SendRequest();">Change news</button></div>
    
        {{Form::close();}}
        <div id="loader"></div>
        <div id="rezult"></div>
        
        
        
        
</body>
</html>
