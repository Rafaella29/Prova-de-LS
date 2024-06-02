<?php
session_start();

// Verifica se o administrador está logado
if (!isset($_SESSION['usuario']) || $_SESSION['nivel_acesso_id'] != 1) {
    header("Location: ../pagina_login_registro/login.php");
    exit;
}

require_once '../db/conexao.php';

// Consulta SQL para buscar todos os usuários e seus níveis de acesso
$sql = "SELECT u.id, u.usuario, u.email, u.senha, u.nivel_acesso_id, na.descricao AS nivel_acesso 
        FROM usuarios u
        JOIN nivel_acesso na ON u.nivel_acesso_id = na.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Administrador</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require_once '../components/navbar.php'; ?>
    <div class="container">
        <h2 class="my-4">Página do Administrador</h2>
        
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#logoutModal">Logout</button>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createUserModal">Cadastrar Novo Usuário</button>

        <h4 class="my-4">Lista de Usuários</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Email</th>
                    <th>Senha</th>
                    <th>Nível de Acesso</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["usuario"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["senha"] . "</td>";
                        echo "<td>" . $row["nivel_acesso"] . "</td>";
                        echo "<td>
                                <button class='btn btn-primary' onclick='openUpdateModal(" . $row['id'] . ", \"" . $row['usuario'] . "\", \"" . $row['email'] . "\", \"" . $row['senha'] . "\", " . $row['nivel_acesso_id'] . ")'>Editar</button>
                                <button class='btn btn-danger' onclick='openDeleteModal(" . $row['id'] . ")'>Excluir</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>Nenhum usuário encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal de Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirmação de Logout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Tem certeza de que deseja sair?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <a href="../logout/logout.php" class="btn btn-danger">Sair</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Criação de Usuário -->
    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Cadastrar Novo Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="../crud/create.php" method="post">
                        <div class="form-group">
                            <label for="usuario">Usuário:</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="senha">Senha:</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>
                        <div class="form-group">
                            <label for="nivel_acesso">Nível de Acesso:</label>
                            <select class="form-control" id="nivel_acesso" name="nivel_acesso" required>
                                <option value="1">Administrador</option>
                                <option value="2">Usuário</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Edição de Usuário -->
    <div class="modal fade" id="updateUserModal" tabindex="-1" role="dialog" aria-labelledby="updateUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateUserModalLabel">Editar Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="updateUserModalBody">
                    <!-- Aqui será carregado o formulário de edição via JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Exclusão de Usuário -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Excluir Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="deleteUserModalBody">
                    <!-- Aqui será carregado o conteúdo da exclusão via JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function openUpdateModal(id, usuario, email, senha, nivel_acesso_id) {
            $('#updateUserModalBody').html(`
                <form action="../crud/update.php" method="post">
                    <input type="hidden" name="id" value="${id}">
                    <div class="form-group">
                        <label for="usuario">Usuário:</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" value="${usuario}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="${email}" required>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha:</label>
                        <input type="password" class="form-control" id="senha" name="senha" value="${senha}" required>
                    </div>
                    <div class="form-group">
                        <label for="nivel_acesso">Nível de Acesso:</label>
                        <select class="form-control" id="nivel_acesso" name="nivel_acesso" required>
                            <option value="1" ${nivel_acesso_id == 1 ? 'selected' : ''}>Administrador</option>
                            <option value="2" ${nivel_acesso_id == 2 ? 'selected' : ''}>Usuário</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </form>
            `);
            $('#updateUserModal').modal('show');
        }

        function openDeleteModal(id) {
            $('#deleteUserModalBody').html(`
                <p>Tem certeza que deseja excluir este usuário?</p>
                <a href="../crud/delete.php?id=${id}" class="btn btn-danger">Excluir</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            `);
            $('#deleteUserModal').modal('show');
        }
    </script>
</body>
</html>
