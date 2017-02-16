<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>管理系统</title>
</head>
<body>
    <h1>管理员登录</h1>
    <form action="loginProcess.php" method="post">
        <table>
            <tr>
                <td>用户ID：</td>
                <td><input type="text" name="id"></td>
            </tr>
            <tr>
                <td>登录密码：</td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td><input type="submit" value="登录"></td>
                <td><input type="reset" value="重新填写"></td>
            </tr>
        </table>
    </form>
    <?php
        if(!empty($_GET['errno'])) {
            $errno = $_GET['errno'];
            if($errno == 1) {
                echo "<p style='color: #f00;'>用户名或密码错误</p>";
            }
        }
    ?>
</body>
</html>