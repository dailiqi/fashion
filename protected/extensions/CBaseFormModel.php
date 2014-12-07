<?php
abstract class CBaseFormModel extends CFormModel{
    public $post_array=array();
    public $get_array=array();
    public $cookie_array=array();
    public function build_data(){
        foreach($this->get_array as $key){
            if(property_exists(get_class($this),$key)){
                if(isset($_GET[$key]))
                    $this->$key=$_GET[$key];
            }
        }
      

        foreach($this->post_array as $key){
            if(property_exists(get_class($this),$key)){
                if(isset($_POST[$key]))
                    $this->$key=$_POST[$key];
            }
        }

        foreach($this->cookie_array as $key){
            if(property_exists(get_class($this),$key)){
                if($_COOKIE[$key])
                    $this->$key=$_COOKIE[$key];
            }
        }        

        //这个从cookie取 这里mock掉
        //$this->session_key="aaaa";

        $ret=$this->validate();

        if($ret==false){
            $errors=$this->getErrors();
            $message="";
            foreach($errors as $key=>$error){
                $message.=$key." => ".implode(";",$error);
            }
            throw new Exception($message,1);
        }
    }
    public function execute() {
        $this->build_data();
        return $this->_execute();
    }
    abstract protected function _execute();
}
