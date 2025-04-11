<?php
// Inclui o arquivo de configuração do banco de dados
require_once "config.php";

// Verifica se o ID da mesa foi enviado via POST
if (isset($_POST['mesa_id']) && is_numeric($_POST['mesa_id'])) {
    $mesa_id = mysqli_real_escape_string($link, $_POST['mesa_id']);

    // Prepara a query para excluir a mesa
    $sql = "DELETE FROM tables WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind do parâmetro
        mysqli_stmt_bind_param($stmt, "i", $mesa_id);

        // Executa a query
        if (mysqli_stmt_execute($stmt)) {
            header("Location: gerente.php");
        } else {
            echo "Erro ao excluir a mesa: " . mysqli_error($link);
        }

        // Fecha a statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Erro na preparação da query: " . mysqli_error($link);
    }
} else {
    echo "ID da mesa inválido.";
}

$_POST = null;
// Fecha a conexão
mysqli_close($link);
?>