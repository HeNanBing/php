<?php

    require_once 'SqlHelper.class.php';
    //业务逻辑处理类，对admin表的业务操作
    class AdminService {

        //提供一个验证用户合法性的方法
        public function checkAdmin($id, $password) {
            $sql= "SELECT password,name FROM admin WHERE id=$id";

            //创建一个SqlHelper对象
            $sqlHelper = new SqlHelper();
            $res = $sqlHelper->execute_dql($sql);
            if($row=$res->fetch_assoc()) {
                if (md5($password) == $row['password']) {
                    return $row['name'];
                }
            }
            //释放资源
            $res->free();
            $sqlHelper->close_connect();
            return false;

        }
    }