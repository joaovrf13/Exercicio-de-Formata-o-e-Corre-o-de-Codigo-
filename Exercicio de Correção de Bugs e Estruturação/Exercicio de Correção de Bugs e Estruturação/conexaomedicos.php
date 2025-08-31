<?php 


// conexão simples (MYSQLi procedural)
$host = "localhost";
$user = "root";
$pass = "";
$db   = "JoaoDB";

$con = mysqli_connect($host, $user, $pass, $db);
if (!$con) {
    die("Erro de conexão: " . mysqli_connect_error());
}


?>