<?php
session_start();
var_dump($_SESSION);
include("db.php");

//这个查询的作用是把学生填报志愿与学生名字连接
$sql_search = "SELECT will_submit.*,stu.name FROM will_submit,stu 
                WHERE will_submit.id=stu.id ORDER BY id ASC;";
$info_submit=$mysqli->query($sql_search);
//var_dump($info_submit);

?>

<html>
<table border="1">
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
  var_dump($row);
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
<input type="submit" value="执行分流"> 
</form?
</html>


