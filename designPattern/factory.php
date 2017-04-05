<?php
/**
 * 工厂模式:  接口+多个实现+工厂类
 * 接口:1.可实现多个。   2.可定义接口常量
 */

//todo 接口,定义方法,接口常量
interface shape{
    const yuan = 'yuan';
    const fang = 'fang';
    public function draw();
}

class fang implements shape
{
    public function draw() {
       echo 'fang----';
    }
}

class yuan implements shape{
    public function draw() {
        // TODO: Implement draw() method.
        echo 'yuan------';
    }
}

//工厂类
class shapeFactory {
    public function getShapeObj($shapeStr){
        if(empty($shapeStr)){
            return '';
        }
        if($shapeStr==shape::yuan){
            return new yuan();
        }
        if($shapeStr==shape::fang){
            return new fang();
        }
    }
}


//工厂类调用

$factory = new shapeFactory();
$fangObj = $factory->getShapeObj(shape::fang);
$fangObj->draw();

$yuanObj = $factory->getShapeObj(shape::yuan);
$yuanObj->draw();

?>