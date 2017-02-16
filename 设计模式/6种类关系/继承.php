<?php
/**
 * Created by PhpStorm.
 * User: nan
 * Date: 2017/2/16
 * Time: 19:29
 */

//继承关系，也称为泛化关系，用于描述父类与子类之间的关系。父类又称为基类，子类又称为派生类。
//继承关系中，子类继承父类的所有功能，父类所具有的属性、方法，子类应该都有。子类中除了与父类一致的信息以外，还包括额外的信息。
//例如：公交车、出租车和小轿车都是汽车，他们都有名称，并且都能在路上行驶。

class Car {
    public $name;
    public function run() {
        return '在行驶中';
    }
}

class Bus extends Car {
    public function __construct() {
        $this->name = '公交车';
    }
}

class Taxi extends Car {
    function __construct()
    {
        $this->name = '出租车';
    }
}

$line2 = new Bus;
echo $line2->name.$line2->run();