 <!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>AJAX</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    <script src="/js/ajax-add.js"></script>

    </head>



    <body>

{{View::make('Link'); }}
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
    ?>

    {{Form::open(array('url' => 'ajax-add-news', 'method' => 'post','id'=>'ajax_form'));}}
        <div id="error_title"></div>
        <div>{{"Title: ".Form::text('title','',array('id'=>'title'));}}</div>
<!--         Subject: <input type="text" size="10" id="title" name="title" /><br>-->
      
        <div id="error_author"></div> 
        <div>{{"Author: ".Form::text('author','',array('id'=>'author'));}}</div>
        
        <div id="error_description"></div>
        <div>{{"Description: ".Form::textarea('description','',array('id'=>'description'));}}</div>
   
        <div id="error_rubric_id"></div>
        <div>{{"Rubric: ".Form::select('rubric_id', $select_array, array('', ''), array('id'=>'rubric_id')); }}</div>
    
        <div id="error_review"></div>
        <div>{{"Choose review for this news: ".Form::select("review[]", $select_review,  array('', ''), array('multiple','id'=>'review'));}}</div>
        
        <div id="error_tag"></div>
        <div>{{"Choose tag for this news: ".Form::select("tag[]", $select_tag,  array('', ''), array('multiple','id'=>'tag'));}}</div>
            
        <div><button type="button" onclick="SendRequest();">Add News</button></div>
    
   {{Form::close();}}
        <div id="loader"></div>
</body>
</html>
