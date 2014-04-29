<?php

class RequestAPIController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Default Home Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::get('/', 'HomeController@showWelcome');
      |
     */

    public function getAllAPINews() {
        $ch = curl_init('http://test1.com/api.test1/news');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = json_decode(curl_exec($ch));
        curl_close($ch);
        $news = array(
            "news" => $data
        );
        return View::make('getAllAPINews', $news);
    }

    public function getSearchAPINews() {

        return View::make('getSearchAPINews');
    }

    public function getSearchAPINewsAndReview() {

        return View::make('getSearchAPINewsAndReview');
    }

    public function getShowSearchAPINews() {
        $text_search = Input::get('text_search');
        $validator = Validator::make(
                        array(
                    'text_search' => $text_search
                        ), array(
                    'text_search' => 'required'
                        )
        );
        if ($validator->fails()) {
            return Redirect::to('news-api-search')->withErrors($validator);
        } else {
            $url = 'http://test1.com/api.test1/news/search/' . $text_search;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $data = json_decode(curl_exec($ch));
            curl_close($ch);

            foreach ($data as $data1) {

                if ($data1->success) {
                    $news = array(
                        "success" => true,
                        "news" => $data1->data
                    );
                    return View::make('getShowSearchAPINews', $news);
                } else {
                    $news = array(
                        "success" => false,
                        "message" => $data1->message
                    );
                    return View::make('getShowSearchAPINews', $news);
                }
            }
        }
    }

    public function getShowSearchAPINewsAndReview() {
        $text_tag = Input::get('text_tag');
        $validator = Validator::make(
                        array(
                    'text_tag' => $text_tag
                        ), array(
                    'text_tag' => 'required'
                        )
        );
        if ($validator->fails()) {
            return Redirect::to('review-news-api-search')->withErrors($validator);
        } else {
            $url = 'http://test1.com/api.test1/news/tag/search/' . $text_tag;
            $ch = curl_init($url);
            //curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $data = json_decode(curl_exec($ch));
            curl_close($ch);
            $dates = array();
            foreach ($data as $data1) {
                $success = $data1->success;
                if ($success && !empty($success)) {
                    $news;
                    $review;
                    if (isset($data1->news)) {
                        $news = $data1->news;
                    }
                    if (isset($data1->review)) {
                        $review = $data1->review;
                    }


                    if (!empty($news) && !empty($review)) {
                        $dates = array(
                            "success" => true,
                            "success_news" => true,
                            "success_review" => true,
                            "news" => $news,
                            "review" => $review
                        );
                    }
                    if (empty($news) && !empty($review)) {
                        $dates = array(
                            "success" => true,
                            "success_news" => false,
                            "success_review" => true,
                            "review" => $review
                        );
                    }
                    if (!empty($news) && empty($review)) {
                        $dates = array(
                            "success" => true,
                            "success_news" => true,
                            "success_review" => false,
                            "news" => $news
                        );
                    }
                    return View::make('getShowSearchAPINewsAndReview', $dates);
                } else {
                    $dates = array(
                        "success" => false,
                        "message" => "You request no return result"
                    );
                    return View::make('getShowSearchAPINewsAndReview', $dates);
                }
            }
        }
    }

    public function getOneAPINews($id) {
        $url = 'http://test1.com/api.test1/news/' . $id;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = json_decode(curl_exec($ch));
        curl_close($ch);
        $news = array(
            "id" => $data
        );

        foreach ($data as $value) {
            $news = array(
                "id" => $value->id,
                "title" => $value->title,
                "description" => $value->description,
                "author" => $value->author,
            );
        }


        return View::make('getOneAPINews', $news);
    }


    public function getDeleteAPINews($id) {

        $url = 'http://test1.com/api.test1/news/delete/' . $id;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = json_decode(curl_exec($ch));
        curl_close($ch);
        foreach ($result as $value) {
            $news = array(
                "success" => $value->success,
                "message" => $value->message,
            );
        }
        return View::make('getResultDelete', $news);
    }



    public function getCheangeAPINews($id, $success = false, $message = NULL) {

        $url = 'http://test1.com/api.test1/news/' . $id;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = json_decode(curl_exec($ch));
        curl_close($ch);
        foreach ($data as $value) {
            $news = array(
                "id" => $value->id,
                "title" => $value->title,
                "description" => $value->description,
                "author" => $value->author,
                "success" => $success,
                "message" => $message,
            );
        }
        return View::make('getCheangeAPINews', $news);
    }

    public function getCheangeAPINewsADD($id) {
        $title = Input::get('title');
        $author = Input::get('author');
        $description = Input::get('description');

        $validator = Validator::make(
                        array(
                    'title' => $title,
                    'author' => $author,
                    'description' => $description
                        ), array(
                    'title' => 'required',
                    'author' => 'required',
                    'description' => 'required'
                        )
        );
        if ($validator->fails()) {
            $url = 'change-news-api/' . $id;
            return Redirect::to($url)->withErrors($validator);
        } else {
            $url = 'http://test1.com/api.test1/news/change/' . $id;
            $data = array(
                "title" => $title,
                "author" => $author,
                "description" => $description
            );

            $data_string = json_encode($data);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
            );

            $result = json_decode(curl_exec($ch));
            curl_close($ch);
            foreach ($result as $value) {
                $success = $value->success;
                $message = $value->message;
            }
            if ($success) {
                return $this->getCheangeAPINews($id, $success);
            } else {
                return $this->getCheangeAPINews($id, $success, $message);
            }
        }
    }

    public function getCreateAPINewsForm($success = false, $message = NULL) {
        $news = array(
            'success' => $success,
            'message' => $message
        );
        return View::make('getCreateAPINewsForm', $news);
    }

    public function getCreateAPINewsADD() {

        $title = Input::get('title');
        $author = Input::get('author');
        $description = Input::get('description');

        $validator = Validator::make(
                        array(
                    'title' => $title,
                    'author' => $author,
                    'description' => $description
                        ), array(
                    'title' => 'required',
                    'author' => 'required',
                    'description' => 'required'
                        )
        );
        if ($validator->fails()) {
            $url = 'create-news-api';
            return Redirect::to($url)->withErrors($validator);
        } else {
            $url = 'http://test1.com/api.test1/news/create';
            $data = array(
                "title" => $title,
                "author" => $author,
                "description" => $description
            );

            $data_string = json_encode($data);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
            );

            $result = $data = json_decode(curl_exec($ch));
            curl_close($ch);
            foreach ($result as $value) {
                $success = $value->success;
                $message = $value->message;
            }
            if ($success) {
                return $this->getCreateAPINewsForm($success);
            } else {
                return $this->getCreateAPINewsForm($success, $message);
            }
        }
    }

}
