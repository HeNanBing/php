<?php
/**
 * Created by PhpStorm.
 * User: nan
 * Date: 2017/2/16
 * Time: 19:55
 */
//工厂模式，就是负责生成其他对象的类或方法
//简单实现

//假如有一些类，都继承自交通工具类：
interface Vehicle {
    public function drive();
}

class Car implements Vehicle {
    public function drive()
    {
        echo '汽车四个轮子在陆地上跑';
    }
}

class Ship implements Vehicle
{
    public function drive()
    {
        echo '轮船靠螺旋桨划水前进。';
    }
}

class Aircraft implements Vehicle
{
    public function drive()
    {
        echo '飞机靠螺旋桨和机翼的升力飞行。';
    }
}

//再创建一个工厂类，专门用来做类的创建
class VehicleFactory {
    public static function build($className = null) {
        $className = ucfirst($className);
        if ($className && class_exists($className)) {
            return new $className();
        }
        return null;
    }
}

//工厂类用了静态方法来创建其他的类，可以这样使用
VehicleFactory::build('Car')->drive();
VehicleFactory::build('Ship')->drive();
VehicleFactory::build('Aircraft')->drive();