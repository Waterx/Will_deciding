<?php
session_start();
include("db.php");
var_dump($_POST);
$majorid = (int)$_POST['will'];
var_dump($majorid);
//以下的查询是查找给该学生添加的专业是否还有名额
$sql_search = "SELECT * FROM major WHERE major_id=$majorid";
$row_ = $mysqli->query($sql_search)->fetch_assoc();
if($row_['num_of_stu']!=0){
    //$sql_add = 
}
else{
    echo"该专业已满";
}

?>