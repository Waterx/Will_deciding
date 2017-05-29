<?php
session_start();
include("db.php");
var_dump($_SESSION);
$sql_slc="SELECT * FROM stu WHERE id = '{$_SESSION['account']}'";
var_dump($sql_slc);
$info_ = $mysqli->query($sql_slc)->fetch_all();
$info = $info_[0];
var_dump($info);
echo "学号：$info[0]<br>";
echo "姓名：$info[1]<br>";
echo "综合评价：$info[2]<br>";
?>

