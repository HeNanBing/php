<?php
/**
 * Created by PhpStorm.
 * User: nan
 * Date: 2017/2/16
 * Time: 19:47
 */

//关联关系（Association）：表示一个类的属性保存了对另一个类的一个实例（或多个实例）的引用。
//关联关系是类与类之间最常用的一种关系，表示一类对象与另一类对象之间有联系。组合、聚合也属于关联关系，只是关联关系的类间关系比其他两种要弱。
//关联关系有四种：双向关联、单向关联、自关联、多重数关联。
//例如：汽车和司机，一辆汽车对应特定的司机，一个司机也可以开多辆车。

class Driver {
    public $cars = array();
    public function addCar(Car $car) {
        $this->cars[] = $car;
    }
}

class Car {
    public $drivers = array();
    public function addDriver(Driver $driver) {
        $this->drivers[] = $driver;
    }
}

$jack = new Driver();
$line1 = new Car();
$jack->addCar($line1);
$line1->addDriver($jack);
print_r($jack);