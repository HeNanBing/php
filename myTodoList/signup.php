<!doctype html>
<html>
	<head>
		<meta CHARSET='utf-8'>
		<link rel='stylesheet' type='text/css' href='style.css'/>
	</head>
	<?php
		session_start();
		if(isset($_SESSION['userid'])) {
			require_once('list.php');
		} else {
			if(isset($_POST['username'])&&isset($_POST['email'])&&isset($_POST['password'])&&isset($_POST['password-confirm'])){
				if($_POST['password'] == $_POST['password-confirm']) {
					$db = new mysqli('localhost', 'root', '12345678', 'to_list');
					if($db->connect_errno){
						echo "problem";
						exit();
					} else {
						$db->set_charset('utf8');
						$username = $_POST['username'];
						$email = $_POST['email'];
						$password = $_POST['password'];
						$query = "INSERT INTO users VALUES(NULL,'".$username."', '".$email."', '".sha1($password)."')";
						$result = $db->query($query);
						if($result) {
							$_SESSION['userid'] = $db->insert_id; 
							require_once('list.php');
						} else {
							echo "登记没有成功";
						}
						$db->close();
					}
				} else {
					echo "好像你还没有确认你的密码";
					echo "<form action='signup.php' method='post'>";
					echo "<label><span>请选择一个用户名</span><input type='text' name='username'/></label>";
					echo "<label><span>你的email</span><input type='text' name='email'/></label>";
					echo "<label><span>请选择一个密码</span><input type='password' name='password'/></label>";
					echo "<label><span>请确认你的密码</span><input type='password' name='password-confirm'/></label>";
					echo "<input type='submit' value='登记'/>";
					echo "</form>";
					echo "<a href='index.php'>你已经是会员了吗？</a>";
				}
			} else {
				echo "<form action='signup.php' method='post'>";
				echo "<label><span>请选择一个用户名</span><input type='text' name='username'/></label>";
				echo "<label><span>你的email</span><input type='text' name='email'/></label>";
				echo "<label><span>请选择一个密码</span><input type='password' name='password'/></label>";
				echo "<label><span>请确认你的密码</span><input type='password' name='password-confirm'/></label>";
				echo "<input type='submit' value='登记'/>";
				echo "</form>";
				echo "<a href='index.php'>你已经是会员了吗？</a>";
			}			
		}

	?>
</html>