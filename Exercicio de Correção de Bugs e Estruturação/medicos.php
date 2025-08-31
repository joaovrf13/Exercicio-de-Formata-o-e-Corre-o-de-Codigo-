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

$msg = "";

// Cadastro de médico
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome  = $_POST["nome"] ?? "";
    $crm   = $_POST["crm"] ?? "";
    $esp   = $_POST["especialidade"] ?? "";

    // ❌ PROBLEMA INTENCIONAL: não valida se CRM tem tamanho correto
    $sql = "INSERT INTO medicos (nome, crm, especialidade) 
            VALUES ('$nome', '$crm', '$esp')";

    if (mysqli_query($con, $sql)) {
        $msg = "Médico cadastrado com sucesso!";
    } else {
        $msg = "Erro ao cadastrar: " . mysqli_error($con);
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

  <div class="form">
    <form method="post">
      <label>Nome: <br>
        <input type="text" name="nome" required>
      </label>
      <label>CRM: <br>
        <input type="text" name="crm" required placeholder="123456-MG">
      </label>
      <label>Especialidade: <br>
        <input type="text" name="especialidade" required placeholder="Cardiologia">
      </label>
      <button type="submit">Salvar</button>
    </form>
  </div>

  <div class="lista">
    <h2>Médicos cadastrados</h2>
    <table>
      <tr><th>ID</th><th>Nome</th><th>CRM</th><th>Especialidade</th></tr>
      <?php while ($row = mysqli_fetch_assoc($res)): ?>
        <tr>
          <td><?php echo $row["id"]; ?></td>
          <td><?php echo htmlspecialchars($row["nome"]); ?></td>
          <td><?php echo htmlspecialchars($row["crm"]); ?></td>
          <td><?php echo htmlspecialchars($row["especialidade"]); ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>
</body>
</html>
