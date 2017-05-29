<?php
session_start();
include("db.php");
$account=$_POST['account'];
$psw=$_POST['password'];
$sql="SELECT * FROM account WHERE id='{$account}' AND psw='{$psw}'";
$is=$mysqli->query($sql);
if($is->fetch_array()){
    $row=$is->fetch_array();
    //var_dump($is->fetch_array());
    $_SESSION['account']=$account;
    $patten = '/S/';
    $isStu = preg_match($patten,$account);
    var_dump($isStu);
    if($isStu){
        header("Location:will_deciding.php");
    }
    else{
        header("Location:will_manage.php");
    }
    //var_dump($_SESSION);
    echo"登陆成功";
}
else
{
    echo"登陆失败";
    //header("Location:index.html");
}


?>