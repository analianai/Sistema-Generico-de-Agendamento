<?php
session_start();

// verifica a conexão por nivel de acesso
if (!isset($_SESSION['username']) || $_SESSION['nivel_acesso'] != 0) {
    header("Location: ../sign_in.php?error=Acesso negado.");
    exit;
}

// conexão ao banco de dados
$mysqli = new mysqli("localhost", "root", "", "salao");

if ($mysqli->connect_error) {
    die("Erro na conexão com o banco de dados: " . $mysqli->connect_error);
}

// Inserir depoimentos
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['inserir'])) {
    $user_id = $_SESSION['user_id']; // Pegue o ID do usuário logado da sessão
    $nome = $_SESSION['nome']; 
    $comentario = isset($_POST['comentario']) ? trim($_POST['comentario']) : null;

    // Validação básica
    if (empty($comentario)) {
        $_SESSION['mensagem_erro'] = "O campo de comentário é obrigatório.";
    } else {
        // Insere o depoimento no banco de dados
        $stmt = $mysqli->prepare("INSERT INTO depoimentos (user_id, comentario, aprovacao) VALUES (?, ?, ?)");
        $aprovacao = 0; // Inicialmente o depoimento não aprovado
        $stmt->bind_param("isi", $user_id, $comentario, $aprovacao);
        
        if ($stmt->execute()) {
            $_SESSION['mensagem_sucesso'] = "Depoimento enviado com sucesso! Aguarde a aprovação.";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao enviar o depoimento: " . $stmt->error;
        }

        $stmt->close();
    }

    // Redireciona para evitar reenvio do formulário
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// Função de exclusão
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $depoimento_id = intval($_POST['depoimento_id']);
    $user_id = $_SESSION['user_id']; // ID do usuário logado

    // Verifica se o depoimento pertence ao usuário logado antes de excluir
    $stmt = $mysqli->prepare("DELETE FROM depoimentos WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $depoimento_id, $user_id);

    if ($stmt->execute()) {
        $_SESSION['mensagem_sucesso'] = "Depoimento excluído com sucesso.";
    } else {
        $_SESSION['mensagem_erro'] = "Erro ao excluir o depoimento.";
    }

    $stmt->close();

    // Redireciona para evitar reenvio do formulário
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Função de atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $depoimento_id = intval($_POST['depoimento_id']);
    $novo_comentario = trim($_POST['comentario']);
    $user_id = $_SESSION['user_id']; // ID do usuário logado

    // Validação básica
    if (empty($novo_comentario)) {
        $_SESSION['mensagem_erro'] = "O comentário não pode estar vazio.";
    } else {
        // Atualiza o depoimento no banco de dados
        $stmt = $mysqli->prepare("UPDATE depoimentos SET comentario = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("sii", $novo_comentario, $depoimento_id, $user_id);

        if ($stmt->execute()) {
            $_SESSION['mensagem_sucesso'] = "Depoimento atualizado com sucesso.";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao atualizar o depoimento.";
        }

        $stmt->close();
    }

    // Redireciona para evitar reenvio do formulário
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Recuperar depoimentos do usuário logado
$user_id = $_SESSION['user_id'];
$query = $mysqli->prepare("SELECT id, comentario, aprovacao, data_criacao FROM depoimentos WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();

$depoimentos = [];
while ($row = $result->fetch_assoc()) {
    $depoimentos[] = $row;
}

$query->close();
$mysqli->close();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salão de Beleza User Dashboard</title>
    <!-- Bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap css Icons-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .tamanho{
            width: 15rem;
            height: 15rem;
            font-size: 2em;
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
        .bg-lilas{
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
    <!-- Inclui o mensagem de erro -->
    <?php include '../../componentes/erro.php'; ?>
    <!-- Inclui o menu seguro -->
    <?php include '../../componentes/menuSeguro.php'; ?>
    <!--cabecalho-->
    <section class="container">
        <div class="mt-5">
            <h3 class="pt-5">
                <a class="link-offset-2 link-underline link-underline-opacity-0 text-dark" href="user_dashboard.php">
                    <i class="bi bi-house-check-fill"></i> Home
                </a>
            </h3>
            <hr class="mt-3">
        </div>
    </section>

    <section id="user_servicos">
    <!--Buttons -->
        <div class="container text-center">
            <div class="row align-items-start">
                <div class="col">
                    <button onclick="window.location.href='user_agendamento.php'" type="button" class="btn btn-outline-primary mb-3 tamanho"><i class="bi bi-journal-text"></i><br>Agendamento</button>
                </div>
                <div class="col">
                    <button onclick="window.location.href='user_servicos.php'" type="button" class="btn btn-outline-secondary mb-3 tamanho"><i class="bi bi-house-gear-fill"></i><br>Serviços</button>
                </div>
                <div class="col ">
                    <button onclick="window.location.href='user_perfil.php'" type="button" class="btn btn-outline-danger mb-3 tamanho"><i class="bi bi-person-check-fill"></i><br>Meu Perfil</button>
                </div>
            </div>
        </div>       
    </section>

    <!--Depoimentos-->
    <section class="container mt-4">
        <div id="cabecalho" class="container mb-4">
            <div class="mt-5 d-flex justify-content-between">
                <h4><i class="bi bi-megaphone"></i> Depoimentos</h4>
                <a type="button" class="btn text-primary" data-bs-toggle="modal" data-bs-target="#depoimentosModal">
                    <i class="bi bi-plus"></i> Novo Depoimento
                </a>           
            </div>
            <hr>
        </div>
        <div class="mt-1">
            <?php if (!empty($depoimentos)): ?>
                <div class="row g-3"> <!-- g-3 adiciona espaçamento entre os itens -->
                    <?php foreach ($depoimentos as $depoimento): ?>
                        <div class="col-12 col-md-6 col-lg-4"> <!-- Responsivo: 1 item em telas pequenas, 2 em médias, 3 em grandes -->
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-text"  style="text-align: justify;">"<?= htmlspecialchars($depoimento['comentario']) ?>"</p>
                                    <p class="card-text text-end me-2"><?= htmlspecialchars($_SESSION['nome']);?></p>
                                    <small class="text-muted">
                                        Enviado em: <?= date('d/m/Y', strtotime($depoimento['data_criacao'])) ?>
                                        || Status: <?= $depoimento['aprovacao'] == 0 ? 'Pendente' : 'Aprovado' ?>
                                    </small>
                                    <div class="mt-3 text-center d-flex justify-content-center">
                                        <!--Botão atualizar-->
                                        <button type="button" class="btn btn-outline-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editarDepoimentoModal<?= $depoimento['id'] ?>">
                                            <i class="bi bi-arrow-repeat"></i>
                                        </button>
                                        <!-- Modal para Atualizar Depoimento -->
                                        <div class="modal fade" id="editarDepoimentoModal<?= $depoimento['id'] ?>" tabindex="-1" aria-labelledby="editarDepoimentoModalLabel<?= $depoimento['id'] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-center text-white">
                                                        <h5 class="modal-title w-100 fs-3" id="editarDepoimentoModalLabel<?= $depoimento['id'] ?>">Atualizar Depoimento</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="" method="post">
                                                            <input type="hidden" name="depoimento_id" value="<?= $depoimento['id'] ?>">
                                                            <textarea class="form-control" id="comentario" name="comentario" rows="x" maxlength="90"><?= htmlspecialchars($depoimento['comentario']) ?></textarea>
                                                            <div id="contador">90/90</div>
                                                            <div class="mt-3 text-center">
                                                                <button type="button" class="btn btn-outline-danger me-2" data-bs-dismiss="modal"><i class="bi bi-x-octagon-fill"></i> Cancelar</button>
                                                                <button type="submit" name="update" class="btn btn-outline-primary"><i class="bi bi-arrow-repeat"></i> Salvar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Butão deletar-->
                                        <button type="button" class="btn btn-outline-danger btn-sm me-2" data-bs-toggle="modal" data-bs-target="#excluirDepoimentoModal<?= $depoimento['id'] ?>">
                                        <i class="bi bi-trash"></i>
                                        </button>
                                        <!-- Modal para deletar Depoimento -->
                                        <div class="modal fade" id="excluirDepoimentoModal<?= $depoimento['id'] ?>" tabindex="-1" aria-labelledby="excluirDepoimentoModalLabel<?= $depoimento['id'] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white text-center">
                                                        <h5 class="modal-title w-100 text-white" id="excluirDepoimentoModalLabel<?= $depoimento['id'] ?>">Deseja Excluir Depoimento?</h5>
                                                        <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg fs-5"></i></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="" method="post">
                                                            <input type="hidden" name="depoimento_id" value="<?= $depoimento['id'] ?>">
                                                            <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal"><i class="bi bi-backspace-fill"></i> Voltar</button>
                                                            <button type="submit" name="delete" class="btn btn-outline-danger"><i class="bi bi-trash"></i> Sim</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Você ainda não enviou nenhum depoimento.</p>
            <?php endif; ?>
        </div>
        <!-- Modal inserir depoimentos-->
        <div class="modal fade" id="depoimentosModal" tabindex="-1" aria-labelledby="depoimentosModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center bg-lilas text-white">
                        <h5 class="modal-title w-100" id="depoimentosModalLabel"> Deixe seu Depoimento</h5>
                        <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg fs-5"></i></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" novalidate>
                            <div class="mb-3">
                                <textarea class="form-control" id="comentario" name="comentario" rows="x" maxlength="90" placeholder="Escreva seu depoimento"></textarea>
                                <div id="contador">90/90</div>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-outline-danger me-2" data-bs-dismiss="modal"><i class="bi bi-x-octagon-fill"></i> Cancelar</button>
                                <button type="submit" name="inserir" class="btn btn-outline-success"><i class="bi bi-backspace-reverse-fill"></i> Criar Depoimento</button>
                            </div>
                        </form>
                    </div>       
                </div>
            </div>
        </div> 
    </section>

    <!-- Historico de Agendamento-->
    <section id="Hitorico" class="container mt-5">
        <div class="mt-3 mb-5">
            <div class="mt-2 mb-4">
                <h4><i class="bi bi-journal-check"></i> Histórico de Agendamento</h4>
                <hr>
            </div>
            <div class="container-sm">
                <div class="table-responsive">
                    <table class="table mt-3 border-primary table-hover ">
                        <thead>
                        <thead class="table-primary text-center">
                            <th scope="col">#</th> 
                            <th scope="col">Nome</th>
                            <th scope="col">Horário</th>
                            <th scope="col">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th class="text-center" scope="row">1</th>
                            <td>Mark</td>
                            <td class="text-center">Otto</td>
                            <td class="text-center">
                                <i class="bi bi-eye text-primary fs-5"></i>
                                <i class="bi bi-arrow-repeat text-success fs-5"></i>
                                <i class="bi bi-trash3 text-danger fs-5"></i>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center" scope="row">2</th>
                            <td>Jacob</td>
                            <td class="text-center" >Thornton</td>
                            <td class="text-center">
                                <i class="bi bi-eye text-primary fs-5"></i>
                                <i class="bi bi-arrow-repeat text-success fs-5"></i>
                                <i class="bi bi-trash3 text-danger fs-5"></i>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center" scope="row">3</th>
                            <td>@twitter</td>
                            <td class="text-center">@mdo</td>
                            <td class="text-center">
                                <i class="bi bi-eye text-primary fs-5"></i>
                                <i class="bi bi-arrow-repeat text-success fs-5"></i>
                                <i class="bi bi-trash3 text-danger fs-5"></i>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <?php include '../../componentes/footerSeguro.php'; ?>
    <script>
        $("#comentario").keyup(function(){
            if($(this).val().length >= 90){
                $(this).val( $(this).val().substr(0, 90) );
            } else {
                $("#contador").text(90-$(this).val().length+"/90");
            }
        });
    </script>
</body>
</html>