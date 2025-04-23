<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Exemplo PHP</title>
</head>
<body>

<?php
// Ativa exibição de erros
ini_set("display_errors", 1);
error_reporting(E_ALL);

echo 'Versão Atual do PHP: ' . phpversion() . '<br>';

// Dados de conexão
$servername = "54.234.153.24";
$username = "root";
$password = "Senha123";
$database = "meubanco";

try {
    // Criação de conexão
    $conn = new mysqli($servername, $username, $password, $database);
    
    // Verificação da conexão
    if ($conn->connect_error) {
        throw new Exception("Conexão falhou: " . $conn->connect_error);
    }

    // Gerar dados aleatórios
    $alunoID = rand(1, 999);
    $nome = strtoupper(substr(bin2hex(random_bytes(4)), 1));
    $sobrenome = $nome;
    $endereco = $nome;
    $cidade = $nome;
    $host = gethostname();

    // Preparar e executar inserção
    $stmt = $conn->prepare("INSERT INTO dados (AlunoID, Nome, Sobrenome, Endereco, Cidade, Host) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $alunoID, $nome, $sobrenome, $endereco, $cidade, $host);

    if ($stmt->execute()) {
        echo "Novo registro criado com sucesso.";
    } else {
        echo "Erro ao inserir: " . $stmt->error;
    }

    // Fechar recursos
    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>

</body>
</html>
