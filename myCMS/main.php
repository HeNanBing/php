<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<?php
echo "欢迎您".$_GET['name'];
echo "<br> <a href='login.php'>返回重新登录</a>";
?>

<h1>主界面</h1>
<a href="empList.php">管理用户</a>
<a href="#">添加用户</a>
<a href="#">查询用户</a>
<a href="#">安全退出</a>

</body>
</html>
