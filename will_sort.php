<?php
session_start();
include("db.php");

//建立一个通过成绩降序排列的视图connect
$sql_creatview = "CREATE VIEW connect 
AS 
SELECT will_submit.*,stu.name,stu.performance FROM will_submit,stu
WHERE will_submit.id=stu.id ORDER BY stu.performance DESC";

$info_view = $mysqli->query($sql_creatview);//创建视图
var_dump($info_view);


for($i=1;$i<=5;$i++){
    $sql_numofstu = "SELECT num_of_stu FROM major WHERE major_id = $i";
    $numofstu_ = $mysqli->query($sql_numofstu)->fetch_row();
    var_dump($numofstu_);
    $numofstu = (int)$numofstu_[0];
    var_dump($numofstu);
    for($j=1;$j<=$numofstu;$j++){
         $sql_search = "SELECT * FROM connect WHERE will1=$i;";
         $mysqli->query($sql_search);
         $sql_add = "INSERT INTO `enroll` (`id`, `performance`, `major_id`) 
                    VALUES ('1', '1', '1')"

     }
}



?>