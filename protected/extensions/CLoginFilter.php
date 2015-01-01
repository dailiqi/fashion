<?php

class CLoginFilter extends CFilter {
    protected function preFilter($filterChain) {

        //下面的代码支持手机端的用户验证
        if($_GET['serial']) {
            $param['serial'] = $_GET['serial'];
        }
        if($_POST['serial']) {
            $param['serial'] = $_POST['serial'];
        }
        if(!$param['serial']) {
            throw new Exception('未能获取用户登录信息。', 1);
        }
        try {
            $user = User::model()->find('serial=:serial', array('serial' => $param['serial']));
            if($user) {
                LoginPage::$user = $user;
                return true;
            } else {
                if(isset($param['serial'])) {
                    echo json_encode(array(
                        'error_no' => 1,
                        'error_message' => '会话失效，为了您的账号安全请重新登录'
                    ));
                }
                return false;
            }
        } catch(Exception $e) {
            //下面的代码支持手机端的未登录情况，或登录失效
            if($param['serial']) {
                $retm['error_no'] = 1;
                $retm['error_message'] = "会话失效，为了您的账号安全请重新登录";
                return $retm;
            }
            return false;
        }
    }

    protected function postFilter($filterChain) {
    }
}