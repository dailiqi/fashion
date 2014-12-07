<?php

/**
 * Created by PhpStorm.
 * User: rik
 * Date: 14-11-28
 * Time: 上午12:36
 */
class LoginPage extends CBaseFormModel {
    public $username;
    public $password;
    static $user;
    public function __construct() {
    }

    public $get_array = array(
        "username", "password",
    );

    public function rules() {
        return array(
            array("username, password", "required")
        );
    }
    public function _execute() {

        try {
            $user = User::model()->find('user_name=:username', array('username'=>$this->username));
            if(!$user) {
                throw new Exception('用户不存在',10002);
            }
            if($user->password != $this->hashPassword($this->password,$user->time)) {
                throw new Exception('用户密码错误',10003);
            }
            return array("error_no" => 0, 'data' => array('serial'=>$user->serial));
        } catch(Exception $e) {
            return array('error_no' => $e->getCode(), 'error_message' => $e->getMessage());
        }
    }
    private function hashPassword($password,$time) {
        return md5($password.$time);
    }
} 