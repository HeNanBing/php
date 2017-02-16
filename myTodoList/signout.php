<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
</head>
<?php
	session_start();
	if(isset($_SESSION['userid'])) {
		session_destroy();
		echo "退出登录成功";
	}else {
		echo "退出登录失败"；
	}
	echo "<br/>";
	echo "<a href='index.php'>重新登录</a>";

 ?>
</html>