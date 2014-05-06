                <a href="http://test1.com/registration">Registration</a><br>
                
                <a href="http://test1.com/login">Log In</a><br>
                
                <a href="http://test1.com/logout">Log Out</a><br>
                
                <a href="http://test1.com">Return to home?</a><br>
                
                <a href="http://test1.com/news" > Show news list </a><br>
                
                <a href="http://test1.com/review" > Show Reviews </a><br>
                
                <a href="http://test1.com/rubric" > Show Rubric </a><br>
                
                <a href="http://test1.com/tag" > Show Tag </a><br>
                
                <a href="http://test1.com/add-news" > Add News </a><br>
                
                <a href="http://test1.com/add-review" > Add Review </a><br>
 
                <?php if(AuthController::getLoginUser()){
                             echo '<a href="http://test1.com/create-news-api" > create-news-api </a><br>';
                             echo '<a href="http://test1.com/review-news-api-search" > review-news-api-search </a><br>';
                             echo '<a href="http://test1.com/news-api-search" > news-api-search </a><br>';
                             echo '<a href="http://test1.com/get-all-api-news" > get-all-api-news </a><br>';
                             echo '<a href="http://test1.com/ajax-add-news" > ajax-add-news</a><br>';
                             echo '<a href="http://test1.com/delete-review" > Delete Review</a><br>';
                             echo '<a href="http://test1.com/delete-news" > Delete News</a><br>';
                             echo '<a href="http://test1.com/add-tag" > Add Tag </a><br>';
                             echo '<a href="http://test1.com/add-rubric" > Add Rubric </a><br>';
                } ?>
                