<?php
session_start();
//var_dump($_SESSION);
include("db.php");

//这个查询的作用是把学生填报志愿与学生名字连接
$sql_search = "SELECT will_submit.*,stu.name FROM will_submit,stu 
                WHERE will_submit.id=stu.id ORDER BY id ASC;";
$info_submit=$mysqli->query($sql_search);
//var_dump($info_submit);
?>

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="button.css">
    <link rel="stylesheet" type="text/css" href="tables.css">
  </head>
  <h2>未分流同学</h2>
  <table id="tables">
  <tr>
    <th>学号</th>
    <th>姓名</th>
    <th>第一志愿</th>
    <th>第二志愿</th>
    <th>第三志愿</th>
  </tr>
  <tr>

<?php
  while($row = $info_submit->fetch_assoc()){
    //var_dump($row);
    //以下这个循环的作用是把专业id转换为专业名称
    for($i=1;$i<=3;$i++){
      $sql_major = "SELECT * FROM major WHERE {$row["will$i"]}=major_id";
      $major = $mysqli->query($sql_major)->fetch_assoc();
      $major_name["$i"] = $major['major'];
    }
    echo"<tr>";
    echo"<td>$row[id]</td>";
    echo"<td>$row[name]</td>";
    echo"<td>$major_name[1]</td>";
    echo"<td>$major_name[2]</td>";
    echo"<td>$major_name[3]</td>";
    echo"</tr>";
  }
?>
  </tr>
  </table>

  <br>
  <form action = "will_sort.php">
  <input type="submit" value="执行分流" class="button"> 
  </form>

  <h2>已分流同学</h2>
  <table id="tables">
  <tr>
    <th>学号</th>
    <th>姓名</th>
    <th>综合评价</th>
    <th>专业</th>
  </tr>
  

<?php
//对已分流同学按照专业id升序排列
  $sql_search="SELECT enroll.id,name,stu.performance,major FROM enroll,stu,major
              WHERE enroll.id=stu.id AND enroll.major_id=major.major_id
              ORDER BY enroll.major_id ASC ";
  $result = $mysqli->query($sql_search);
  while($row = $result->fetch_assoc()){
    //var_dump($row);
    echo"<tr>";
    echo"<td>$row[id]</td>";
    echo"<td>$row[name]</td>";
    echo"<td>$row[performance]</td>";
    echo"<td>$row[major]</td>";
    echo"</tr>";
  }
?>
</table>

<h2>特殊申请同学</h2>
  <table id="tables">
  <tr>
    <th>学号</th>
    <th>姓名</th>
    <th>综合评价</th>
  </tr>
<?php
//对特殊申请的同学根据学号升序排列
  $sql_search="SELECT enroll.id,name,stu.performance FROM enroll,stu
              WHERE enroll.id=stu.id AND enroll.performance is NULL
              ORDER BY enroll.id ASC";
  $result = $mysqli->query($sql_search);
  while($row = $result->fetch_assoc()){
    //var_dump($row);
    echo"<tr>";
    echo"<td>$row[id]</td>";
    echo"<td>$row[name]</td>";
    echo"<td>$row[performance]</td>";
    echo"</tr>";
  }
?>

  </table>

<?php


?>  
</html>


