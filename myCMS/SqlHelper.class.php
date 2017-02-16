<?php

    //数据库工具类，作用是完成对数据库的操作
    class SqlHelper {
        public $conn;
        public $dbhost = 'localhost';
        public $dbname = 'study';
        public $username = 'root';
        public $password = '12345678';

        public function __construct()
        {
            $this->conn = new mysqli($this->dbhost, $this->username, $this->password, $this->dbname);
            if($this->conn->errno) {
                die("连接数据库失败".$this->conn->connect_error);
                exit();
            }
            if(!$this->conn->set_charset("utf8")) {
                printf("Error loading charset set utf8: %s\n", $this->conn->error);
            }
        }

        //执行dql(数据查询)语句
        public function execute_dql($sql) {
            $result = $this->conn->query($sql);
            if($result === false) {
                echo $this->conn->error;
                echo $this->conn->errno;
                exit();
            }
            return $result;
        }

        public function execute_dql2($sql) {
            $arr = array();
            $i = 0;
            $result = $this->conn->query($sql);
            if($result === false) {
                echo $this->conn->error;
                echo $this->conn->errno;
                exit();
            }

            while($row=$result->fetch_assoc()) {
                $arr[$i++] = $row;
            }

            $result->free();

            return $result;
        }

        //执行dml(数据操纵)语句
        public function execute_dml($sql) {
            $result = $this->conn->query($sql);
            if(!$result) {
                return 0;
            }else {
                if($this->conn->affected_rows > 0) {
                    return 1; //表示执行OK；
                }else {
                    return 2; //表示没有行受到影响
                }
            }
        }


        //关闭连接
        public function close_connect() {
            if (!empty($this->conn)) {
                $this->conn->close();
            }
        }
    }