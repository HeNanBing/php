<?php
	require_once 'SqlHelper.class.php';

	class EmpService {

		function getPageCount($pageSize) {

			//需要查询的$rowCount
			$sql = "select count(id) from emp";
			$SqlHelper = new SqlHelper();
			$res = $sqlHelper->execute_dql($sql);

			if($row = mysql_fetch_row($res)) {
				$pageCount = ceil($row[0]/$pageSize);
			}

			//释放资源关闭连接
			mysql_free_result($res);
			$sqlHelper->close_connect();
			return $pageCount;

		}

		function getEmplistByPage($pageNow, $pageSize) {
			$sql_emps = "SELECT * FROM emp limit ".($pageNow - 1) * $pageSize.", $pageSize";

			$sqlHelper = new SqlHelper();
			$res = $sqlHelper->execute_dql($sql);

			// mysql_free_result($res);
			// $sqlHelper->close_connect();
			return $res;
		}



	}
	