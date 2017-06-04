<?php
session_start();
//var_dump($_POST['will1']);
//var_dump($_SESSION);
include("db.php");
//以下为查找该账号是否提交过
$sql_search = "SELECT * FROM will_submit WHERE id='{$_SESSION['account']}'";
//var_dump($mysqli->query($sql_search)->fetch_row());
//var_dump($mysqli->query($sql_search)->fetch_array());

if($mysqli->query($sql_search)->fetch_row())
{
    echo "您已填报过<br>";
}
//以下为插入表
$sql_insert = "INSERT INTO will_submit (`id`, `will1`, `will2`, `will3`) 
               VALUES ('{$_SESSION['account']}',
               '{$_POST['will1']}', '{$_POST['will2']}', '{$_POST['will3']}')";

$info = $mysqli->query($sql_insert);
if( $info == true ){
    echo"填报成功";
}
else{
    echo"填报失败";
}
?>