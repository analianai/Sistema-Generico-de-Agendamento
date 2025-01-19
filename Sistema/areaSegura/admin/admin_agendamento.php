<?php
session_start();

if (!isset($_SESSION['username']) || ($_SESSION['nivel_acesso'] != 0 && $_SESSION['nivel_acesso'] != 1)) {
    header("Location: ../../sign_in.php?error=Acesso negado.");
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

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário
    $user_id = $_SESSION['user_id']; // O ID do usuário logado
    $servico_id = $_POST['servico_id'];
    $categoria_id = $_POST['categoria_id'];
    $data_hora = $_POST['data_hora'];
    $observacoes = $_POST['observacoes'];
    $status = 'PENDENTE'; // Status inicial será PENDENTE

    // Recupera a duração do serviço selecionado
    $queryServico = "SELECT duracao FROM servicos WHERE id = ?";
    $stmtServico = $mysqli->prepare($queryServico);
    $stmtServico->bind_param("i", $servico_id);
    $stmtServico->execute();
    $stmtServico->bind_result($duracao);
    $stmtServico->fetch();
    $stmtServico->close();

    // Prepara e executa a consulta para inserir o agendamento// Preparar a consulta
$stmt = $mysqli->prepare("INSERT INTO agendamentos (user_id, servico_id, categoria_id, data_hora, duracao, status, observacoes) VALUES (?, ?, ?, ?, ?, ?, ?)");

// Verifique se a consulta foi preparada corretamente
if ($stmt === false) {
    // Exibe um erro detalhado
    die("Erro ao preparar a consulta: " . $mysqli->error);
}

// Formatar a data para o formato correto do banco de dados
$data_hora = date('Y-m-d H:i:s', strtotime($data_hora)); 

// Fazer o bind dos parâmetros corretamente
$stmt->bind_param("iiissss", $user_id, $servico_id, $categoria_id, $data_hora, $duracao, $status, $observacoes);

// Executar a consulta
if ($stmt->execute()) {
    // Sucesso - redireciona ou define mensagem de sucesso
    $_SESSION['mensagem_sucesso'] = 'Agendamento realizado com sucesso!';
    $stmt->close();
    header("Location: admin_agendamentos.php"); // Ou qualquer página que deseje redirecionar
    exit;
} else {
    // Caso de erro - armazena a mensagem de erro na sessão
    $_SESSION['mensagem_erro'] = 'Erro ao realizar o agendamento: ' . $stmt->error;
    $stmt->close();
    header("Location: admin_agendamentos.php"); // Redireciona para a página de agendamentos
    exit;
}
 
}

// Consulta para visualizar os agendamentos do usuário
$user_id = $_SESSION['user_id'];  // O ID do usuário logado

$queryAgendamentos = "SELECT ag.id, s.titulo, c.nome AS categoria, ag.data_hora, ag.duracao, ag.status, ag.observacoes 
                      FROM agendamentos ag
                      JOIN servicos s ON ag.servico_id = s.id
                      JOIN categorias c ON ag.categoria_id = c.cat_id
                      WHERE ag.user_id = ? ORDER BY ag.data_hora DESC";

$stmt = $mysqli->prepare($queryAgendamentos);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$resultAgendamentos = $stmt->get_result();

// Consulta as categorias para exibir no formulário
$queryCategorias = "SELECT * FROM categorias";
$resultCategorias = $mysqli->query($queryCategorias);

// Consulta os serviços para exibir no formulário
$queryServicos = "SELECT * FROM servicos";
$resultServicos = $mysqli->query($queryServicos);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento</title>
    <!-- Bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap css Icons-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
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
    <!-- erro -->
    <?php include '../../componentes/erro.php'; ?>
    <!-- menu -->
    <?php include '../../componentes/menuSeguro.php'; ?>

    <section id="cabecalho" class="container">
        <div class="mt-5 d-flex justify-content-between">
            <h3 class="pt-5"><i class="bi bi-calendar"></i> Agendamento</h3>
            <a href="admin_dashboard.php" type="button" class="btn-close pt-5 mt-4" aria-label="Close"></a>           
        </div>
        <hr>
    </section>

    <section id="cadastrar_agendamento" class="container">
        <form method="POST">
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria</label>
                <select class="form-select" id="categoria" name="categoria_id" required>
                    <option selected disabled>Selecione uma categoria</option>
                    <?php
                    while ($categoria = $resultCategorias->fetch_assoc()) {
                        echo "<option value='{$categoria['cat_id']}'>{$categoria['nome']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="servico" class="form-label">Serviço</label>
                <select class="form-select" id="servico" name="servico_id" required>
                    <option selected disabled>Selecione um serviço</option>
                    <?php
                    while ($servico = $resultServicos->fetch_assoc()) {
                        echo "<option value='{$servico['id']}' data-duracao='{$servico['duracao']}'>{$servico['titulo']} - R$ {$servico['valor']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="data_hora" class="form-label">Data e Hora</label>
                <input type="datetime-local" class="form-control" id="data_hora" name="data_hora" required>
            </div>
            <div class="mb-3">
                <label for="observacoes" class="form-label">Observações</label>
                <textarea class="form-control" id="observacoes" name="observacoes" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="duracao" class="form-label">Duração (minutos)</label>
                <input type="number" class="form-control" id="duracao" name="duracao" required readonly>
            </div>
            <button type="submit" class="btn btn-primary">Agendar</button>
        </form>
    </section>

    <section id="vizualizar_agendamento" class="container mt-5">
        <!-- Exibir agendamentos -->
        <?php if ($resultAgendamentos->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Serviço</th>
                            <th>Categoria</th>
                            <th>Data e Hora</th>
                            <th>Duração</th>
                            <th>Status</th>
                            <th>Observações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($agendamento = $resultAgendamentos->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $agendamento['id']; ?></td>
                                <td><?php echo $agendamento['titulo']; ?></td>
                                <td><?php echo $agendamento['categoria']; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($agendamento['data_hora'])); ?></td>
                                <td><?php echo $agendamento['duracao']; ?> minutos</td>
                                <td><?php echo $agendamento['status']; ?></td>
                                <td><?php echo $agendamento['observacoes']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>Você ainda não tem agendamentos.</p>
        <?php endif; ?>
    </section>

    <script>
        // Função para atualizar a duração ao selecionar o serviço
        document.getElementById('servico').addEventListener('change', function() {
            var duracao = this.options[this.selectedIndex].getAttribute('data-duracao');
            document.getElementById('duracao').value = duracao;
        });
    </script>

    <?php include '../../componentes/footerSeguro.php'; ?>
</body>
</html>
