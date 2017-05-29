<?php
session_start();
var_dump($_POST['will1']);
var_dump($_SESSION);
include("db.php");

$sql_insert = "INSERT INTO will_submit (`id`, `will1`, `will2`, `will3`) 
               VALUES ('{$_SESSION['account']}',
               '{$_POST['will1']}', '{$_POST['will2']}', '{$_POST['will3']}')";


?>