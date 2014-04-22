 <!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>AJAX</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    <script type="text/javascript" src="app/javascript/jquery.json-1.3.js"></script>
    <script type="text/javascript" src="javascript/jquery.json-1.3.js"></script>
    <script type="text/javascript">
       function SendRequest(){
        
        
            var send_flag = true;
            var title = document.getElementById('title').value;
            if(title.replace(/\s+/g, '').length) {
            } else {
              document.getElementById('error_title').innerHTML = "Please enter title";
              send_flag = false;
            }
//--------------------------------------------------------------------------------------------------            
            var author = document.getElementById('author').value;
            if(author.replace(/\s+/g, '').length) {
            } else {
              document.getElementById('error_author').innerHTML = "Please enter author";
              send_flag = false;
            }
//--------------------------------------------------------------------------------------------------
            var description = document.getElementById('description').value;
            if(description.replace(/\s+/g, '').length) {
            } else {
              document.getElementById('error_description').innerHTML = "Please enter description";
              send_flag = false;
            }
//--------------------------------------------------------------------------------------------------
            var rubric_id = document.getElementById('rubric_id').value;
            if(rubric_id.replace(/\s+/g, '').length) {
            } else {
              document.getElementById('error_rubric_id').innerHTML = "Please enter rubric_id";
              send_flag = false;
            }
//--------------------------------------------------------------------------------------------------
            var review = document.getElementById('review').value;
            if(review.replace(/\s+/g, '').length) {
            } else {
              document.getElementById('error_review').innerHTML = "Please enter review";
              send_flag = false;
            }
//--------------------------------------------------------------------------------------------------
            var tag = document.getElementById('tag').value;
            if(tag.replace(/\s+/g, '').length) {
            } else {
              document.getElementById('error_tag').innerHTML = "Please enter tag";
              send_flag = false;
            }
            var msg   = $('#ajax_form').serialize();
            
           if(send_flag){
                $.ajax({
                    url:'ajax-add-news',
                    type:'POST',
                    data: msg,
                    beforeSend:function () {
                        document.getElementById('loader').innerHTML="send.....";
                    },
                    success: function(res) {
                        document.getElementById('loader').innerHTML=res;
                    }
                });
            }
            return false;
        }
        
    </script>
    
    </head>
    <body>

<?php echo View::make('Link'); ?>
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

    <?php echo Form::open(array('url' => 'ajax-add-news', 'method' => 'post','id'=>'ajax_form')); 
    ?>  
        <div id="error_title"></div>
        <div><?php echo "Title: ".Form::text('title','',array('id'=>'title')); ?></div>
<!--         Subject: <input type="text" size="10" id="title" name="title" /><br>-->
      
        <div id="error_author"></div> 
        <div><?php echo "Author: ".Form::text('author','',array('id'=>'author')); ?></div>
        
        <div id="error_description"></div>
        <div><?php echo "Description: ".Form::textarea('description','',array('id'=>'description')); ?></div>
   
        <div id="error_rubric_id"></div>
        <div><?php echo "Rubric: ".Form::select('rubric_id', $select_array, array('', ''), array('id'=>'rubric_id')); ?></div>
    
        <div id="error_review"></div>
        <div><?php echo "Choose review for this news: ".Form::select("review[]", $select_review,  array('', ''), array('multiple','id'=>'review')); ?></div>
        
        <div id="error_tag"></div>
        <div><?php echo "Choose tag for this news: ".Form::select("tag[]", $select_tag,  array('', ''), array('multiple','id'=>'tag')); ?></div>
            
        <div><button type="button" onclick="SendRequest();">Add News</button></div>
    
    <?php echo Form::close(); ?>
        <div id="loader"></div>
</body>
</html>
