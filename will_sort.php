<?php
session_start();
include("db.php");

//建立一个通过成绩降序排列的视图connect
$sql_creatview = "CREATE VIEW connect 
AS 
SELECT will_submit.*,stu.name,stu.performance FROM will_submit,stu
WHERE will_submit.id=stu.id ORDER BY stu.performance DESC";

$info_view = $mysqli->query($sql_creatview);
var_dump($info_view);


for($i=1;$i<=5;$i++){
    $sql_search = "SELECT * FROM connect WHERE will1=$i;";
    for($j=1;$j=)
}



?>