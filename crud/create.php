<?php
require_once '../db/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $nivel_acesso = $_POST['nivel_acesso'];

    // Verifica se o email já existe
    $checkEmail = "SELECT * FROM usuarios WHERE email='$email'";
    $result = $conn->query($checkEmail);
    if ($result->num_rows > 0) {
        echo "<script>alert('Este email já está registrado!'); window.history.back();</script>";
        exit;
    }

    // Hash da senha
    $hashedSenha = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (usuario, email, senha, nivel_acesso_id) VALUES ('$usuario', '$email', '$hashedSenha', '$nivel_acesso')";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../pagina_nivel_de_acesso/admin_page.php");
        exit;
    } else {
        echo "Erro ao inserir novo usuário: " . $conn->error;
    }
}
?>
