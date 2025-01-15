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
$query = "
    SELECT 
        usuarios.id AS usuario_id, 
        usuarios.nome, 
        usuarios.sobrenome, 
        depoimentos.id AS depoimento_id, 
        depoimentos.comentario, 
        depoimentos.aprovacao, 
        depoimentos.data_criacao
    FROM 
        usuarios
    LEFT JOIN 
        depoimentos 
    ON 
        usuarios.id = depoimentos.user_id
    ORDER BY 
        usuarios.nome ASC
";
$result = $mysqli->query($query);

if (!$result) {
    die('Erro ao executar a consulta: ' . $mysqli->error);
}

$usuarios = [];
while ($row = $result->fetch_assoc()) {
    $usuario_id = $row['usuario_id'];

    if (!isset($usuarios[$usuario_id])) {
        $usuarios[$usuario_id] = [
            'usuario_id' => $row['usuario_id'],
            'nome' => $row['nome'],
            'sobrenome' => $row['sobrenome'],
            'depoimentos' => []
        ];
    }

    if (!empty($row['depoimento_id'])) { // Adiciona depoimentos apenas se existirem
        $usuarios[$usuario_id]['depoimentos'][] = [
            'depoimento_id' => $row['depoimento_id'], // Inclui o ID do depoimento
            'comentario' => $row['comentario'],
            'aprovacao' => $row['aprovacao'],
            'data_criacao' => $row['data_criacao']
        ];
    }    
}

// Função de exclusão
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    var_dump($_POST['depoimento_id']); // Verifique se o ID do depoimento está correto
    $depoimento_id = intval($_POST['depoimento_id']);
    $stmt = $mysqli->prepare("DELETE FROM depoimentos WHERE id = ?");
    
    if ($stmt) {
        $stmt->bind_param("i", $depoimento_id);

        if ($stmt->execute()) {
            $_SESSION['mensagem_sucesso'] = "Depoimento excluído com sucesso.";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao excluir o depoimento.";
        }

        $stmt->close();
    } else {
        $_SESSION['mensagem_erro'] = "Erro ao preparar a consulta.";
    }

    // Redireciona para evitar reenvio do formulário
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Função de alteração de status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alterar_status'])) {
    $depoimento_id = intval($_POST['depoimento_id']);
    
    // Verifica o status atual e alterna
    $query = "SELECT aprovacao FROM depoimentos WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $depoimento_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $novo_status = $row['aprovacao'] == 1 ? 0 : 1; // Alterna entre 0 (Pendente) e 1 (Aprovado)
        
        // Atualiza o status
        $update_query = "UPDATE depoimentos SET aprovacao = ? WHERE id = ?";
        $update_stmt = $mysqli->prepare($update_query);
        $update_stmt->bind_param("ii", $novo_status, $depoimento_id);
        
        if ($update_stmt->execute()) {
            $_SESSION['mensagem_sucesso'] = "Status do depoimento alterado com sucesso.";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao alterar o status do depoimento.";
        }

        $update_stmt->close();
    } else {
        $_SESSION['mensagem_erro'] = "Depoimento não encontrado.";
    }

    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}


$cont = 0;
// Fecha a conexão com o banco de dados
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salão de Beleza Admin Dashboard</title>
    <!-- Bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap css Icons-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .tamanho{
            width: 10rem;
            height: 8rem;
            font-size: 1em;
        }
        .btn-outline-lilas{
            color: #6f42c1;
            border-color: #6f42c1;
        }
        .btn-outline-lilas:hover{
            color: #fff;
            border-color: #6f42c1;
            background-color: #6f42c1;
        }
        #mensagem-sucesso, #mensagem-erro {
            position: fixed; /* Fixar a mensagem no topo da página */
            top: 20px; /* Distância do topo */
            left: 50%; /* Centraliza horizontalmente */
            transform: translateX(-50%); /* Ajusta a posição centralizada */
            z-index: 1050; /* Garante que a mensagem esteja acima de outros elementos */
            width: auto; /* Ajusta largura */
            max-width: 80%; /* Evita que a mensagem ocupe toda a tela */
        }
    </style>
</head>
<body>
<?php include '../../componentes/erro.php'; ?>
    <?php include '../../componentes/menuSeguro.php'; ?>
    <!-- cabeçalho -->
    <section id="cabecalho" class="container">
        <div class="mt-5 d-flex justify-content-between">
            <h3 class="pt-5"><i class="bi bi-megaphone"></i>  Depoimentos</h3>
            <a href="admin_dashboard.php" type="button" class="btn-close pt-5 mt-4" aria-label="Close"></a>           
        </div>
        <hr>
    </section>
    <section id="usuarios" class="container">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th class="text-center">Nome</th>
                        <th class="text-center">Depoimentos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario) : ?>
                    <tr>
                        <th scope="row"><?= ++$cont ?></th>
                        <td><?php echo htmlspecialchars($usuario['nome'] . ' ' . $usuario['sobrenome']); ?></td>
                        <td class="text-center">

                        <!-- Botão Visualizar usuário -->
                        <button type="button" class="btn btn-outline-primary text-center" data-bs-toggle="modal" data-bs-target="#modalvisualizar<?php echo $usuario['usuario_id']; ?>">
                            <i class="bi bi-eye"></i> Visualizar
                        </button>

                        <!-- Modal Visualizar depoimento de usuário -->
                        <div class="modal modal-lg" id="modalvisualizar<?php echo $usuario['usuario_id']; ?>" tabindex="-1" aria-labelledby="modalvisualizarLabel<?php echo $usuario['usuario_id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white text-center">
                                        <h5 class="modal-title w-100" id="modalvisualizarLabel<?php echo $usuario['usuario_id']; ?>">
                                            <?php echo htmlspecialchars($usuario['nome'] . ' ' . $usuario['sobrenome']); ?>
                                        </h5>
                                        <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg fs-5"></i></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php if (empty($usuario['depoimentos'])) : ?>
                                            <p>Nenhum depoimento disponível.</p>
                                        <?php else : ?>
                                            <div class="row g-3">
                                                <?php foreach ($usuario['depoimentos'] as $depoimento) : ?>
                                                    <div class="col-md-6">
                                                        <div class="card shadow-sm">
                                                            <div class="card-body">
                                                                <p>"<?= htmlspecialchars($depoimento['comentario']); ?>"</p>
                                                                <small>
                                                                    Enviado em: <i><?= date('d/m/Y', strtotime($depoimento['data_criacao'])); ?></i><br>
                                                                    Status: <i><?= $depoimento['aprovacao'] ? 'Aprovado' : 'Pendente'; ?></i>
                                                                </small>
                                                                <div class="d-flex justify-content-center">
                                                                    <!-- Botão para Aprovar ou Desaprovar -->
                                                                    <form method="POST" action="">
                                                                        <input type="hidden" name="depoimento_id" value="<?= $depoimento['depoimento_id']; ?>">
                                                                        <button type="submit" name="alterar_status" class="btn btn-<?= $depoimento['aprovacao'] ? 'outline-danger' : 'outline-success'; ?> mt-2 me-4">
                                                                            <?= $depoimento['aprovacao'] ? '<i class="bi bi-slash-circle"></i> Desaprovar' : '<i class="bi bi-check2-circle"></i> Aprovar'; ?>
                                                                        </button>
                                                                    </form>

                                                                    <!-- Formulário de exclusão com alerta -->
                                                                    <form method="POST" action="" onsubmit="return confirmarExclusao(this);">
                                                                        <input type="hidden" name="depoimento_id" value="<?= $depoimento['depoimento_id']; ?>">
                                                                        <button type="submit" class="btn btn-outline-danger mt-2" name="delete"><i class="bi bi-trash3"></i> Excluir</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <!-- Script para confirmação de exclusão -->
    <script>
        function confirmarExclusao(form) {
            // Alerta de confirmação
            const confirmacao = confirm('Tem certeza que deseja excluir este depoimento? Esta ação não pode ser desfeita.');

            if (confirmacao) {
                return true;  // Permite a exclusão
            } else {
                return false; // Cancela a exclusão
            }
        }
    </script>

    <?php include '../../componentes/footerSeguro.php'; ?>
</body>
</html>
