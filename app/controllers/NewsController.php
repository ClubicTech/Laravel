<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NewsController extends BaseController {
    /*
      |
      |
      |
     */

    public function viewNews() {
        return View::make('viewNewsList');
    }

    public function getJSONNews() {
        $news = News::all();
        foreach ($news as $new) {
            $data[] = array(
                'id' => $new->id,
                'title' => $new->title,
                'rubric_id' => $new->rubric_id,
                'author' => $new->author,
                'description' => $new->description,
            );
        }

        return Response::json($data);
    }

        
    public function getOneJSONNews($id) {

        try {
            $news = News::find($id);
            if (!empty($news)) {
                $data[] = array(
                    'id' => $news->id,
                    'title' => $news->title,
                    'rubric_id' => $news->rubric_id,
                    'author' => $news->author,
                    'description' => $news->description,
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
    }

    public function deteteJSONNews($id) {
        $news = News::find($id);
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
    }

  public function changeJSONNews($id) {

        $title = Input::json('title');
        $author = Input::json('author');
        $description = Input::json('description');


        if (!empty($title) && !empty($author) && !empty($description)) {
            $news = News::find($id);
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
    }

    public function searchJSONNews($name) {

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
    }

   public function searchJSONNewsTag($tag) {
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
    }


    public function createJSONNews() {

        $title = Input::json('title');
        //$rubric_id = Input::json('rubric_id');
        $author = Input::json('author');
        $description = Input::json('description');

        $validator = Validator::make(
                        array(
                    'title' => $title,
                    //'rubric_id' => $rubric_id,
                    'author' => $author,
                    'description' => $description,
                        ), array(
                    'title' => 'required',
                   // 'rubric_id' => 'required',
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
            //$news->rubric_id = $rubric_id;
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

    public function formAddNews() {

        $rubric = Rubric::all();
        foreach ($rubric as $rubrics) {
            $select_array[$rubrics->id] = $rubrics->name;
        }

        $review = Review::all();
        foreach ($review as $reviews) {
            $select_review[$reviews->id] = $reviews->title;
        }

        $tag = Tag::all();
        foreach ($tag as $tags) {
            $select_tag[$tags->id] = $tags->tag_text;
        }
        $inform = array('select_array' => $select_array,
            'select_review' => $select_review,
            'select_tag' => $select_tag
        );
        return View::make('formAddNews', $inform);
    }

    public static function getViewsOneNews($news) {

        $news1 = array(
            'id' => $news->id,
            'rubric_id' => $news->rubric_id,
            'title' => $news->title,
            'description' => $news->description,
            'author' => $news->author
        );
        return View::make('viewOneNews', $news1);
    }

    public function addNews() {

        $validator = Validator::make(
                        array(
                    'title' => Input::get('title'),
                    'rubric_id' => Input::get('rubric_id'),
                    'tag' => Input::get('tag'),
                    'author' => Input::get('author'),
                    'description' => Input::get('description'),
                    'review' => Input::get('review')
                        ), array(
                    'title' => 'required',
                    'rubric_id' => 'required',
                    'tag' => 'required',
                    'author' => 'required',
                    'description' => 'required',
                    'review' => 'required'
                        )
        );
        if ($validator->fails()) {
            return Redirect::to('add-news')->withErrors($validator);
        } else {
            $tag = Input::get('tag');
            $review = Input::get('review');

            $news = new News();
            $news->title = Input::get('title');
            $news->rubric_id = Input::get('rubric_id');
            $news->author = Input::get('author');
            $news->description = Input::get('description');
            try {
                DB::transaction(function() use ($news, $tag, $review) {
                    $news->save();
                    $news->saveTag($tag);
                    $news->saveReview($review);
                });
            } catch (\PDOException $e) {
                return View::make('viewNOTSuccessAddNews');
            }

            return View::make('viewSuccessAddNews');
        }
    }

    public function listDeleteNews() {
        return View::make('listDeleteNews');
    }

    public function deleteNews() {
        $delete_news = Input::get('delete_news');
        foreach ($delete_news as $key => $value_id_News) {
            $ObDeleteNews = News::find($value_id_News);
            $ObDeleteNews->delete();
        }

        return View::make('deleteNews');
    }

    public static function changeNews($news) {
        $review = Review::all();
        $select_review = array();
        foreach ($review as $reviews) {
            $select_review[$reviews->id] = $reviews->title;
        }
        $tag = Tag::all();
        $select_tag = array();
        foreach ($tag as $tags) {
            $select_tag[$tags->id] = $tags->tag_text;
        }


        $rubric = Rubric::all();
        $select_array = array();
        foreach ($rubric as $rubrics) {
            $select_array[$rubrics->id] = $rubrics->name;
        }

        foreach ($news->review as $item) {
            $select_review_value[] = $item->id;
            $select_review_value[] = $item->title;
        }

        foreach ($news->tag as $item) {
            $select_tag_value[] = $item->id;
            $select_tag_value[] = $item->tag_text;
        }

        $newNews = array('news' => $news,
            'select_review' => $select_review,
            'select_tag' => $select_tag,
            'select_array' => $select_array,
            'select_review_value' => $select_review_value,
            'select_tag_value' => $select_tag_value
        );

        return View::make('formChangeNews', $newNews);
    }

    public static function addChangeNews() {

        $id = Input::get('id');
        $validator = Validator::make(
                        array(
                    'title' => Input::get('title'),
                    'rubric_id' => Input::get('rubric_id'),
                    'tag' => Input::get('tag'),
                    'author' => Input::get('author'),
                    'description' => Input::get('description'),
                    'review' => Input::get('review')
                        ), array(
                    'title' => 'required',
                    'rubric_id' => 'required',
                    'tag' => 'required',
                    'author' => 'required',
                    'description' => 'required',
                    'review' => 'required'
                        )
        );
        if ($validator->fails()) {
            $url = 'change-news/' . $id;
            return Redirect::to($url)->withErrors($validator);
        } else {
            $tag = Input::get('tag');
            $review = Input::get('review');

            $news = News::find($id);
            $news->title = Input::get('title');
            $news->rubric_id = Input::get('rubric_id');
            $news->author = Input::get('author');
            $news->description = Input::get('description');
            $news->save();
            $news->saveTag($tag);
            $news->saveReview($review);
            return View::make('viewSuccessChangeNews');
        }
    }

}
