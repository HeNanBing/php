<?php
/**
 * Created by PhpStorm.
 * User: nan
 * Date: 2017/2/16
 * Time: 20:09
 */
//单例模式，正如其名，允许我们创建一个而且只有一个对象的类
//这对整个系统的协同工作中非常有用，特别说明在只需要一个类对象的时候
//那么，什么时候只需要实例化一次呢
//在很多场景下会用到，如: 配置类，Session类，Database类，Cache类，File类等
//这些只需要实例化一次，就可以在应用的全局中使用

//单例模式的特点是4私1公：一个私有静态属性，构造方法私有，克隆方法私有，重建方法私有，一个公共静态方法。
//其他方法根据需要增加。


//以数据库类为例

//没有单例模式
class Database {
    public $db = null;
    public function __construct($config = array()) {
        $dsn = sprintf("mysql:host=%s; dbname=%s", $config['db_host'], $config['db_name']);
        $this->db = new PDO($dsn, $config['db_user'], $config['db_pass']);
    }
}

//创建3个对象
$config = array (
    'db_name' => 'test',
    'db_host' => 'localhost',
    'db_user' => 'root',
    'db_pass' => '123456'
);

//这种情况下，每当我们创建一个这个类的实例，就会新增一个到数据库的连接。
//开发者每在一个地方实例化一次这个类，就会在那里多一个数据库连接。
//不知不觉中，开发者就犯了个错误，给数据库和服务器性能带来巨大的影响。
$db1 = new Database($config);
var_dump($db1);
$db2 = new Database($config);
var_dump($db2);
$db3 = new Database($config);
var_dump($db3);

//每个对象都分配一个新的资源ID，都是新的引用，它们占用3个的内存空间。
//如果有100个对象创建，就会占用内存中100块不同的空间，而其余99块并非是必须的。



//要解决这样的问题，我们可以控制住基类，在源头上限制这个类，使其无法生成多个对象，如果已经生成过，直接返回。
//于是，我们的目标就是，控制数据库类，使其生成一次而且只能生成一次对象。
//如下就是单例模式连接数据库代码：
class Database2 {
    //声明$instance为私有静态变量，用于保存当前类实例化之后的对象
    private static $instance = null;
    //数据库连接句柄
    private $db = null;

    //构造方法声明为私有方法，禁止外部程序使用new实例化，只能在内部new
    private function __construct($config = array()) {
        $dsn = sprintf("mysql:host=%s; dbname=%s", $config['db_host'], $config['db_name']);
        $this->db = new PDO($dsn, $config['db_user'], $config['db_pass']);
    }

    //公开获取当前类对象的唯一方法
    public static function getInstance($config = array()) {
        //检查对象是否已经存在，不存在则实例化后保存到$instance属性
        if (self::$instance == null) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    //获取数据库连接句柄
    public function db() {
        return $this->db;
    }

    //声明成私有方法，禁止克隆对象
    private function __clone(){}

    //声明为私有方法，禁止重建对象
    private function __wakeup(){}
}

//再通过getInstance()方法实用类对象
$config = array (
    'db_name' => 'test',
    'db_host' => 'localhost',
    'db_user' => 'root',
    'db_pass' => '123456'
);

$db1_1 = Database2::getInstance($config);
var_dump($db1_1);
$db2_1 = Database2::getInstance($config);
var_dump($db2_1);
$db3_1 = Database2::getInstance($config);
var_dump($db3_1);

//获得链接句柄
$db4 = Database2::getInstance($config)->db();