<?php
/**
 * Created by PhpStorm.
 * User: nan
 * Date: 2017/2/16
 * Time: 19:50
 */
//依赖关系（Dependence）：假设A类的变化引起了B类的变化，则说名B类依赖于A类。
//大多数情况下，依赖关系体现在某个类的方法使用另一个类的对象作为参数。
//依赖关系是一种“使用”关系，特定事物的改变有可能会影响到使用该事物的其他事物，在需要表示一个事物使用另一个事物时使用依赖关系。
//例如：汽车依赖汽油，如果没有汽油，汽车将无法行驶。

class Oil {
    public $type = '汽油';
    public function add() {
        return $this->type;
    }
}

class Car {
    public function beforeRun(Oil $oil) {
        return '添加'.$oil->add();
    }
}

$car = new Car();
echo $car->beforeRun(new Oil());