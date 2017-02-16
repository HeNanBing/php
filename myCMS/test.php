<?php
/**
 * Created by PhpStorm.
 * User: nan
 * Date: 2016/12/10
 * Time: 12:06
 */

//phpinfo();

$array = array(1, 43, 54, 62, 21, 66, 32, 78, 36, 76, 39);

function bubbleSort($arr) {
    $len = count($arr);
    for($i = 1; $i < $len; $i++) {
        for($k = 0; $k < $len - $i; $k++) {
            if($arr[$k] > $arr[$k+1]) {
                $temp = $arr[$k+1];
                $arr[$k+1] = $arr[$k];
                $arr[$k] = $temp;
            }
        }
    }
    return $arr;
}

function selectSort($arr) {
    $len = count($arr);
    for($i = 0; $i < $len - 1; $i++) {
        $p = $i;
        for($j = $i + 1; $j < $len; $j++) {
            if($arr[$p] > $arr[$j]) {
                $p = $j;
            }
        }
        if($p != $i) {
            $temp = $arr[$p];
            $arr[$p] = $arr[$i];
            $arr[$i] = $temp;
        }
    }
    return $arr;
}

function insertSort($arr) {
    $len = count($arr);
    for($i = 1; $i < $len; $i++) {
        $temp = $arr[$i];
        for($j = $i - 1; $j >= 0; $j--) {
            if($temp < $arr[$j]) {
                $arr[$j+1] = $arr[$j];
                $arr[$j] = $temp;
            }else {
                break;
            }
        }
    }
    return $arr;
}

function quickSort($arr) {
    $length = count($arr);
    if($length <= 1) {
        return $arr;
    }

    $base_num = $arr[0];
    $left_array = array();
    $right_array = array();
    for($i = 1; $i < $length; $i++) {
        if($base_num > $arr[$i]) {
            $left_array[] = $arr[$i];
        }else {
            $right_array[] = $arr[$i];
        }
    }
    $left_array = quickSort($left_array);
    $right_array = quickSort($right_array);

    return array_merge($left_array, array($base_num), $right_array);
}


//print_r(bubbleSort($array));
//print_r(selectSort($array));
//print_r(insertSort($array));
print_r(quickSort($array));


////管理员表
//create table admin (
//    id int primary key,
//    name varchar(32) not null,
//    password varchar(128) not null
//);
//
////雇员表
//create table emp (
//    id int primary key auto_increment,
//    name varchar(64) not null,
//    email varchar(64) not null,
//    grade tinyint,
//    salary float
//);

//insert into emp(name, email, grade, salary) values ('henanbing', 'hananbing@qq.com', 1, 2000.5);
//insert into admin values (100, 'admin', md5('admin'));




















