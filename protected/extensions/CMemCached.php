<?php
require_once "/usr/work/tool/conf/otherparams.php";
class CMemCached extends CMemCache{
    public $useMemcached=true;
    private $is_sasl=false;
    private $cache;
    public function init(){
        parent::init();
        $this->cache->setOption(Memcached::OPT_COMPRESSION, false); //关闭压缩功能
        $this->cache->setOption(Memcached::OPT_BINARY_PROTOCOL, true); //使用binary二进制协议
    }
        
    public function auth(){
        if($this->is_sasl==false){
            $ret=$this->cache->setSaslAuthData($g_ali_cache['name'], $g_ali_cache['passwd']); //设置OCS帐号密码进行鉴权 
            $this->is_sasl=true;
        }
    }   

    public function getMemCache(){
        $this->cache=parent::getMemCache();
        return $this->cache;
    }
 
    protected function getValue($key)
    {
        $this->auth();
        return parent::getValue($key);
    }
    
    protected function getValues($keys)
    {
        $this->auth();
        return parent::getValue($keys);
    }
    
    protected function setValue($key,$value,$expire){
        $this->auth();
        return parent::setValue($key,$value,$expire);
    }

    protected function addValue($key,$value,$expire){
        $this->auth();
        return parent::addValue($key,$value,$expire);
    }
    
    protected function deleteValue($key){
        $this->auth();
        return parent::deleteValue($key);
    }
    protected function flushValues(){
        $this->auth();
        return parent::flushValues();
    }
}


class CMemCachedServerConfiguration extends CComponent
{
    public $host;
    public $port=11211;
    public $persistent=true;
    public $weight=1;
    public $timeout=15;
    public $retryInterval=15;
    public $status=true;

    public function __construct($config)
    {
        if(is_array($config))
        {
            foreach($config as $key=>$value)
                $this->$key=$value;
            if($this->host===null)
                throw new CException(Yii::t('yii','CMemCache server configuration must have "host" value.'));
        }
        else
            throw new CException(Yii::t('yii','CMemCache server configuration must be an array.'));
    }
}


