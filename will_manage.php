<?php
session_start();
var_dump($_SESSION);
include("db.php");

$sql_search = "SELECT will_submit.*,stu.name FROM will_submit,stu 
                WHERE will_submit.id=stu.id;";

$info_submit=$mysqli->query($sql_search);
var_dump($info_submit);

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
  echo"<tr>";
  echo"<td>$row[id]</td>";
  echo"<td>$row[name]</td>";
  echo"<td>$row[will1]</td>";
  echo"<td>$row[will2]</td>";
  echo"<td>$row[will3]</td>";
  echo"</tr>";
}
?>
</tr>
</table>
</html>


