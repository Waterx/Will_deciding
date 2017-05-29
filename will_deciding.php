<html>
    <head>
        <meta charset="utf-8">
        <title>志愿填报</title>
    </head>
    <?php
        //以下为查找并显示学生信息
        session_start();
        include("db.php");
        var_dump($_SESSION);
        $sql_slc="SELECT * FROM stu WHERE id = '{$_SESSION['account']}'";
        var_dump($sql_slc);
        $info_ = $mysqli->query($sql_slc)->fetch_all();
        $info = $info_[0];
        var_dump($info);
        echo "学号：$info[0]<br>";
        echo "姓名：$info[1]<br>";
        echo "综合评价：$info[2]<br>";
        //以下为志愿填报信息
        $sql_major="SELECT major FROM major";
        $info_major=$mysqli->query($sql_major);

    ?>
    <br>
    <form action="will_submit.php" method="POST">
        第一志愿：<br>
        
        <?php
        $count = 1;
        while($row = mysqli_fetch_assoc($info_major)){
            //var_dump($row);
        echo "<input type='radio' name='will1' value='$count'> $row[major]";
        $count++;
        }
        ?>
       
        <br>第二志愿：<br>
        <?php
        $count = 1;
        $info_major=$mysqli->query($sql_major);
        while($row = mysqli_fetch_assoc($info_major)){
        echo "<input type='radio' name='will2' value='$count'> $row[major]";
        $count++;
        }
        ?>
        
        <br>第三志愿：<br>
        <?php
        $count = 1;
        $info_major=$mysqli->query($sql_major);
        while($row = mysqli_fetch_assoc($info_major)){
        echo "<input type='radio' name='will3' value='$count'> $row[major]";
        $count++;
        }
        ?>
        
        <br><input type="submit" value="提交">
    </form>

</html>