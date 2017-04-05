<?php

/**
 * 单例模式   private static 不能被外部实例化  不能被克隆
 *
 * 单例类不能实例化
 * 单例类不能被克隆
 * 只能有一个实例
 */
class singleObj{
    const a = 'love';
    private static $instance;
    
    private function __construct() {
    }
    
    public static function getInstance(){
        if(!(self::$instance instanceof self)){
            self::$instance = new singleObj();
        }
        return self::$instance;
    }
    
    public function __clone() {
        trigger_error('single obj cant clone',E_USER_ERROR);
    }
    
}

$obj = singleObj::getInstance();
$obj2 = clone $obj;
var_dump($obj2::a);
var_dump($obj::a);