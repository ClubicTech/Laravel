<?php

class AuthController extends BaseController {

    /**
     * 
     * Methot show log in form
     * 
     * @return \Illuminate\View\View 
     */
    public function getLogin() {
        return View::make('loginform');
    }

    /**
     * Log Out method
     * 
     * @return \Illuminate\View\View
     */
    public function logout() {
        Auth::logout();
        return Redirect::to('login');
    }

    /**
     * Mathot show registration form
     * @return \Illuminate\View\View 
     */
    public function registrationForm() {
        return View::make('registrationForm');
    }

    /**
     * 
     * Method registration user in data base
     * 
     * @return \Illuminate\View\View 
     */
    public function registrationUser() {

        $email = Input::get('email');
        $password = Input::get('password');
        $username = Input::get('username');
        $name = Input::get('name');
        $lastname = Input::get('lastname');

        $validator = Validator::make(
                        array(
                    'email' => $email,
                    'password' => $password,
                    'username' => $username,
                    'name' => $name,
                    'lastname' => $lastname
                        ), array(
                    'email' => 'required|email',
                    'password' => 'required|alphaNum|min:3',
                    'username' => 'required',
                    'name' => 'required',
                    'lastname' => 'required'
                        )
        );


        if ($validator->fails()) {
            return Redirect::to('registration')
                            ->withErrors($validator);
        } else {

            $sqlstr = "SELECT * FROM users WHERE username='" . $username . "';";
            $results = DB::select($sqlstr);

            if (!empty($results)) {
                $return = array(
                    'issetusername' => true,
                    'varningmessage' => "This user name ".$username." registred !!",
                    'email' => $email,
                    'password' => $password,
                    'username' => $username,
                    'name' => $name,
                    'lastname' => $lastname,
                );
                return View::make('registrationForm',$return);
            } else {
                $user = new User;
                $user->password = Hash::make($password);
                $user->username = $username;
                $user->name = $name;
                $user->lastname = $lastname;
                $user->email = $email;
                try {
                    DB::transaction(function() use ($user) {
                        $user->save();
                    });
                } catch (\PDOException $e) {
                    return View::make('viewNOTSuccessAddNews');
                }
                Auth::login($user);
                return Redirect::to('login');
            }
        }
    }

    /**
     * Method set log in uset if it exists
     * 
     * @return \Illuminate\View\View
     */
    public function setLogin() {

        $password = Input::get('password');
        $username = Input::get('username');
        $remember = Input::get('remember-me');
        if ($remember) {
            $remember_me = true;
        } else {
            $remember_me = false;
        }
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
            return Redirect::to('login')
                            ->withErrors($validator);
        } else {
            $userdata = array(
                'username' => $username,
                'password' => $password
            );

            if (Auth::attempt($userdata, $remember_me)) {
                return Redirect::to('/');
            } else {
                return Redirect::to('login');
            }
        }
    }

    /**
     * The method returns the user input validation
     * 
     * @return boolean 
     */
    public static function getLoginUser(){
        return Auth::check();
    }
    
}
