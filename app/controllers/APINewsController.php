<?php

class APINewsController extends BaseController {
    /*
      |
      |
      |
     */

    public function checkAuthorization($hash, $id) {

        $sqlstr = "SELECT `id` FROM apiusers WHERE `id`='" . $id . "' AND `hash`='" . $hash . "';";
        $results = DB::select($sqlstr);
        if (!empty($results)) {
            $user = APIUser::find($results[0]->id);
            if ($user->hash == $hash) {
                $time = time();
                $logtime = 60*60;
                $chektime = $time - $user->time;
                if($chektime < $logtime){
                    return true;
                } else {
                    return false;
                }
            }
            return false;
        }
        return false;
    }

    /**
     * 
     * This method add in result mass all news for json return
     * 
     * @return json
     * 
     */
    public function allNews() {

        $hash = Input::json('hash');
        $id = Input::json('id');
        if ($this->checkAuthorization($hash, $id)) {
            $news = News::all();

            foreach ($news as $new) {
                $data1[] = array(
                    'id' => $new->id,
                    'title' => $new->title,
                    'rubric_id' => $new->rubric_id,
                    'author' => $new->author,
                    'description' => $new->description,
                );
            }
            $data = array(
                'success' => true,
                'data' => $data1
            );
            return Response::json($data);
        } else {
            $data = array(
                'success' => FALSE,
                'message' => 'You mast first autorisation!'
            );
            return Response::json($data);
        }
    }

    /**
     * method returns sought by id news
     * 
     * @param Integer $id news
     * @return json return result
     */
    public function oneNews() {

        $hash = Input::json('hash');
        $id = Input::json('id');
        $news_id = Input::json('news_id');

        if ($this->checkAuthorization($hash, $id)) {
            try {
                $news = News::find($news_id);
                if (!empty($news)) {
                    $data1[] = array(
                        'id' => $news->id,
                        'title' => $news->title,
                        'rubric_id' => $news->rubric_id,
                        'author' => $news->author,
                        'description' => $news->description,
                    );
                    $data = array(
                        'success' => true,
                        'data' => $data1
                    );
                    return Response::json($data);
                } else {
                    $data[] = array(
                        'success' => FALSE,
                        'message' => 'This news not found!'
                    );
                    return Response::json($data);
                }
            } catch (Throws $e) {
                $data[] = array(
                    'success' => FALSE,
                    'message' => 'This news not found!'
                );
                return Response::json($data);
            }
        } else {
            $data = array(
                'success' => FALSE,
                'message' => 'You mast first autorisation!'
            );
            return Response::json($data);
        }
    }

    /**
     * This method change news by id news
     * @param Integer $id change News
     * @return json
     */
    public function changeNews() {

        $hash = Input::json('hash');
        //return Response::json($hash);

        $user_id = Input::json('user_id');
        //return Response::json($user_id);

        $title = Input::json('title');
        //return Response::json($title);

        $news_id = Input::json('news_id');
        //return Response::json($news_id);

        $author = Input::json('author');
        //return Response::json($author);

        $description = Input::json('description');
        //return Response::json($description);


        if ($this->checkAuthorization($hash, $id)) {
            if (!empty($title) && !empty($author) && !empty($description) && !empty($news_id)) {
                $news = News::find($news_id);
                $news->title = $title;
                $news->author = $author;
                $news->description = $description;
                $temp = $news->save();
                if ($temp) {
                    $data[] = array(
                        'success' => true,
                        'message' => 'You changes add in this NEWS'
                    );
                    return Response::json($data);
                } else {
                    $data[] = array(
                        'success' => false,
                        'message' => 'You changes NOT add in this NEWS'
                    );
                    return Response::json($data);
                }
            } else {
                $data[] = array(
                    'success' => false,
                    'message' => 'You send not corekt information!!'
                );
                return Response::json($data);
            }
        } else {
            $data = array(
                'success' => FALSE,
                'message' => 'You mast first autorisation!'
            );
            return Response::json($data);
        }
    }

    /**
     * This method delete news by id news
     * @param Integer $id delete News
     * @return json
     */
    public function deteteNews() {

        $hash = Input::json('hash');
        //return Response::json($hash);

        $user_id = Input::json('user_id');
        //return Response::json($user_id);

        $news_id = Input::json('news_id');


        if ($this->checkAuthorization($hash, $user_id)) {
            $news = News::find($news_id);
            //return Response::json($news);

            if (!empty($news)) {
                $temp = $news->delete();

                if ($temp) {
                    $data[] = array(
                        'success' => true,
                        'message' => 'You news delete'
                    );
                    return Response::json($data);
                } else {
                    $data[] = array(
                        'success' => FALSE,
                        'message' => 'You news NOT delete'
                    );
                    return Response::json($data);
                }
            } else {
                $data[] = array(
                    'success' => FALSE,
                    'message' => 'This news not found!'
                );
                return Response::json($data);
            }
        } else {
            $data = array(
                'success' => FALSE,
                'message' => 'You mast first autorisation!'
            );
            return Response::json($data);
        }
    }

    /**
     * method searches for text news
     * 
     * @param String $name
     * @return json
     */
    public function searchNews() {

        $hash = Input::json('hash');
        $user_id = Input::json('user_id');
        $name = Input::json('text');
        
        if ($this->checkAuthorization($hash, $user_id)) {
            $sqlstr = "SELECT * FROM news WHERE title LIKE '%" . $name . "%' OR description LIKE '%" . $name . "%' ;";
            try {
                $results = DB::select($sqlstr);
                if (!empty($results)) {
                    $data[] = array(
                        'success' => true,
                        'data' => $results
                    );
                    return Response::json($data);
                } else {
                    $data[] = array(
                        'success' => false,
                        'message' => 'You request not get any result!!!'
                    );
                    return Response::json($data);
                }
            } catch (Throws $e) {
                $data[] = array(
                    'success' => false,
                    'message' => 'You search failed! Some problem in DataBase!!'
                );
                return Response::json($data);
            }
        } else {
            $data[] = array(
                    'success' => false,
                    'message' => 'You mast authorisation!!'
                );
                return Response::json($data);
        }
        
    }

    /**
     * method searches for tag news and reviews
     * 
     * @return json
     */
    public function tagSearchNews() {

        $hash = Input::json('hash');

        $user_id = Input::json('user_id');

        $tag = Input::json('tag');

        if ($this->checkAuthorization($hash, $user_id)) {
            if (!empty($tag)) {
                $sqlstr = "SELECT id FROM tag WHERE tag_text LIKE '%" . $tag . "%';";
                $results = DB::select($sqlstr);
                $razNews = array();
                $razReview = array();
                foreach ($results as $res) {
                    $tag = Tag::find($res->id);
                    $tags = $tag->news;
                    foreach ($tags as $news) {
                        $promMassNews = array(
                            'id' => $news->id,
                            'rubric_id' => $news->rubric_id,
                            'title' => $news->title,
                            'author' => $news->author,
                            'description' => $news->description,
                        );
                        $razNews[] = $promMassNews;
                    }
                }
                foreach ($results as $res) {
                    $tag = Tag::find($res->id);
                    $tags = $tag->review;
                    foreach ($tags as $review) {
                        $promMassNews = array(
                            'id' => $review->id,
                            'rubric_id' => $review->rubric_id,
                            'title' => $review->title,
                            'author' => $review->author,
                            'description' => $review->description,
                        );
                        $razReview[] = $promMassNews;
                    }
                }

                if (empty($razNews) && empty($razReview)) {

                    $resultsMass[] = array(
                        'success' => false,
                        'message' => 'You search no given result!',
                    );

                    return Response::json($resultsMass);
                } else {
                    if (empty($razNews) && !empty($razReview)) {
                        $resultsMass[] = array(
                            'success' => true,
                            'review' => $razReview,
                        );

                        return Response::json($resultsMass);
                    }

                    if (empty($razReview) && !empty($razNews)) {
                        $resultsMass[] = array(
                            'success' => true,
                            'news' => $razNews,
                        );

                        return Response::json($resultsMass);
                    }
                    $resultsMass[] = array(
                        'success' => true,
                        'news' => $razNews,
                        'review' => $razReview,
                    );
                    return Response::json($resultsMass);
                }
            } else {
                $resultsMass[] = array(
                    'success' => false,
                    'message' => 'You send not corect invormation!!!',
                );
                return Response::json($resultsMass);
            }
        } else {
            $data[] = array(
                'success' => false,
                'message' => 'You mast authorisation!!'
            );
            return Response::json($data);
        }
    }

    /**
     * Method create new News in BD
     * 
     * @return json
     */
    public function createNews() {
        $hash = Input::json('hash');
        //return Response::json($hash);

        $user_id = Input::json('user_id');

        $news_id = Input::json('news_id');
        $title = Input::json('title');
        //$rubric_id = Input::json('rubric_id');
        $author = Input::json('author');
        $description = Input::json('description');

        if ($this->checkAuthorization($hash, $user_id)) {

            $validator = Validator::make(
                            array(
                        'title' => $title,
                        'author' => $author,
                        'description' => $description,
                            ), array(
                        'title' => 'required',
                        'author' => 'required',
                        'description' => 'required'
                            )
            );

            if ($validator->fails()) {
                $data[] = array(
                    'success' => false,
                    'message' => 'You send not corekt information!!'
                );
                return Response::json($data);
            } else {
                $news = new News();
                $news->title = $title;
                $news->author = $author;
                $news->description = $description;

                try {
                    DB::transaction(function() use ($news) {
                        $news->save();
                    });
                } catch (\PDOException $e) {
                    $data[] = array(
                        'success' => false,
                        'message' => 'TRANSACTION FAILED!!!'
                    );
                    return Response::json($data);
                }
                $data[] = array(
                    'success' => true,
                    'message' => 'You news create !'
                );
                return Response::json($data);
            }
        }
    }

}
