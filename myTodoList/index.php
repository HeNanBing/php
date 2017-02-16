<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>To_do_list</title>
	<link rel="stylesheet" href="style.css">
</head>

<?php
	@session_start();
	if(isset($_POST['username']) && isset($_POST['password'])) {
		$link = new mysqli("localhost", "root", "12345678", "to_list");
		$link->set_charset('utf8');
		if($link->connect_errno) {
			echo "failed".mysqli_connect_error();
		}else {
			$username = $_POST['username'];
			$password = $_POST['password'];

			$sql = "SELECT id, username from users WHERE username = '".$username."' AND password='".sha1($password)."'";
			$res = $link->query($sql);
			if($res->num_rows) {
				echo "欢迎：".$username;
				$row = $res->fetch_assoc();
				$_SESSION['userid'] = $row['id'];
				$_SESSION['username'] = $row['username'];
				$res->free();
			}else {
				echo "<script type='text/javascript'>alert('用户名或密码错误');</script>";
			}

			$link->close();
		}
	} 

	if(isset($_SESSION['userid'])) {
		require_once('list.php');
	}else {
		echo "<form action='index.php' method='post'>";
		echo "<h2>欢迎你登录</h2>";
		echo "<label><span>用户名</span><input type='text' name='username'></label>";
		echo "<label><span>密码</span><input type='password' name='password'></label>";
		echo "<input type='submit' value='登录'>";
		echo "</form>";
		echo "<a href='signup.php'>点击注册>></a>";
	}

 ?>

</html>