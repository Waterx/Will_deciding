<?php
session_start();
include("db.php");
//var_dump($_POST);

//把传过来的字符串分解
$content = explode('*',$_POST['will']);
//var_dump($content);
$majorid = $content[2];
$performance = $content[1];
$id = $content[0];
//以下的查询是查找给该学生添加的专业是否还有名额 
$sql_search = "SELECT * FROM major WHERE major_id=$majorid";
$row_ = $mysqli->query($sql_search)->fetch_assoc();
$majornum = $row_['num_of_stu'];
if($majornum!=0){
    //以下的查询是在enroll表中插入特殊申请学生的成绩和录取专业
    $sql_search = "UPDATE enroll SET performance=$performance,major_id=$majorid
                  WHERE id='{$id}'";
    $is = $mysqli->query($sql_search);
    //以下的查询是来更新major表中剩余名额
    if($is){
        $sql_update_num = "UPDATE major SET num_of_stu = num_of_stu-1 WHERE major_id = $majorid;";
        $is = $mysqli->query($sql_update_num);
        echo"分配成功";
    }
}
else if ($majornum==0){
    echo"该专业已满";
}

?>