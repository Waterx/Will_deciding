<?php
session_start();
include("db.php");
//？？首先判断是否执行完分流，也就是enroll表中是否存在数据
//？？在这里判断的是enroll表中的major_id列，因为还存在特殊申请
//？？的同学的major_id为空


//建立一个通过成绩降序排列的视图connect
$sql_creatview = "CREATE VIEW connect 
AS 
SELECT will_submit.*,stu.name,stu.performance FROM will_submit,stu
WHERE will_submit.id=stu.id ORDER BY stu.performance DESC";

$info_view = $mysqli->query($sql_creatview);//创建视图
var_dump($info_view);
?>

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="tables.css">
  </head>
<table id="tables">
<tr>
    <th>学号</th>
    <th>姓名</th>
    <th>录取</th>
    <th>综合评价</th>
</tr>


<?php
//以下这个三重嵌套循环为顺序志愿分流主要算法
//第一重i循环为第一二三志愿
//第二重j循环在第i志愿下为五个专业分别录人，并且在视图里面把剩余的人根据成绩降序排列
//第三重k循环为录取小于等于剩余人数的人
for($i=1;$i<=3;$i++){
    for($j=1;$j<=5;$j++){
        $sql_numofstu = "SELECT num_of_stu FROM major WHERE major_id = $j";
        $numofstu_ = $mysqli->query($sql_numofstu)->fetch_row();
        //var_dump($numofstu_);
        $numofstu = (int)$numofstu_[0];
        //var_dump($numofstu);
        //pick student who has the same will
        $sql_search_will = "SELECT * FROM connect WHERE will$i=$j;";
        $same_will = $mysqli->query($sql_search_will);
        //这个count计数器在下面的循环需要用到，来记录多少人录取成功
        $count = 0;
        for($k=1;$k<=$numofstu;$k++){
            $stu_info = $same_will->fetch_assoc();
            //var_dump($stu_info);
            $stu_id = $stu_info['id'];
            //var_dump($stu_id);
            //add he to enroll
            $add_enroll = "INSERT INTO `enroll` (`id`, `performance`, `major_id`) 
            VALUES ('{$stu_info['id']}', '{$stu_info['performance']}', '{$stu_info["will$i"]}')";//???双引号解决
            $is = $mysqli->query($add_enroll);
            //var_dump($is);
            if($is){
                $count++;
                //以下这个sql语句是为了把志愿id转换为名字
                $sql_major = "SELECT * FROM major WHERE {$stu_info["will$i"]}=major_id";
                $major = $mysqli->query($sql_major)->fetch_assoc();
                $major_name = $major['major'];
                echo"<tr>";
                echo"<td>$stu_info[id]</td>";
                echo"<td>$stu_info[name]</td>";
                echo"<td>$major_name</td>";
                echo"<td>$stu_info[performance]</td>";
            }
            //then search id in will_submit,delete them.!!!not delete in view,only
            //delete it in base table is valid
            $sql_del = "DELETE FROM will_submit WHERE id = '{$stu_id}'";
            $mysqli->query($sql_del);
        }
        //更新剩余名额
        $numofstu = $numofstu - $count;
        //var_dump($numofstu);
        $sql_update_num = "UPDATE major SET num_of_stu = $numofstu WHERE major_id = $j;";
        $is = $mysqli->query($sql_update_num);
        //var_dump($is);
    }
}// i循环的括号

//以下的功能为把剩余的同学分配给还有未招满的专业
$sql_search="SELECT * FROM will_submit";
$result = $mysqli->query($sql_search);
while($row = $result->fetch_assoc()){
    $sql_notnullmajor = "SELECT * FROM major WHERE num_of_stu != 0";
    $notnullmajor = $mysqli->query($sql_notnullmajor)->fetch_assoc();
    var_dump($notnullmajor);
    

}






?>