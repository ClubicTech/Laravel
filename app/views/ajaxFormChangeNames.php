<?php      $url = URL::route('ajax-change');     ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>AJAX add new news</title>
            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
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
                    url:'<?php echo $url; ?>',
                    type:'POST',
                    data: msg,
                    beforeSend:function () {
                        document.getElementById('loader').innerHTML="send.....";
                    },
                    success: function(res) {
                        document.getElementById('rezult').innerHTML=res;
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

    <?php echo Form::open(array('url' => 'ajax-change-news/'.$id, 'method' => 'post','id'=>'ajax_form')); 
    ?>  
        <div id="error_title"></div>
        <div><?php echo "Title: ".Form::text('title',$title,array('id'=>'title')); ?></div>
        
        <div id="error_author"></div>
        <div><?php echo "Author: ".Form::text('author',$author,array('id'=>'author')); ?></div>
        <div><?php echo Form::hidden('id',$id); ?></div>
        
        <div id="error_description"></div>
        <div><?php echo "Description: ".Form::textarea('description',$description,array('id'=>'description')); ?></div>
     
        <div><?php echo "Rubric: ".Form::select('rubric_id', $select_array,array($rubric_id, $rubric_id),array('id'=>'rubric_id')); ?></div>
        
        <div id="error_review"></div>
        <div><?php echo "Choose review for this news: ".Form::select("review[]", $select_review, $select_review_value, array('multiple','id'=>'review')); ?></div>
       
        <div id="error_tag"></div>
        <div><?php echo "Choose tag for this news: ".Form::select("tag[]", $select_tag,  $select_tag_value, array('multiple','id'=>'tag')); ?></div>
            
        <div><button type="button" onclick="SendRequest();">Change news</button></div>
    
    <?php echo Form::close(); ?>
        <div id="loader"></div>
        <div id="rezult"></div>
        
        
        
        
</body>
</html>
