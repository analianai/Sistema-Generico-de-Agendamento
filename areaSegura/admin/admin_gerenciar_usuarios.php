<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['username']) || $_SESSION['nivel_acesso'] != 1) {
    header("Location: ../../sing_in.php?error=Acesso negado.");
    exit;
}

// Conexão com o banco de dados
$mysqli = new mysqli("localhost", "root", "", "salao");

// Verifica se houve erro na conexão
if ($mysqli->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $mysqli->connect_error);
}

// Obtenha o ID do usuário logado
$user_id = $_SESSION['user_id'];

// Consulta para buscar usuários cadastrados
$query = "SELECT id, nome, username, nivel_acesso FROM usuarios ORDER BY nome ASC";
$result = $mysqli->query($query);

if (!$result) {
    die('Erro ao executar a consulta: ' . $mysqli->error);
}

//deletar usuario
if (isset($_POST['deletar'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM usuarios WHERE id = $id";
    $result = $mysqli->query($query);
    if (!$result) {
        die('Erro ao executar a consulta: ' . $mysqli->error);
    }
    header("Location: admin_gerenciar_usuarios.php");
    exit;
}

//atualizar usuario
if (isset($_POST['atualizar'])) {
    $id = intval($_POST['id']);
    $novo_nivel = intval($_POST['nivel_acesso']);
    $username = $_POST['username'];

    $query = "UPDATE usuarios SET username = ? , nivel_acesso = ? WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sii', $username,$novo_nivel, $id);

    if ($stmt->execute()) {
        $_SESSION['mensagem_sucesso'] = "Nível e ou Email de acesso atualizado com sucesso!";
    } else {
        $_SESSION['mensagem_erro'] = "Erro ao atualizar nível de acesso e ou Email: " . $stmt->error;
    }
    header("Location: admin_gerenciar_usuarios.php");
    exit;
}
// Fecha a conexão com o banco de dados
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários</title>
        <!-- Bootstrap css-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap css Icons-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>
    <!-- Inclui o mensagem de erro -->
    <?php include '../../componentes/erro.php'; ?>
    <!-- memu -->
    <?php include '../../componentes/menuSeguro.php'; ?>
    <!-- cabeçalho -->
    <section id="cabecalho" class="container">
        <div class="mt-5">
            <h3 class="pt-5"><i class="bi bi-person-fill-gear"></i> Gerenciar Usuários</h3>
            <hr>
        </div>
    </section>
    <!-- Usuarios inseridos no sistema -->
    <!-- Usuarios inseridos no sistema -->
<section id="usuarios" class="container">
    <div class="mt-5">
        <h4>Usuários inseridos no sistema</h4>
        <hr>
    </div>
    <div class="table-responsive">
    <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>id</th>
                    <th>Nível de Acesso</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nome']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td>
                            <?php 
                                if ($row['nivel_acesso'] == 0) {
                                    echo "Usuário Comum";
                                } elseif ($row['nivel_acesso'] == 1) {
                                    echo "Administrador";
                                } else {
                                    echo "Desconhecido";
                                }
                            ?>
                        </td>
                        <td>
                            <!-- Botão DELETAR usuário -->
                            <form action="admin_gerenciar_usuarios.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="deletar" class="btn btn-danger">Deletar</button>
                            </form>
                            <!-- Botão ATUALIZAR usuário -->
                            <form action="admin_gerenciar_usuarios.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="email" name="username" class="form-control" id="username" placeholder="Email" value="<?php echo htmlspecialchars($row['username']); ?>" required>
                                <label for="nivel_acesso">Nível de Acesso:</label>
                                <select name="nivel_acesso" id="nivel_acesso" class="form-select" >
                                    <option value="" selected>Nível de Acesso</option>
                                    <option value="0" <?php echo $row['nivel_acesso'] == '0' ? 'selected' : 'Usuário Comum'; ?>>Usuário Comum</option>
                                    <option value="1" <?php echo $row['nivel_acesso'] == '1' ? 'selected' : 'Administrador'; ?>>Administrador</option>
                                </select>
                                <button type="submit" name="atualizar" class="btn btn-success">Atualizar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</section>
 
    <!-- Inclui o footer -->
    <?php include '../../componentes/footerSeguro.php'; ?>
</body>
</html>