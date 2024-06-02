<?php
require_once '../db/conexao.php';
session_start();

// Verifica se os dados do formulário foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepara os dados do formulário
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Consulta SQL para buscar o usuário pelo email
    $sql = "SELECT * FROM usuarios WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Usuário encontrado, verifica se a senha está correta
        $row = $result->fetch_assoc();
        if (password_verify($senha, $row["senha"])) {
            // Senha correta, define a sessão do usuário
            $_SESSION['usuario'] = $row['usuario'];
            $_SESSION['nivel_acesso_id'] = $row['nivel_acesso_id'];

            // Redireciona o usuário com base no seu nível de acesso
            if ($_SESSION['nivel_acesso_id'] == 1) {
                // Nível de acesso do admin
                header("Location: ../pagina_nivel_de_acesso/admin_page.php");
                exit;
            } else {
                // Nível de acesso do usuário normal
                header("Location: ../pagina_nivel_de_acesso/user_page.php");
                exit;
            }
        } else {
            // Senha incorreta, redireciona de volta para a página de login com mensagem de erro
            header("Location: ../pagina_login_registro/login.php?error=Senha incorreta. Por favor, tente novamente.");
            exit;
        }
    } else {
        // Email não encontrado, redireciona de volta para a página de login com mensagem de erro
        header("Location: ../pagina_login_registro/login.php?error=Email não cadastrado. Por favor, registre-se.");
        exit;
    }
} else {
    // Se o método da requisição não for POST, redireciona para a página de login
    header("Location: ../pagina_login_registro/login.php");
    exit;
}
?>
