<?php
/**
 * Created by PhpStorm.
 * User: nan
 * Date: 2017/2/16
 * Time: 19:42
 */

//聚合关系（Aggregation）：整体和部分的关系，整体与部分可以分开。
//聚合关系也表示类之间整体与部分的关系，成员对象是整体对象的一部分，但是成员对象可以脱离整体对象独立存在。
//例如：公交车司机和工衣、工帽是整体与部分的关系，但是可以分开，工衣、工帽可以穿在别的司机身上，公交司机也可以穿别的工衣、工帽。

class Clothes
{
    public $name = '工衣';
}

class Hat {
    public $name = '工帽';
}

class Driver {
    public $clothes;
    public $hat;

    public function wearClothes(Clothes $clothes) {
        $this->clothes = $clothes;
    }

    public function wearHat(Hat $hat) {
        $this->hat = $hat;
    }

    public function show() {
        return sprintf('公交车司机穿着%s和%s', $this->clothes->name, $this->hat->name);
    }
}

$driver = new Driver();
$driver->wearClothes(new Clothes());
$driver->wearHat(new Hat());
$driver->show();
