<?php
/**
 * 自动化执行 命令行模式
 */
class TestCommand extends CConsoleCommand
{
    public function __construct(){
    }

    public function run($args) {

        echo DateUtil::getToday()."\n";
        echo DateUtil::getYesterday()."\n";
        echo time();
        echo date('Y-m-d');
        var_dump($args);
        echo date('H');

        

    }
}
