<?php
// Inclui o arquivo de configuração do banco de dados
require_once 'config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $numero = $_POST['numero'];
    $capacidade = $_POST['capacidade'];

    $sql = "UPDATE tables SET numero = ?, capacidade = ? WHERE id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("iii", $numero, $capacidade, $id);

    if ($stmt->execute()) {
        echo "Mesa atualizada com sucesso!";
    } else {
        echo "Erro ao atualizar mesa: " . $stmt->error;
    }

    $stmt->close();
    $link->close();
}
?>
