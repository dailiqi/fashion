<?php

class BaseUtil {
    public static $weixinUinfo = null;

    /**
     * 校验微信code是否合法
     * @param $param
     * @return bool
     */
    public static function verifyWeixinCode(array $param){
        return isset($param["code"]) && preg_match("/^\w{32}$/",$param["code"]);
    }

    /**
     * 校验open_id来源是否为微信
     * @param $param
     * @return bool
     */
    public static function verifyFromWeixin(array $param){
        if(isset($param["state"])){
            $from = $param["state"];
            if($from == "from_weixin_read" || $from == "from_weixin_server" || $from == "from_weixin"){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }


    /**
     * 通过微信获取uinfo信息
     * @param $param
     * @return array|bool
     */
    public static function getWeixinUinfo($param){
        if(self::verifyWeixinCode($param)){
            $accessUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?'.
                'appid='.ConstWeixin::SERVICE_APPID.
                '&secret='.ConstWeixin::SERVICE_SECRET.
                '&code='.$param['code'].
                '&grant_type=authorization_code';
            $accessInfo = json_decode(HttpProxy::getInstance()->get($accessUrl),true);
            if(!isset($accessInfo["errcode"])){
                $getUinfoUrl = 'https://api.weixin.qq.com/sns/userinfo?'.
                    'access_token='.$accessInfo["access_token"].
                    '&openid='.$accessInfo["openid"];
                $uinfo = json_decode(HttpProxy::getInstance()->get($getUinfoUrl),true);
                $uinfo["open_id"] = $uinfo["openid"];
                return array_merge($accessInfo,$uinfo);
            }else{
                return false;
            }
        }else{
            return false;
        }
    }


    /**
     * user_id进行加密
     * @param $userId
     * @return string
     */
    public static  function encodeUserId($userId){
        $encodeMap = array(50,51,60,50,52,61,53,62,54,63,54,63,55,64,56,65,57,58,59,52);
        $userId = $userId."".$userId;
        $str = "";
        for($i=0;$i<strlen($userId);$i++){
            $c = $userId[$i];
            $code = ord($c) + $encodeMap[$i];
            $str.=chr($code);
        }
        return "1".$str;
    }

    /**
     * user_id解密
     * @param $userId
     * @return string
     */
    public static function decodeUserId($userId){
        $encodeMap = array(50,51,60,50,52,61,53,62,54,63,54,63,55,64,56,65,57,58,59,52);
        $userId=str_replace(" ","",$userId."");
        $str = "";
        if($userId[0] == '1'){
            $len = strlen($userId)-1;
            $userId = substr($userId,1,$len);
            for($i=0;$i<$len;$i++){
                $c = $userId[$i];
                $code = ord($c) - $encodeMap[$i];
                $str.=chr($code);
            }
            $count = round($len/2);
            $str1 = substr($str,0,$count);
            $str2 = substr($str,$count,$count);
            return $str1==$str2?$str1:"";
        }else{
            $len = strlen($userId);
            for($i=0;$i<$len;$i++){
                $c = $userId[$i];
                $code = ord($c) - 49;
                $str.=chr($code);
            }
        }
        return $str;
    }

//    public static  function encodeUserId($userId){
//        $userId = $userId."";
//        $str = "";
//        for($i=0;$i<strlen($userId);$i++){
//            $c = $userId[$i];
//            $code = ord($c) + 49;
//            $str.=chr($code);
//        }
//        return $str;
//    }
//
//
//    public static function decodeUserId($userId){
//        $userId=$userId."";
//        $str = "";
//        for($i=0;$i<strlen($userId);$i++){
//            $c = $userId[$i];
//            $code = ord($c) - 49;
//            $str.=chr($code);
//        }
//        return $str;
//    }

    /**
     *
     * @param $s
     * @param $n
     * @return int|string
     */
    public static function formatAmount($s,$n=2){
        if(!$s){
            return 0;
        }
        $n = $n >= 0 && $n <= 20 ? $n : 2;
        $s = round($s,$n);
        $s = $s."";
        $arr = explode(".",$s);
        $str = "";
        $arr1 = $arr[0];
        $len = strlen($arr1);
        for($i=$len-1,$j=1;$i>=0;$i--,$j++){
            $str=$arr1[$i].$str;
            if($j%3 == 0 && $j<$len){
                $str=','.$str;
            }
        }
        if(isset($arr[1])){
            $str.='.'.$arr[1];
        }
        return $str;
    }
}