<?php

/**
 * 抽象工厂模式  abstract + interface
 *
 * 抽象方法:1.不能被实例化   2.子继承必须实现所有抽象方法   3.访问控制比抽象类宽松
 */

interface shape{
    const fang = 'fang';
    const yuan = 'yuan';
    public function draw();
}

class yuan implements shape{
    public function draw() {
        // TODO: Implement draw() method.
        echo 'yuan===';
    }
}

class fang implements  shape {
    public function draw() {
        // TODO: Implement draw() method.
        var_dump('1111');
     echo 'fang====';
    }
}

interface color{
    const red = 'red';
    const yellow = 'yellow';
    public function pain();
}

class red implements color{
    public function pain() {
        // TODO: Implement pain() method.
        echo 'red';
    }
}

class yellow implements color {
    public function pain() {
        // TODO: Implement pain() method.
    echo 'yellow';
    }
}

//抽象工厂类
abstract class abstractFactory{
    protected  $typeColor = 'color';
    protected  $typeShape = 'shape';
    abstract function getColor($color);
    abstract function getShape($shape);
}

class obj extends abstractFactory {
    public function getColor($color) {
        // TODO: Implement getColor() method.
        if($color == color::red){
            return new red();
        }
        if($color == color::yellow){
            return new yellow();
        }
    }
    
    public function getShape($shape) {
        // TODO: Implement getShape() method.
        if($shape == shape::fang){
            return new fang();
        }
        if($shape == $shape::yuan){
            return new yuan();
        }
    }
    
}

$obj = new obj();
$shapeFactory = $obj->getShape(Shape::fang);
$shapeFactory->draw();
