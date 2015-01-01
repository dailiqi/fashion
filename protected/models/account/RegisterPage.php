<?php

/**
 * Created by PhpStorm.
 * User: rik
 * Date: 14-11-28
 * Time: 上午12:36
 */
class RegisterPage extends CBaseFormModel {
    public $username;
    public $password;

    public $get_array = array(
        "username", "password",
    );

    public function rules() {
        return array(
            array("username, password", "required"),
        );
    }

    public function _execute() {

        try {
            $user = User::model()->find('user_name=:username', array('username' => $this->username));
            if($user) {
                throw new Exception('用户已存在', 10001);
            }
            $user = new User();
            $user->user_name = $this->username;
            $user->time = time();
            $user->password = $this->hashPassword($this->password, $user->time);
            $user->serial = $this->createSerial($user->user_name, $user->time);
            $user->save();
            return array("error_no" => 0, 'data' => array('serial' => $user->serial));
        } catch(Exception $e) {
            return array('error_no' => $e->getCode(), 'error_message' => $e->getMessage());
        }
    }

    private function createSerial($username, $time) {
        return md5($username . $time);
    }

    private function hashPassword($password, $time) {
        return md5($password . $time);
    }
} 