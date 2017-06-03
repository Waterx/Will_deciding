<?php
session_start();
include("db.php");
$sql_search = "SELECT * FROM will_submit WHERE id='{$_SESSION['account']}'";
if($mysqli->query($sql_search)->fetch_row())
{
    echo "您已填报过<br>";
}

$sql_insert = "INSERT INTO enroll (id)
               VALUES ('{$_SESSION['account']}')";

$info = $mysqli->query($sql_insert);

if( $info == true ){
    echo"特殊申请成功";
}
else{
    echo"特殊申请失败";
}
?>