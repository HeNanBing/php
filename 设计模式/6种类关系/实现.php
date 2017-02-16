<?php
/**
 * Created by PhpStorm.
 * User: nan
 * Date: 2017/2/16
 * Time: 19:35
 */
//实现关系（Implementation），主要用来规定接口和实现类的关系。
//接口（包括抽象类）是方法的集合，在实现关系中，类实现了接口，类中的方法实现了接口声明的所有方法。
//例如：汽车和轮船都是交通工具，而交通工具只是一个可移动工具的抽象概念，船和车实现了具体移动的功能。

interface Vehicle1 {
    public function run();
}

class Car implements Vehicle1 {
    public $name = '汽车';
    public function run() {
        return $this->name.'在路上行驶';
    }
}

class Ship implements Vehicle1 {
    public $name = '轮船';
    public function run() {
        return $this->name.'在海上航行';
    }
}

$car = new Car();
echo $car->run();