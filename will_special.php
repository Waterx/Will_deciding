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
        //为了传id，performance，major_id只能把他们连成字符串
        $mix=$id.'*'.$performance.'*'.$count;
        //var_dump($mix);
        echo "<input type='radio' name='will' value=$mix> $row[major]";
        $count++;
    }
    echo"<br><input type='submit' value='提交' class='button'>";
    echo"</form>";


?>

</html>