<?php
class CAdminFilter extends CFilter {
	protected function preFilter($filterChain) {
		$adminList = array(
			);
		$param['session_key'] = $_COOKIE['session_key'];

		//下面的代码支持手机端的用户验证
		if($_POST['session_key']){
			$param['session_key'] = $_POST['session_key'];
		}

		$account_service = new AccountService();
		try {
			$ret = $account_service->is_login($param);
			if($ret && in_array($ret['user_name'], $adminList)) {
				return true;
			} else {
				Yii::app()->controller->redirect('');
				return false;
			}
		} catch(Exception $e) {
			Yii::app()->controller->redirect('');
			return false;
		}
	}

	protected function postFilter($filterChain) {
	}
}