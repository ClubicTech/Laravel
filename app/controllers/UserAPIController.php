<?php

class UserAPIController extends BaseController {

    /**
     * This method registration users
     * 
     * @return json return json string add state and appropriate message
     */
    public function registration() {
        $email = Input::json('email');
        $password = Input::json('password');
        $username = Input::json('username');

        $validator = Validator::make(
                        array(
                    'email' => $email,
                    'password' => $password,
                    'username' => $username
                        ), array(
                    'email' => 'required|email',
                    'password' => 'required|alphaNum|min:3',
                    'username' => 'required'
                        )
        );
        if ($validator->fails()) {
            $data = array(
                'success' => FALSE,
                'message' => 'You mast filled all fields!!'
            );
            return Response::json($data);
        } else {
            $sqlstr = "SELECT * FROM apiusers WHERE username='" . $username . "';";
            $results = DB::select($sqlstr);
            if (!empty($results)) {
                $data = array(
                    'success' => FALSE,
                    'message' => 'This user name registration'
                );
                return Response::json($data);
            } else {

                $password2 = md5($password) . "TanGo21";
                $safepassword = md5($password2);
                $user = new APIUser();
                $user->password = $safepassword;
                $user->username = $username;
                $user->email = $email;

                try {
                    DB::transaction(function() use ($user) {
                        $user->save();
                    });
                } catch (\PDOException $e) {
                    $data = array(
                        'success' => FALSE,
                        'message' => 'Some transaction problem!!'
                    );
                    return Response::json($data);
                }
                $data = array(
                    'success' => TRUE,
                    'data' => 'You ragistration success!'
                );
                return Response::json($data);
            }
        }
    }

    /**
     * Method log in users
     * 
     * @return json return json string log in state and appropriate data
     */
    public function login() {

        $password = Input::json('password');
        $username = Input::json('username');
        $validator = Validator::make(
                        array(
                    'password' => $password,
                    'username' => $username
                        ), array(
                    'password' => 'required|alphaNum|min:3',
                    'username' => 'required'
                        )
        );

        if ($validator->fails()) {
            $data = array(
                'success' => FALSE,
                'message' => 'You mast filled all fields!!'
            );
            return Response::json($data);
        } else {



            $password2 = md5($password) . "TanGo21";
            $safepassword = md5($password2);

            $sqlstr = "SELECT `id` FROM apiusers WHERE `username`='" . $username . "' AND `password`='" . $safepassword . "';";

            $results = DB::select($sqlstr);

            $user = APIUser::find($results[0]->id);


            $user->hash = Hash::make($this->generateCode(8));
            $user->time = time();

            try {
                DB::transaction(function() use ($user) {
                    $user->save();
                });
            } catch (\PDOException $e) {
                $data = array(
                    'success' => FALSE,
                    'message' => 'Some transaction problem!!'
                );
                return Response::json($data);
            }
            $data = array(
                'success' => TRUE,
                'id' => $user->id,
                'hash' => $user->hash,
                    //'time' => $user->time
            );
            return Response::json($data);
        }
    }

    /**
     * Method generation code for HASH
     * 
     * @param Integer length generate code 
     * @return string
     */
    public function generateCode($length = 6) {

        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";

        $code = "";

        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0, $clen)];
        }

        return $code;
    }

    /**
     * 
     *
     *  @return boolean
     */
    public function isLogged() {

        $hash = Input::json('hash');
        $id = Input::json('id');

        //$sqlstr = "SELECT `id` FROM apiusers WHERE `id`='" . $id . "' AND `hash`='" . $hash . "';";

        $data = array(
            'success' => FALSE,
        );

        //$results = DB::select($sqlstr);
        $user = APIUser::find($id);
        if (!empty($user)) {
            //$user = APIUser::find($results[0]->id);
            if ($user->hash == $hash) {
                $time = time();
                $logtime = 60 * 60;
                $chektime = $time - $user->time;
                if ($chektime < $logtime) {
                    //return true;
                    $data = array(
                        'success' => TRUE,
                    );
                    return Response::json($data);
                } else {
                    return Response::json($data);
                }
            }
            return Response::json($data);
        }
        return Response::json($data);
    }

    /**
     * 
     */
    public function logout() {
        $hash = Input::json('hash');
        $id = Input::json('id');
        $data = array(
            'success' => FALSE,
        );

        $user = APIUser::find($id);

        if (!empty($user)) {
            $user->hash = '0';
            $user->time = '0';
            $user->save();
            $data = array(
                'success' => TRUE,
            );
            return Response::json($data);
        }
        return Response::json($data);
    }

}
