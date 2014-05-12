<?php

class APIAuthComtroller extends BaseController {

    /**
     * This method show displey log ih form
     * 
     * @return \Illuminate\View\View
     */
    public function apiloginForm() {
        return View::make('apiloginForm');
    }

    /**
     * This method show displey log ih form
     * 
     * @return \Illuminate\View\View
     */
    public function apiregistrationForm() {
        return View::make('apiregistrationForm');
    }

    public function logout() {
        //Cookie::clearResolvedInstances();
        //Cookie::forget('userID');
        //Cookie::forget('userHASH');
        //Cookie::unqueue('userID');
        //Cookie::unqueue('userHASH');
        Cookie::queue('userHASH', 0);
        Cookie::queue('userID', 0);

        return Redirect::to('api-login');
    }

    /**
     * Method produces a registered user and 
     * notifies the appropriate registration status
     * 
     * @return \Illuminate\View\View
     */
    public function registration() {
        $password = Input::get('password');
        $username = Input::get('username');
        $email = Input::get('email');
        $validator = Validator::make(
                        array(
                    'password' => $password,
                    'username' => $username,
                    'email' => $email,
                        ), array(
                    'email' => 'required|email',
                    'password' => 'required|alphaNum|min:3',
                    'username' => 'required'
                        )
        );

        if ($validator->fails()) {
            return Redirect::to('api-registration')
                            ->withErrors($validator);
        } else {
            $data = array(
                "password" => $password,
                "username" => $username,
                "email" => $email
            );
            $url = 'http://test1.com/api.test1.api-registration';
            $result = $this->_makeAPIRequest($url, "POST", $data);

            if ($result['success']) {
                if ($result['data']->success) {
                    return Redirect::to('api-login');
                } else {
                    $error = array(
                        'error' => $result['data']->message
                    );
                    return Redirect::to('api-registration')
                                    ->withErrors($error);
                }
            } else {
                $error = array(
                    'error' => 'Some problem!'
                );
                return Redirect::to('api-registration')
                                ->withErrors($error);
            }
        }
    }

    /**
     * Method coupled with api sending login and password 
     * received by post to verify the existence Users
     * 
     * @return \Illuminate\View\View return result log in users in system
     */
    public function login() {
        $password = Input::get('password');
        $username = Input::get('username');
        $remember = Input::get('remember-me');
        //return $remember;
        $validator = Validator::make(
                        array(
                    'password' => $password,
                    'username' => $username,
                        ), array(
                    'password' => 'required',
                    'username' => 'required'
                        )
        );
        if ($validator->fails()) {
            return Redirect::to('api-login')
                            ->withErrors($validator);
        } else {
            $data = array(
                'username' => $username,
                'password' => $password
            );
            $url = 'http://test1.com/api.test1.api-login';

            $result = $this->_makeAPIRequest($url, "POST", $data);
            if ($result['success']) {
                if ($result['data']->success) {
                    if ($remember) {
                        Cookie::forever('userHASH', $result['data']->hash);
                        Cookie::forever('userID', $result['data']->id);
                        return Redirect::to('/');
                    } else {
                        //Cookie::make('userHASH', $result['data']->hash, 10);
                        //Cookie::make('userID', $result['data']->id, 10);
                        Cookie::queue('userHASH', $result['data']->hash);
                        Cookie::queue('userID', $result['data']->id);
                        return Redirect::to('/');
                    }
                } else {
                    $error = array(
                        'error' => 'Some problem!'
                    );
                    return Redirect::to('api-login')
                                    ->withErrors($error);
                }
            } else {
                $error = array(
                    'error' => 'Some problem!'
                );
                return Redirect::to('api-login')
                                ->withErrors($error);
            }

            //return $result;
        }
    }

    /**
     * 
     * This method to access the api for return specific information
     * 
     * @param string $url resource circulation
     * @param string $method set the method of transmission POST or GET
     * @param array $data an array of parameters to pass to API 
     * @return array result array from request to API   
     * 
     *      
     */
    protected function _makeAPIRequest($url, $method, $data = NULL) {

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($method == "POST") {
            $data_string = json_encode($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
            );
        }
        $curl_exec = curl_exec($ch);
        if ($curl_exec === false) {
            $result = array(
                'success' => false,
                'message' => curl_error($ch)
            );
        } else {
            $json_decode = json_decode($curl_exec);
            switch (json_last_error()) {
                case JSON_ERROR_NONE:
                    $result = array(
                        'success' => true,
                        'data' => $json_decode
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
     * Method is used to display all the news
     * 
     * @return \Illuminate\View\View 
     * returns a list of news or reference error api
     */
    public function showAllNews() {

        $url = 'http://test1.com/api.test1.api/news';
        $hash = Cookie::get('userHASH');
        $id = Cookie::get('userID');
        if (empty($hash)) {
            $hash = 0;
        }

        if (empty($id)) {
            $id = 0;
        }

        $news = array(
            'hash' => $hash,
            'id' => $id
        );
        $data = $this->_makeAPIRequest($url, "POST", $news);

        if ($data['success']) {
            if ($data['data']->success) {
                $news = array(
                    'news' => $data['data']->data
                );
                return View::make('APIallNews', $news);
            } else {
                $news = array(
                    "error" => $data['data']->message
                );
                return View::make('getErrorApi', $news);
            }
        } else {
            $news = array(
                "error" => $data['message']
            );
            return View::make('getErrorApi', $news);
        }
    }

    /**
     * This method show displey one news
     * 
     * @param Integer $id  it ID displays news
     * @return \Illuminate\View\View 
     */
    public function displayOneNews($news_id) {

        $url = 'http://test1.com/api.test1.api/one-news';
        $hash = Cookie::get('userHASH');
        $id = Cookie::get('userID');
        if (empty($hash)) {
            $hash = 0;
        }

        if (empty($id)) {
            $id = 0;
        }

        $news = array(
            'hash' => $hash,
            'id' => $id,
            'news_id' => $news_id->id,
        );
        $data = $this->_makeAPIRequest($url, "POST", $news);

        if ($data['success']) {
            if ($data['data']->success) {
                foreach ($data['data']->data as $value) {
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
                    "error" => $data['data']->message
                );
                return View::make('getErrorApi', $news);
            }
        } else {
            $news = array(
                "error" => $data['message']
            );
            return View::make('getErrorApi', $news);
        }
    }

    /**
     * This method allows you to view news for changes
     * 
     * @param Object $news
     * @return \Illuminate\View\View
     */
    public function getChangeNewsForm($news_id) {

        $url = 'http://test1.com/api.test1.api/one-news';
        $hash = Cookie::get('userHASH');
        $id = Cookie::get('userID');
        if (empty($hash)) {
            $hash = 0;
        }

        if (empty($id)) {
            $id = 0;
        }

        $news = array(
            'hash' => $hash,
            'id' => $id,
            'news_id' => $news_id->id,
        );
        $data = $this->_makeAPIRequest($url, "POST", $news);
        //print_r($data);
        if ($data['success']) {
            if ($data['data']->success) {
                foreach ($data['data']->data as $value) {
                    $news = array(
                        "id" => $value->id,
                        "title" => $value->title,
                        "description" => $value->description,
                        "author" => $value->author,
                    );
                }
                return View::make('APIchangeNews', $news);
            } else {
                $news = array(
                    "error" => $data['data']->message
                );
                return View::make('APIchangeNews', $news);
            }
        } else {
            $news = array(
                "error" => $data['message']
            );

            //return View::make('APIchangeNews');
        }
    }

    /**
     * This method saves the news on its id and returns the result display (error or success)
     * 
     * @param Integer $id is id the news you want to save changes
     * @return \Illuminate\View\View 
     */
    public function savingChangesNews($id) {

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
            $url = 'api-change-news/' . $id;
            return Redirect::to($url)->withErrors($validator);
        } else {
            $url = 'http://test1.com/api.test1.api/news/change';
            $hash = Cookie::get('userHASH');
            $user_id = Cookie::get('userID');
            if (empty($hash)) {
                $hash = 0;
            }

            if (empty($user_id)) {
                $user_id = 0;
            }
            $data = array(
                "title" => $title,
                "author" => $author,
                'description' => $description,
                'hash' => $hash,
                'user_id' => $user_id,
                'news_id' => $id->id,
            );

            $result = $this->_makeAPIRequest($url, "POST", $data);

            if ($result['success']) {
                if ($result['data'][0]->success) {
                    $message = array(
                        "error" => $result['data'][0]->message
                    );
                    $url = 'api-change-news/' . $id->id;
                    return Redirect::to($url)->withErrors($message);
                }
            } else {
                $message = array(
                    "error" => $data['message']
                );
                return Redirect::to($url)->withErrors($message);
            }
        }
    }

    /**
     * This method is intended to remove the news.
     * Input parameter has ID, news and method returns the
     * result of successful or not successful removal news
     * 
     * @param Integer $id ID removable news
     * @return \Illuminate\View\View  returns the result of the removal news
     */
    public function removalNews($news) {

        $url = 'http://test1.com/api.test1.api/news/delete';
        $hash = Cookie::get('userHASH');
        $user_id = Cookie::get('userID');
        if (empty($hash)) {
            $hash = 0;
        }

        if (empty($user_id)) {
            $user_id = 0;
        }
        $data = array(
            'hash' => $hash,
            'user_id' => $user_id,
            'news_id' => $news->id,
        );

        $result = $this->_makeAPIRequest($url, "POST", $data);

        if ($result['success']) {
            if ($result['data'][0]->success) {
                $news = array(
                    "success" => false,
                    "message" => $result['data'][0]->message,
                );
                return View::make('getResultDelete', $news);
            }
        } else {
            $news = array(
                "success" => false,
                "message" => "Some problem",
            );
            return View::make('getResultDelete', $news);
        }
    }

    /**
     * Method show create news form
     * 
     * 
     * @return \Illuminate\View\View
     */
    public function createNewsForm() {
        return View::make('APIcreateNewsForm');
    }

    /**
     * method of adding news api if successful news is added, otherwise it returns the error display
     * 
     * @return \Illuminate\View\View 
     */
    public function addingCreatedNews() {

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

            $url = 'http://test1.com/api.test1.api/news/create';
            $hash = Cookie::get('userHASH');
            $user_id = Cookie::get('userID');
            if (empty($hash)) {
                $hash = 0;
            }

            if (empty($user_id)) {
                $user_id = 0;
            }

            $data = array(
                "title" => $title,
                "author" => $author,
                'description' => $description,
                'hash' => $hash,
                'user_id' => $user_id
            );

            $result = $this->_makeAPIRequest($url, "POST", $data);

            print_r($result);



            if ($result['success']) {
                if ($result['data'][0]->success) {
                    $message = array(
                        "error" => $result['data'][0]->message
                    );
                    return Redirect::to('http://test1.com/api-create-news')->withErrors($message);
                } else {
                    $message = array(
                        "error" => $result['data'][0]->message
                    );
                    return Redirect::to('http://test1.com/api-create-news')->withErrors($message);
                }
            } else {

                $message = array(
                    "error" => "Some problem"
                );
                return Redirect::to('http://test1.com/api-create-news')->withErrors($message);
            }
        }
    }

    /**
     * method is intended for display on a form 
     * to search for news on the text in the 
     * title and description
     * 
     * @return \Illuminate\View\View 
     */
    public function formSearchNews() {
        return View::make('APIsearchNews');
    }

    /**
     * method is intended for display on a form 
     * to search for news and reviews on the tag  
     * 
     * 
     * @return \Illuminate\View\View 
     */
    public function formTagSearchNews() {
        return View::make('APItagSearchNews');
    }

    /**
     * This method displays the search result in the
     *  title and text descriptions of news
     * 
     * @return \Illuminate\View\View
     */
    public function showSerchNews() {
        $text_search = Input::get('text_search');
        $validator = Validator::make(
                        array(
                    'text_search' => $text_search
                        ), array(
                    'text_search' => 'required'
                        )
        );

        if ($validator->fails()) {
            return Redirect::to('api-search-news')->withErrors($validator);
        } else {

            $url = 'http://test1.com/api.test1.api/news/search';
            $hash = Cookie::get('userHASH');
            $user_id = Cookie::get('userID');
            if (empty($hash)) {
                $hash = 0;
            }

            if (empty($user_id)) {
                $user_id = 0;
            }

            $data = array(
                "text" => $text_search,
                'hash' => $hash,
                'user_id' => $user_id
            );
            $result = $this->_makeAPIRequest($url, "POST", $data);

            if ($result['success']) {
                if ($result['data'][0]->success) {
                    $news = array(
                        "success" => true,
                        "news" => $result['data'][0]->data
                    );
                    return View::make('getShowSearchAPINews', $news);
                } else {
                    $news = array(
                        "error" => $result['data'][0]->message
                    );
                    return Redirect::to('api-search-news')->withErrors($news);
                }
            } else {

                $news = array(
                    "error" => $result['message']
                );
                return Redirect::to('api-search-news')->withErrors($news);
            }
        }
    }

    /**
     * This method displays the search results news and reviews by tag
     * 
     * 
     * @return \Illuminate\View\View
     */
    public function showTagSerchNews() {
        $tag = Input::get('tag');
        $validator = Validator::make(
                        array(
                    'tag' => $tag
                        ), array(
                    'tag' => 'required'
                        )
        );

        if ($validator->fails()) {
            return Redirect::to('api-tag-search-news')->withErrors($validator);
        } else {

            $url = 'http://test1.com/api.test1.api/news/tag-search';
            $hash = Cookie::get('userHASH');
            $user_id = Cookie::get('userID');
            if (empty($hash)) {
                $hash = 0;
            }

            if (empty($user_id)) {
                $user_id = 0;
            }

            $data = array(
                "tag" => $tag,
                'hash' => $hash,
                'user_id' => $user_id
            );
            $result = $this->_makeAPIRequest($url, "POST", $data);

            if ($result['success']) {
                if ($result['data'][0]->success) {
                    $news = $result['data'][0]->news;
                    $review = $result['data'][0]->review;

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
                    $news = array(
                        "error" => $result['data'][0]->message
                    );
                    return Redirect::to('api-tag-search-news')->withErrors($news);
                }
            } else {
                $news = array(
                    "error" => $result['message']
                );
                return Redirect::to('api-tag-search-news')->withErrors($news);
            }
        }
    }

}
