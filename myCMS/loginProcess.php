<?php

    require_once 'AdminService.class.php';

    //接受用户数据
    $id = $_POST['id'];
    $password = $_POST['password'];


// region 数据库检验
/*
 //数据库验证
$conn = @new mysqli("localhost", "root", "12345678", "study");
if($conn->connect_errno) {
    die("连接数据库失败".$conn->connect_error);
    exit();
}

if(!$conn->set_charset("utf8")) {
    printf("Error loading charset set utf8: %s\n", $conn->error);
}

//防止sql注入,查询数据库中的密码和输入的密码比对
$sql_admin_login = "SELECT password,name FROM admin WHERE id=$id";

*/

//endregion

    $adminService = new AdminService();
    $name = $adminService->checkAdmin($id, $password);
    if ($name != "") {
        header("Location: main.php?name=$name");
        exit();
    }else {
        header("Location: login.php?error=1");
        exit();
    }



