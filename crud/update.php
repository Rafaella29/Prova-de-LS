<?php
require_once '../db/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $nivel_acesso = $_POST['nivel_acesso'];

    $sql = "UPDATE usuarios SET usuario='$usuario', email='$email', senha='$senha', nivel_acesso_id='$nivel_acesso' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../pagina_nivel_de_acesso/admin_page.php");
        exit;
    } else {
        echo "Erro ao atualizar usuário: " . $conn->error;
    }
}
?>
