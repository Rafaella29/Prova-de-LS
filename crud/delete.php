<?php
require_once '../db/conexao.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM usuarios WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../pagina_nivel_de_acesso/admin_page.php");
        exit;
    } else {
        echo "Erro ao excluir usuário: " . $conn->error;
    }
}
?>
