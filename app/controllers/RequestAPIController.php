<?php

class RequestAPIController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | RequestAPIController
      |--------------------------------------------------------------------------
      |
      |
      |
      |
      |
      |
      |
     */

    public function getAllAPINews() {
        //$url = 'http://test1.com/api.test1/news';
        $url = Config::get('curl.allnews');

        $data = $this->getCurlGET($url);


        if ($data['success']) {
            $news = array(
                'news' => $data['data']
            );
            return View::make('getAllAPINews', $news);
        } else {
            $news = array(
                "error" => $data['message']
            );
            return View::make('getErrorApi', $news);
        }
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
            $url = Config::get('curl.search') . $text_search;

            $data = $this->getCurlGET($url);

            if ($data['success']) {
                foreach ($data['data'] as $data_value) {
                    if ($data_value->success) {
                        $news = array(
                            "success" => true,
                            "news" => $data_value->data
                        );
                        return View::make('getShowSearchAPINews', $news);
                    } else {
                        $news = array(
                            "success" => false,
                            "message" => $data_value->message
                        );
                        return View::make('getShowSearchAPINews', $news);
                    }
                }
            } else {
                $news = array(
                    "error" => $data['message']
                );
                return View::make('getErrorApi', $news);
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

            $url = Config::get('curl.tagsearch') . $text_tag;

            $data = $this->getCurlGET($url);

            if ($data['success']) {
                $dates = array();
                foreach ($data['data'] as $data1) {
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
            } else {
                $news = array(
                    "error" => $data['message']
                );
                return View::make('getErrorApi', $news);
            }
        }
    }

    public function getOneAPINews($id) {

        $url = Config::get('curl.onenews') . $id;
        $data = $this->getCurlGET($url);

        if ($data['success']) {
            foreach ($data['data'] as $value) {
                $news = array(
                    "id" => $value->id,
                    "title" => $value->title,
                    "description" => $value->description,
                    "author" => $value->author,
                );
            }
            return View::make('getOneAPINews', $news);
        } else {
            $news = array(
                "error" => $data['message']
            );
            return View::make('getErrorApi', $news);
        }
    }

    public function getDeleteAPINews($id) {
        
        $url = Config::get('curl.delete') . $id;
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

        $url = Config::get('curl.onenews') . $id;
        $data = $this->getCurlGET($url);

        if ($data['success']) {
            foreach ($data['data'] as $value) {
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
        } else {
            $news = array(
                "error" => $data['message']
            );
            return View::make('getErrorApi', $news);
        }
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
            $url = Config::get('curl.change') . $id;
            $data = array(
                "title" => $title,
                "author" => $author,
                "description" => $description
            );

            $result = $this->getCurlPost($url, $data);

            if ($result['success']) {
                foreach ($result['data'] as $value) {
                    $success = $value->success;
                    $message = $value->message;
                }

                if ($success) {
                    return $this->getCheangeAPINews($id, $success);
                } else {
                    return $this->getCheangeAPINews($id, $success, $message);
                }
            } else {
                $news = array(
                    "error" => $data['message']
                );
                return View::make('getErrorApi', $news);
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
            $url = Config::get('curl.create');
            $data = array(
                "title" => $title,
                "author" => $author,
                "description" => $description
            );

            $result = $this->getCurlPost($url, $data);

            if ($result['success']) {

                foreach ($result['data'] as $value) {
                    $success = $value->success;
                    $message = $value->message;
                }
                if ($success) {
                    return $this->getCreateAPINewsForm($success);
                } else {
                    return $this->getCreateAPINewsForm($success, $message);
                }
            } else {
                $news = array(
                    "error" => $data['message']
                );
                return View::make('getErrorApi', $news);
            }
        }
    }

    public function getCurlPOST($url, $data) {

        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );

        if (curl_exec($ch) === false) {
            $result = array(
                'success' => false,
                'message' => curl_error($ch)
            );
            curl_close($ch);
        } else {
            json_decode(curl_exec($ch));
            switch (json_last_error()) {
                case JSON_ERROR_NONE:
                    $result = array(
                        'success' => true,
                        'data' => json_decode(curl_exec($ch))
                    );
                    break;
                case JSON_ERROR_DEPTH:
                    $result = array(
                        'success' => false,
                        'message' => 'Достигнута максимальная глубина стека'
                    );
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $result = array(
                        'success' => false,
                        'message' => 'Некорректные разряды или не совпадение режимов'
                    );
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $result = array(
                        'success' => false,
                        'message' => 'Некорректный управляющий символ'
                    );
                    break;
                case JSON_ERROR_SYNTAX:
                    $result = array(
                        'success' => false,
                        'message' => 'Синтаксическая ошибка, не корректный JSON'
                    );
                    break;
                case JSON_ERROR_UTF8:
                    $result = array(
                        'success' => false,
                        'message' => 'Некорректные символы UTF-8, возможно неверная кодировка'
                    );
                    break;
                default:
                    $result = array(
                        'success' => false,
                        'message' => 'Неизвестная ошибка'
                    );
                    break;
            }
        }
        curl_close($ch);
        return $result;
    }

    
 /**
 * Removes "deny" restrictions from the ACL
 *
 * @param  Zend_Acl_Role_Interface|string|array     $roles
 * @param  Zend_Acl_Resource_Interface|string|array $resources
 * @param  string|array                             $privileges
 * @uses   Zend_Acl::setRule()
 * @return Zend_Acl Provides a fluent interface
 */
    
    public function getCurlGET($url) {

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (curl_exec($ch) === false) {
            $data = array(
                'success' => false,
                'message' => curl_error($ch)
            );
            curl_close($ch);
        } else {
            json_decode(curl_exec($ch));
            switch (json_last_error()) {
                case JSON_ERROR_NONE:
                    $data = array(
                        'success' => true,
                        'data' => json_decode(curl_exec($ch))
                    );
                    break;
                case JSON_ERROR_DEPTH:
                    $data = array(
                        'success' => false,
                        'message' => 'Достигнута максимальная глубина стека'
                    );
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $data = array(
                        'success' => false,
                        'message' => 'Некорректные разряды или не совпадение режимов'
                    );
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $data = array(
                        'success' => false,
                        'message' => 'Некорректный управляющий символ'
                    );
                    break;
                case JSON_ERROR_SYNTAX:
                    $data = array(
                        'success' => false,
                        'message' => 'Синтаксическая ошибка, не корректный JSON'
                    );
                    break;
                case JSON_ERROR_UTF8:
                    $data = array(
                        'success' => false,
                        'message' => 'Некорректные символы UTF-8, возможно неверная кодировка'
                    );
                    break;
                default:
                    $data = array(
                        'success' => false,
                        'message' => 'Неизвестная ошибка'
                    );
                    break;
            }
        }
        curl_close($ch);
        return $data;
    }

}
