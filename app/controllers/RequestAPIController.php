<?php

class RequestAPIController extends BaseController {
    /*
      |-------------------------------------------------------------------------
      | RequestAPIController
      |-------------------------------------------------------------------------
      |
      |Controller is designed to work with the external API to search for news 
      |on the ID, the text in the title and description, search for news and 
      |reviews on the tag, call the search result display otbrazhenie all the 
      |news and every bit of news for her ID, change kokretno news on her ID
      | and adding news removal news on ID,
      |
      |
      |
      |
      |
     */
    
    /**
     * Method is used to display all the news
     * 
     * @return view
     * returns a list of news or reference error api
     */
    public function showAllNews() {
        
        $url = Config::get('curl.allnews');
        $data = $this->_makeAPIRequest($url,"GET");

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

    /**
     * method is intended for display on a form 
     * to search for news on the text in the 
     * title and description
     * 
     * @return view
     */
    public function formSearchNews() {
        
        return View::make('getSearchAPINews');
        
    }
    
    
    /**
     * 
     * method is intended for display
     *  on a form to search for news
     *  and reviews by tag
     * 
     * 
     * @return view     
     */

    public function formSearchNewsAndReview() {
        
        return View::make('getSearchAPINewsAndReview');
        
    }

    
    /**
     * Method shows a list of news that 
     * were found on the text in the title 
     * or description, or the message that 
     * the news was not found
     * 
     * 
     * @return view return result search news
     */
    public function showSearchNews() {
        
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

            $data = $this->_makeAPIRequest($url,"GET");

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

    /**
     * Method shows a list of news and reviews 
     * that have been found on the tag or a message
     *  that the news or reviews were found
     * 
     * @return view display the desired news and reviews
     */
    public function showSearchNewsAndReview() {
        
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

            $data = $this->_makeAPIRequest($url,"GET");

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
    
    /**
     * This method show displey one news
     * 
     * @param Integer $id  it ID displays news
     * @return view
     */
    public function displayOneNews($id) {

        $url = Config::get('curl.onenews') . $id;
        $data = $this->_makeAPIRequest($url,"GET");

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

    /**
     * This method is intended to remove the news.
     * Input parameter has ID, news and method returns the
     * result of successful or not successful removal news
     * 
     * @param Integer $id ID removable news
     * @return View returns the result of the removal news
     */
    public function removalNews($id) {
        
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
    
    
    /**
     * Method returns the form with initial parameters news you want to change
     * 
     * @param Integer $id it ID news you want to change
     * @param boolean $success reports on the success of changes
     * @param String $message reports made ​​any changes or what error occurred while trying to change news
     * @return view Returns form changes with the corresponding message
     */
    
    public function formMakeChanges($id, $success = false, $message = NULL) {

        $url = Config::get('curl.onenews') . $id;
        $data = $this->_makeAPIRequest($url,"GET");

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
    
    
    /**
     * This method saves the news on its id and returns the result display (error or success)
     * 
     * @param Integer $id is id the news you want to save changes
     * @return type
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
            $url = 'change-news-api/' . $id;
            return Redirect::to($url)->withErrors($validator);
        } else {
            $url = Config::get('curl.change') . $id;
            $data = array(
                "title" => $title,
                "author" => $author,
                "description" => $description
            );

            $result = $this->_makeAPIRequest($url,"POST", $data);

            if ($result['success']) {
                foreach ($result['data'] as $value) {
                    $success = $value->success;
                    $message = $value->message;
                }

                if ($success) {
                    return $this->formMakeChanges($id, $success);
                } else {
                    return $this->formMakeChanges($id, $success, $message);
                }
            } else {
                $news = array(
                    "error" => $data['message']
                );
                return View::make('getErrorApi', $news);
            }
        }
    }

    /**
     * Method of displaying the form of creating news
     * 
     * @param boolean $success parametr success add news
     * @param string $message message for false success add news
     * @return view
     */
    
    
    public function formCreatingNews($success = false, $message = NULL) {
        $news = array(
            'success' => $success,
            'message' => $message
        );
        return View::make('getCreateAPINewsForm', $news);
    }
    
    /**
     * method of adding news api if successful news is added, otherwise it returns the error display
     * 
     * @return View 
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
            $url = Config::get('curl.create');
            $data = array(
                "title" => $title,
                "author" => $author,
                "description" => $description
            );

            $result = $this->_makeAPIRequest($url,"POST", $data);

            if ($result['success']) {

                foreach ($result['data'] as $value) {
                    $success = $value->success;
                    $message = $value->message;
                }
                if ($success) {
                    return $this->formCreatingNews($success);
                } else {
                    return $this->formCreatingNews($success, $message);
                }
            } else {
                $news = array(
                    "error" => $data['message']
                );
                return View::make('getErrorApi', $news);
            }
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
    
    
    protected function _makeAPIRequest($url,$method, $data=NULL) {
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        if($method == "POST"){
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


}
