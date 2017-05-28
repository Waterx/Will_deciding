<?php
//var_dump($_POST);
session_start();
include("db.php");
//var_dump($mysqli);
$account=$_POST['account'];
$psw=$_POST['password'];
echo $account;
$sql="SELECT * FROM account WHERE id='{$account}' AND psw='{$psw}'";
//echo $sql;
//session_destroy();
$is=$mysqli->query($sql);
//var_dump($is);
//var_dump($is->fetch_array());
if($is->fetch_array()){
    $row=$is->fetch_array();
    //var_dump($is->fetch_array());
    $_SESSION['account']=$account;
    header("Location:will_deciding.php");
    //var_dump($_SESSION);

    echo"登陆成功";
}
else
{
    echo"登陆失败";
    header("Location:index.html");
}


?>