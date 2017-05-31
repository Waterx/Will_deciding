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

for($k=1;$k<=3;k++){
    for($i=1;$i<=5;$i++){
        $sql_numofstu = "SELECT num_of_stu FROM major WHERE major_id = $i";
        $numofstu_ = $mysqli->query($sql_numofstu)->fetch_row();
        var_dump($numofstu_);
        $numofstu = (int)$numofstu_[0];
        var_dump($numofstu);
        //pick student who has the same will1
        $sql_search_will = "SELECT * FROM connect WHERE will1=$i;";
        $same_will = $mysqli->query($sql_search_will);
        //这个count计数器在下面的循环需要用到，来记录多少人录取成功
        $count = 0;
        for($j=1;$j<=$numofstu;$j++){
            $stu_info = $same_will->fetch_assoc();
            var_dump($stu_info);
            $stu_id = $stu_info['id'];
            var_dump($stu_id);
            //add he to enroll
            $add_enroll = "INSERT INTO `enroll` (`id`, `performance`, `major_id`) 
            VALUES ('{$stu_info['id']}', '{$stu_info['performance']}', '{$stu_info['will1']}')";
            $is = $mysqli->query($add_enroll);
            var_dump($is);
            if($is){
                $count++;
            }
            //then search id in will_submit,delete them.!!!not delete in view,only
            //delete it in base table is valid
            $sql_del = "DELETE FROM will_submit WHERE id = '{$stu_id}'";
            $mysqli->query($sql_del);
        }
        //更新剩余名额
        $numofstu = $numofstu - $count;
        var_dump($numofstu);
        $sql_update_num = "UPDATE major SET num_of_stu = $numofstu WHERE major_id = $i;";
        $is = $mysqli->query($sql_update_num);
        var_dump($is);
    }
}


?>