<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>雇员列表</title>
    <style>
        div.content {
            margin: 0 auto;
            text-align: center;
        }
        table {
            margin: auto;
            margin-bottom: 10px;
        }
        a.page {
            display: inline-block;
            margin-right: 8px;
            height: 34px;
            width: 34px;
            line-height: 34px;
            text-decoration: none;
            border: 1px solid #e1e2e3;
            text-align: center;
            font-size: 14px;
        }
        a.page.pre,
        a.page.next {
            width: auto;
            padding: 0 18px;
        }
    </style>
</head>
<body>
<?php
require_once 'EmpService.class.php';
//显示所有雇员信息
//查询数据库
$conn = @new mysqli("localhost", "root", "12345678", "study");
if ($conn->connect_errno) {
    die("连接数据库失败".$conn->connect_error);
    exit();
}

if(!$conn->set_charset("utf8")) {
    printf("Error loading charset set utf8: %s\n", $conn->error);
}

//分页
$pageSize = 15; //每页大小
$rowCount = 0; //总数据条数
$firstPage = 1;
$endPage = 1;
//中间现实的页码
$pageNum = 5;

//$pageNow 当前页
//根据用户的点击修改$pageNow
$pageNow = !empty($_GET['pageNow']) ? $_GET['pageNow'] : 1;

// $pageCount = 0; //总页数

// $sql_count = "SELECT count(id) FROM emp";
// $result_count = $conn->query($sql_count);

$empService = new EmpService();
$pageCount = $empService->getPageCount($pageSize);




if ($result_count === false) {
    echo $conn->error;
    echo $conn->errno;
}

//取出行数
if ($row = $result_count->fetch_row()) {
    $rowCount = $row[0];
}

$result_count->free();

//计算共有多少页
$pageCount = ceil($rowCount/$pageSize);

// $sql_emps = "SELECT * FROM emp limit ".($pageNow - 1) * $pageSize.", $pageSize";
// $res = $conn->query($sql_emps);
$res = $empService->getEmplistByPage($pageNow, $pageSize);

if ($res === false) {
    echo $conn->error;
    echo $conn->errno;
}

echo "<div class='content'>";
echo "<h1>雇员信息列表</h1>";
echo "<table width='700px' border='1' cellspacing='0' cellpadding='0'>";
print <<<EOT
    <tr>
        <th>id</th>
        <th>name</th>
        <th>email</th>
        <th>grade</th>
        <th>salary</th>
        <th>删除用户</th>
        <th>修改用户</th>
    </tr>
EOT;
while ($row = $res->fetch_assoc()) {
    print <<<EOT
        <tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
            <td>{$row['grade']}</td>
            <td>{$row['salary']}</td>
            <td><a href='#'/>删除用户</td>
            <td><a href='#'/>修改用户</td>
        </tr>
EOT;
}
echo "</table>";


//页码超链接
//for ($i = 1; $i <= $pageCount; $i++) {
//    echo "<a href='empList.php?pageNow=$i'>$i</a>&nbsp;";
//}

if ($pageCount < $pageNum) {
    $firstPage = 1;
    $endPage = $pageCount;
}else {
    if($pageNow == 1) {
        $firstPage = 1;
        $endPage = $pageNum;
    }else {
        $firstPage = $pageNow - 1;
        $endPage = $pageNow + $pageNum - 2;

        if ($endPage > $pageCount) {
            $endPage = $pageCount;
        }
    }
}

//上一页下一页
if ($pageNow > 1) {
    $prePage = $pageNow - 1;
    echo "<a class='page first' href='empList.php?pageNow=1'>首页</a>";
    echo "<a class='page pre' href='empList.php?pageNow=$prePage'><上一页</a>";
    $jumpPage = $pageNow - 5;
    if($jumpPage >= 1) {
        echo "<a class='page' href='empList.php?pageNow=$jumpPage'> << </a>";
    }
}

for($i = $firstPage; $i <= $endPage; $i++) {
    echo "<a class='page' href='empList.php?pageNow=$i'>$i</a>";
}


if ($pageNow != $pageCount) {
    $nextPage = $pageNow + 1;

    $jumpPage = $pageNow + 5;
    if($jumpPage <= $pageCount) {
        echo "<a class='page' href='empList.php?pageNow=$jumpPage'> >> </a>";
    }
    echo "<a class='page next' href='empList.php?pageNow=$nextPage'>下一页></a>";
    echo "<a class='page end' href='empList.php?pageNow=$pageCount'>尾页</a>";
}

echo "<br/>";
//显示当前页和总页数
echo "当前是第".$pageNow."页，共有"."{$pageCount}页";

//跳转到指定页面
?>
<form action="empList.php">
    <labe>跳转到：</labe>
    <input type="number" min="1" max="<?php echo $pageCount; ?>" name="pageNow">
    <input type="submit" value="Go">
</form>


<?php
echo "</div>";

$res->free();
$conn->close();

?>


</body>
</html>

