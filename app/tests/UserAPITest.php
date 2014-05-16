<?php

class UserAPITest extends TestCase {
    
    private static $hash;
    private static $id;


    public function testRegistrationUser(){
        $data = array(
            'username' => "MAX2",
            'password' => "MAX2",
            'email' => "max@ukr.net"
        );
        $user = json_encode($data);
        $crawler = $this->call('POST', 'api.test1.api-registration', array(), array(), array('Accept: application/json', 'Content-Type: application/json'), $user);
        $this->assertEquals('{"success":false,"message":"This user name registration"}', $crawler->getContent());
        
    }
    
    public function testLoginUser(){
        $data = array(
            'username' => "maxim",
            'password' => "maxim",
        );
        $user = json_encode($data);
        $crawler = $this->call('POST', 'api.test1.api-login', array(), array(), array('Accept: application/json', 'Content-Type: application/json'), $user);
        $data = $crawler->getContent();
        $data = json_decode($data);
        UserAPITest::$hash = $data->hash;      
        UserAPITest::$id = $data->id;      
        $str = array(
            'success' => true,
            'id' => $data->id,
            'hash' => $data->hash,
        );
        $user = json_encode($str);
        $this->assertEquals($user, $crawler->getContent());
        
        
    }
    
    
    public function testIsLoggedUser(){
        
        $data = array(
            'hash' =>  UserAPITest::$hash,
            'id' => UserAPITest::$id
        );
        $user = json_encode($data);
        $crawler = $this->call('POST', 'api.test1.api-islogged', array(), array(), array('Accept: application/json', 'Content-Type: application/json'), $user);
        $result = $crawler->getContent();
        $result = json_decode($result,true);
        
        $this->assertEquals(1, $result["success"]);
        
    }
    
    
    public function testLogOutUser(){

        $data = array(
            'hash' => UserAPITest::$hash,
            'id' => UserAPITest::$id
        );
        $user = json_encode($data);
        $str = '{"success":false}';
        $crawler = $this->call('POST', 'api.test1.api-logout', array(), array(), array('Accept: application/json', 'Content-Type: application/json'), $user);
        $result = $crawler->getContent();
        $result = json_decode($result,true);
        
        $this->assertEquals(1, $result["success"]);
    }

}
