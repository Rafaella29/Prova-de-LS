<?php
require_once '../db/conexao.php';

// Verifica se os dados do formulário foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepara os dados do formulário para inserção no banco de dados
    $usuario = $_POST["usuario"];
    $email = $_POST["email"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT); // Criptografa a senha antes de armazenar no banco de dados

    // Verifica se o email já existe no banco de dados
    $sql_check_email = "SELECT * FROM usuarios WHERE email='$email'";
    $result_check_email = $conn->query($sql_check_email);
    if ($result_check_email->num_rows > 0) {
        // Email já cadastrado, redireciona de volta para a página de registro com mensagem de erro
        header("Location: ../pagina_login_registro/registro.php?error=O email já está cadastrado. Por favor, utilize outro email.");
        exit;
    } else {
        // Email não cadastrado, insere o novo usuário no banco de dados
        $sql = "INSERT INTO usuarios (usuario, email, senha, nivel_acesso_id) VALUES ('$usuario', '$email', '$senha', 2)";

        if ($conn->query($sql) === TRUE) {
            // Usuário registrado com sucesso, redireciona para a página de registro com mensagem de sucesso
            header("Location: ../pagina_login_registro/registro.php?success=1");
            exit;
        } else {
            // Erro ao registrar o usuário, redireciona de volta para a página de registro com mensagem de erro
            header("Location: ../pagina_login_registro/registro.php?error=Erro ao registrar o usuário: " . $conn->error);
            exit;
        }
    }
} else {
    // Se o método da requisição não for POST, redireciona para a página de registro
    header("Location: register.php");
    exit;
}
?>
