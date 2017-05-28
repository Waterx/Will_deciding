<?php
$mysqli = new mysqli('localhost','root','','will_deciding');

if($mysqli->connect_error>0){
    echo"连接错误";
    echo $mysqli->connect_error;
    exit;
}

//var_dump($mysqli);

?>