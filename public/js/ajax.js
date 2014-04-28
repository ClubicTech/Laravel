/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


 function SendRequest(url){
        
        
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
                    url: url,
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
        