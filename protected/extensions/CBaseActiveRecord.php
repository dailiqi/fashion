<?php
class CBaseActiveRecord extends CActiveRecord {
    protected $table_name = "";

    public function save($runValidation=true,$attributes=null) {
        $ret = parent::save($runValidation,$attributes);
        if(!$ret) {
            Yii_Log::fatal('数据库存储失败' . CJSON::encode($this), 90001);
            throw new Exception("数据库存储失败。", 1001);
        }
    }

    public function delete() {
        $ret = parent::delete();
        if(!$ret) {
            Yii_Log::fatal('数据库删除条目失败。' . CJSON::encode($this), 90002);
            throw new Exception("数据库删除条目失败。", 1002);
        }
    }

    public function tableName(){
        return $this->table_name;
    }

    //拼装查询的条件
    public static function assembleCondition($param=array()){
        $str = array();
        $arr = array();
        foreach($param as $k=>$v){
            if( !is_array($v)){
                $str[]=$k."=:".$k;
                $arr[$k] = $v;
            }else{
                $pre = key($v);
                $str[]=$k.$pre.":".$k;
                $arr[$k] = $v[$pre];
            }
        }
        return array(implode(" and ",$str),$arr);
    }
}
