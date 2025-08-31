<?php

require 'conexaomedicos.php';

$msg = "";

// Cadastro de médico
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome  = $_POST["nome"] ?? "";
    $crm   = $_POST["crm"] ?? "";
    $esp   = $_POST["especialidade"] ?? "";

    //problema corrigido com o regex 
    // ^ -----> define o inicio 
    // [0-9]{6} ----> mostra em qual intervalo está os valores e quantas vezes ele pode aparecer
    // -  ------> separa 
    //[A-Z]{2} --------> aceita letras maiusculas de A a Z, elas podem aparecer somente duas vezes
    // $ ---------> marca o fim da string 

    if(preg_match('/^[0-9]{6}-[A-Z]{2}$/', $crm)){
          $sql = "INSERT INTO medicos (nome, crm, especialidade) 
            VALUES ('$nome', '$crm', '$esp')";

    if (mysqli_query($con, $sql)) {
        $msg = "Médico cadastrado com sucesso!";
    } else {
        $msg = "Erro ao cadastrar: " . mysqli_error($con);
    }
    } 
  
}

// Buscar médicos
$res = mysqli_query($con, "SELECT * FROM medicos ORDER BY id DESC");
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Cadastro de Médicos</title>
  <style>
    body { font-family: Arial, sans-serif; background:#eef2ff; padding:20px; }
    .form, .lista { background:#fff; padding:15px; border-radius:8px; margin-bottom:20px; }
    label { display:block; margin-top:10px; }
    input { padding:6px; width:250px; }
    button { margin-top:12px; padding:6px 14px; cursor:pointer; }
    table { border-collapse: collapse; width:100%; margin-top:15px; }
    th, td { border:1px solid #ccc; padding:8px; text-align:left; }
  </style>
</head>
<body>
  <h1>Cadastro de Médicos</h1>

  <?php if ($msg): ?>
    <p><b><?php echo htmlspecialchars($msg); ?></b></p>
  <?php endif; ?>

 
