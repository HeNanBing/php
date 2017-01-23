<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mysql分页</title>
</head>
<style>
    a {
        text-decoration: none;
        border: 1px solid #551a8b;
        padding: 5px 5px;
        margin: 2px;
    }
    a.current {
        background: #551a8b;
        color: #fff;
        padding: 7px;
        font-size: bold;
    }
    a.disable {
        /*pointer-events: none;*/
        color: #ccc;
        border:1px solid #ddd;
    }
    form {
        display: inline;
    }
    input {
        width: 50px;
    }
</style>
<body>
    
<?php
    //当前页
    $page = isset($_GET['p']) ? $_GET['p'] : 1;
    //每页显示的条数
    $pageLimit = 15;

    //显示页码
    $showPage = 5;
    //页面偏移量
    $pageOffset= ($showPage - 1) / 2;

    $conn = new mysqli("localhost", "root", "123456", "test");
    if (mysqli_connect_error()) {
        die('Connect error (' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    }

    $total_page = 'SELECT COUNT(id) FROM page';
    $total_result = $conn->query($total_page);
    //总页数
    $pageCount = ceil(($total_result->fetch_array()[0])/$pageLimit);

    $sql = "SELECT * FROM page LIMIT " . ($page - 1) * $pageLimit .", {$pageLimit}";
    $result = $conn->query($sql);

    echo "<div class='content'>";
    while ($row = $result->fetch_assoc()) {
        echo $row['id']."\t-->\t".$row['name'].'<br>';
    }
    echo "</div>";

    $result->free();
    $total_result->free();
    $conn->close();

    $firstPage = $_SERVER['PHP_SELF']."?p=1";
    $nextPage = $page == $pageCount ? $finalPage : $_SERVER['PHP_SELF']."?p=".($page+1);
    $prePage = $page == 1 ? $firstPage : $_SERVER['PHP_SELF']."?p=".($page-1);
    $finalPage = $_SERVER['PHP_SELF']."?p={$pageCount}";
    

    $pageInfo = "<div class='page'>";
    if ($page > 1) {
        $pageInfo .= '<a href="'.$firstPage.'">首页</a>';
        $pageInfo .= '<a href="'.$prePage.'">上一页</a>';
    }else {
        $pageInfo .= '<a class="disable" href="'.$firstPage.'">首页</a>';
        $pageInfo .= '<a class="disable" href="'.$prePage.'">上一页</a>';
    }

    /*
    $pageSize = 5;
    $start = 1;
    $end = 1;

    if ($pageCount < $pageSize) {
        $start = 1;
        $end = $pageCount;
    }else {
        if ($page == 1) {
            $start = 1;
            $end = $pageSize;
        }else {
            $start = $page - 1;
            $end = $page + $pageSize - 2;

            if ($end>$pageCount) {
                $end = $pageSize;
            }
        }
    }

    for ($i = $start; $i <= $end; $i++) {
        $pageInfo .= '<a href="'.$_SERVER['PHP_SELF']."?p={$i}".'">'.$i.'</a>';
    }
    */
    $start = 1;
    $end = $pageCount;
    if ($pageCount > $showPage) {
        if ($page > $pageOffset + 1) {
            $pageInfo .= '...';
        }
        if ($page > $pageOffset) {
            $start = $page - $pageOffset;
            $end = ($pageCount > ($page + $pageOffset)) ? ($page + $pageOffset) : $pageCount;
        }else {
            $start = 1;
            $end = $pageCount > $showPage ? $showPage : $pageCount;
        }
        if ($page + $pageOffset > $pageCount) {
            $start = $start - ($page + $pageOffset - $end);
        }
    }

    for ($i = $start; $i <= $end; $i++) {
        if ($page == $i) {
            $pageInfo .= '<a class="current" href="'.$_SERVER['PHP_SELF']."?p={$i}".'">'.$i.'</a>';
        }else {
            $pageInfo .= '<a href="'.$_SERVER['PHP_SELF']."?p={$i}".'">'.$i.'</a>';
        }
    }

    if ($pageCount > $showPage && $pageCount > ($page + $pageOffset)) {
        $pageInfo .= '...';
    }

    if ($page < $pageCount) {
        $pageInfo .= '<a href="'.$nextPage.'">下一页</a>';
        $pageInfo .= '<a href="'.$finalPage.'">尾页</a>';
    }else {
        $pageInfo .= '<a class="disable" href="'.$nextPage.'">下一页</a>';
        $pageInfo .= '<a class="disable" href="'.$finalPage.'">尾页</a>';
    }

    $pageInfo .= '当前第'.$page.'页';
    $pageInfo .= '共有'.$pageCount.'页';
    $pageInfo .= "<form action='page.php' method='get'>";
    $pageInfo .= "跳到第<input type='text' name='p'>";
    $pageInfo .= "<input type='submit' value='跳转'>";
    $pageInfo .= "</form></div>";
    echo $pageInfo;
    
?>
</body>
</html>