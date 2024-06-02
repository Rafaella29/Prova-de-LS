<?php
session_start();

// Destroi todas as variáveis de sessão
session_destroy();

// Redireciona para a página de login
header("Location: ../pagina_login_registro/login.php");
exit;
?>
