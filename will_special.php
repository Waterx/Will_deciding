<html>
    <head>
        <link rel="stylesheet" type="text/css" href="button.css">
    </head>

<?php
    session_start();
    include("db.php");
    // 把特殊申请的人按成绩降序排列
    $sql_search="SELECT enroll.id,name,stu.* FROM enroll,stu
              WHERE enroll.id=stu.id AND enroll.performance is NULL
              ORDER BY enroll.performance DESC";
    $result = $mysqli->query($sql_search);
    $row = $result->fetch_assoc();
    echo"<td>学号：$row[id]</td><br>";
    echo"<td>姓名：$row[name]</td><br>";
    echo"<td>综合评价：$row[performance]</td><br>";
    $sql_major="SELECT major FROM major";
    $info_major=$mysqli->query($sql_major);
    $id = $row['id'];
    $performance = $row['performance'];
    echo"<form action='will_specialmanage.php' method='POST'>";
    $count = 1;
    while($row = mysqli_fetch_assoc($info_major)){
     
        echo "<input type='radio' name='will' value=$count> $row[major]";
        $count++;
    }
    echo"<br><input type='submit' value='提交' class='button'>";
    echo"</form>";
    //以下的查询是查找给该学生添加的专业是否还有名额
    $majorid = (int)$_POST['will'];
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

</html>