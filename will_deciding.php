<html>
    <head>
        <meta charset="utf-8">
        <title>志愿填报</title>
        <link rel="stylesheet" type="text/css" href="button.css">
    </head>
    <?php
        //以下为查找并显示学生信息
        session_start();
        include("db.php");
        //var_dump($_SESSION);
        $sql_slc="SELECT * FROM stu WHERE id = '{$_SESSION['account']}'";
        //var_dump($sql_slc);
        $info_ = $mysqli->query($sql_slc)->fetch_all();
        $info = $info_[0];
        //var_dump($info);
        echo "学号：$info[0]<br>";
        echo "姓名：$info[1]<br>";
        echo "综合评价：$info[2]<br>";

        //以下查询为查找是否填报，如果已经填报，则不显示填报按钮
        $sql_slc="SELECT * FROM  will_submit WHERE id = '{$_SESSION['account']}'";
        $is = $mysqli->query($sql_slc)->fetch_assoc();
        //var_dump($is);
        //以下查询为查找是否已分流或特殊申请（进入enroll表），如果已经分流，则不显示填报按钮
        $sql_slc="SELECT * FROM enroll WHERE id = '{$_SESSION['account']}'";
        $is2 = $mysqli->query($sql_slc)->fetch_assoc();
        //var_dump($is2);

        //已经录取或特殊申请
        if($is2){
            //下面这个判断是用来判断是否特殊申请
            if($is2['major_id'] == null){
                echo"特殊申请受理中";
            }
            else{
                $major=$is2;
                //var_dump($major);
                $sql_major = "SELECT * FROM major WHERE $major[major_id]=major_id";
                $major = $mysqli->query($sql_major)->fetch_assoc();
                $major_name = $major['major'];
                echo"恭喜您被 $major_name 专业录取";
            }
        }

        //已经填报没有录取
        else if($is){
            echo"您已填报过，等待分流";
            //以下这一块查询是查询该id报了什么专业，并且显示出来。
            $sql_search = "SELECT will_submit.*,stu.name FROM will_submit,stu 
            WHERE will_submit.id=stu.id ORDER BY id ASC;";
            $info_submit=$mysqli->query($sql_search);
            $row = $info_submit->fetch_assoc();
            //var_dump($row);
            for($i=1;$i<=3;$i++){
                $sql_major = "SELECT * FROM major WHERE {$row["will$i"]}=major_id";
                $major = $mysqli->query($sql_major)->fetch_assoc();
                $major_name["$i"] = $major['major'];
            }
            echo "<table border=1><th>第一志愿</th>
            <th>第二志愿</th>
            <th>第三志愿</th>";
            echo"<tr>";
            echo"<td>$major_name[1]</td>";
            echo"<td>$major_name[2]</td>";
            echo"<td>$major_name[3]</td>";
            echo"</tr>";
            echo"</table>";
        }

        //没报考也没录取，进入报名
        else{
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
        echo"<br><br><input type='submit'' value='提交' class='button'>";
        echo"</form>";
        echo"<form action='will_submit_sp.php' method='POST'>";
        echo"<input type='submit' value='特殊申请' class='button'>←需要特殊申请的同学请点击特殊申请按钮";
        }//它是前面else条件的括号
        ?>
        </form>
</html>