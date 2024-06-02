<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            max-width: 500px;
        }
        .card {
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php require_once '../components/navbar.php'; ?>
    <div class="container">
        <div class="card">
            <h2 class="text-center">Registrar</h2>
            <!-- Div para exibir a mensagem de erro -->
            <?php if(isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert"><?php echo $_GET['error']; ?></div>
            <?php } ?>
            <!-- Div para exibir a mensagem de sucesso -->
            <?php if(isset($_GET['success'])) { ?>
                <div class="alert alert-success" role="alert">Usuário registrado com sucesso!</div>
            <?php } ?>
            <!-- Formulário de registro -->
            <form action="../verificacao/processo_registro.php" method="POST">
                <div class="form-group">
                    <label for="usuario">Usuário</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" required>
                </div>
                <button type="submit" class="btn btn-success btn-block">Registrar</button>
            </form>
            <!-- Link para login -->
            <p class="text-center mt-3">
                Já tem uma conta? <a href="../pagina_login_registro/login.php">Faça login</a>
            </p>
        </div>
    </div>
    <!-- Bootstrap JS e dependências -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
