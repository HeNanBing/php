<!doctype html>
<html>
	<head>
		<meta CHARSET='utf-8'>
		<link rel='stylesheet' type='text/css' href='style.css'/>
	</head>
	
	<?php
		@session_start();
		if(isset($_SESSION['userid'])) {
			$current_userid = $_SESSION['userid'];
			$query = "SELECT id, title, description, complete_by, completed_on from items WHERE user_id = $current_userid";
			$db = new mysqli('localhost', 'root', '12345678', 'to_list');
			$db->set_charset('utf8');
			if($db->connect_errno) {
				echo "problem";
				exit();
			} else {
				
				if(isset($_POST['completed-item'])) {
					$item_id = $_POST['completed-item'];
					$completed_query = "UPDATE items set completed_on = '".date("Y-m-d")."' WHERE id = $item_id";
					$completed_result = $db->query($completed_query);
					if(!$completed_result) {
						echo "没有更新";
						exit();
					}
				}
				
				if(isset($_POST['title'])) {
					$title = $_POST['title'];
					$description = $_POST['description'];
					$complete_by = $_POST['complete-by'];
					$user_id = $_SESSION['userid'];
					$stmt = $db->prepare("INSERT INTO items VALUES (?,?,?,?,?,?)");
					$id = NULL;
					$completed_on = NULL;
					$stmt->bind_param("issssi", $id, $title, $description, $complete_by, $completed_on, $user_id);
					$stmt->execute();
					if(!$stmt->affected_rows) {
						echo "没有插入";
					}
				}
				
				if(isset($_POST['item-to-delete'])) {
					$item_to_delete = $_POST['item-to-delete'];
					$delete_query = "DELETE FROM items WHERE id = $item_to_delete";
					$delete_result = $db->query($delete_query);
					if(!$delete_result) {
						echo "没有删除";
						exit();
					}
				}
				
				$result = $db->query($query);
				if($result->num_rows) {
					echo "<table>";
					echo "<caption>我的To-Do List</caption>";
					echo "<thead>";
					echo "<tr>";
					echo "<th>号</th>";
					$result->field_seek(1);
					while($field = $result->fetch_field()) {
						echo "<th>".$field->name."</th>";
					}
					echo "<th>删除</th>";
					echo "</tr>";
					echo "</thead>";
					for($i = 1; ($row = $result->fetch_assoc()); $i++) {
						echo "<tr>";
						echo "<td>$i</td>";
						echo "<td>".$row['title']."</td>";
						echo "<td>".$row['description']."</td>";
						echo "<td>";
						if(!$row['complete_by']) {
							echo "无最后期限";
						} else {
							echo $row['complete_by'];
						}
						echo "</td>";
						if(!$row['completed_on']) {
							echo "<td>";
							echo "<form action='list.php' method='post'>";
							echo "<input type='hidden' value='".$row['id']."' name='completed-item' />";
							echo "<input type='submit' value='标记为完成了'/>";
							echo "</form>";
							echo "</td>";
						} else {
							echo "<td>".$row['completed_on']."</td>";
						}
						echo "<td>";
							echo "<form action='list.php' method='post'>";
							echo "<input type='hidden' name='item-to-delete' value='".$row['id']."'/>";
							echo "<input type='submit' value='删除'/>";
							echo "</form>";
						echo "</td>";
						echo "</td>";
						echo "</tr>";
					}

				}
				echo "</table>";
				echo "<br/>";
				echo "<form action='list.php' method='post'>";
				echo "<h2>创建新事项</h2>";
				echo "<label><span>题目</span><input type='text' name='title'></label>";
				echo "<label><span>最后期限</span><input type='text' name='complete-by' value='YYYY-MM-DD'></label>";
				echo "<label><span>描写</span><textarea name='description'></textarea></label>";
				echo "<input type='submit' value='创建新事项'/>";
				echo "</form>";
			}
			echo "<a href='signout.php'>退出</a>";
			
		} else {
			echo "<a href='index.php'>在这里登录</a>";
		}
		
	?>
</html>