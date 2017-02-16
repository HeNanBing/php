<?php
/**
 * Created by PhpStorm.
 * User: nan
 * Date: 2017/2/16
 * Time: 15:35
 */

class Core {
    //运行程序
    function run() {
        spl_autoload_register(array($this, 'loadClass'));
        $this->setReporting();
        $this->removeMagicQuotes();
        $this->unregisterGlobals();
        $this->Route();
    }

    //路由处理
    function Route() {
        $controllerName = 'Index';
        $action = 'index';

        if (!empty($_GET['url'])) {
            $url = $_GET['url'];
            $urlArray = explode('/', $url);

            //获取控制器名称
            $controllerName = ucfirst($urlArray[0]);

            //获取动作名称
            array_shift($urlArray);
            $action = empty($urlArray[0]) ? 'index' : $urlArray[0];

            //获取URL参数
            array_shift($urlArray);
            $queryString = empty($urlArray) ? array() : $urlArray;
        }

        //数据为空的处理
        $queryString = empty($queryString) ? array() : $queryString;

        //实例化控制器
        $controller = $controllerName.'Controller';
        $dispatch = new $controller($controllerName, $action);

        //如果控制器和动作存在，调用并传入参数
        if ((int)method_exists($controller, $action)) {
            call_user_func_array(array($dispatch, $action), $queryString);
        }else {
            exit($controller."控制其不存在");
        }
    }

    //检测开发环境
    function setReporting() {
        if (APP_DEBUG === true) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        }else {
            error_reporting(E_ALL);
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', RUNTIME_PATH.'logs/error.log');
        }
    }

    //删除敏感字符
    function stripSlashesDeep($value) {
        $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
        return $value;
    }

    //检测敏感字符并删除
    function removeMagicQuotes() {
        if (get_magic_quotes_gpc()) {
            $_GET = isset($_GET) ? $this->stripSlashesDeep($_GET ) : '';
            $_POST = isset($_POST) ? $this->stripSlashesDeep($_POST ) : '';
            $_COOKIE = isset($_COOKIE) ? $this->stripSlashesDeep($_COOKIE) : '';
            $_SESSION = isset($_SESSION) ? $this->stripSlashesDeep($_SESSION) : '';
        }
    }

    //检测自定义全局变量
    function unregisterGlobals() {
        if (ini_get('register_globals')) {
            $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
            foreach ($array as $value) {
                foreach ($GLOBALS[$value] as $key=>$var) {
                    if ($var === $GLOBALS[$key]) {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }

    //自动加载控制器和模型
    public static function loadClass($class) {
        $frameworks = FRAME_PATH.$class.'.class.php';
        $controllers = APP_PATH.'application/controllers/'.$class.'.class.php';
        $model = APP_PATH.'application/models/'.$class.'.class.php';

        if (file_exists($frameworks)) {
            //加载框架核心类
            include $frameworks;
        }elseif (file_exists($controllers)) {
            //加载应用控制器类
            include $controllers;
        }elseif (file_exists($model)){
            //加载应用模型类
            include $model;
        }else {
            //错误代码
        }
    }
}