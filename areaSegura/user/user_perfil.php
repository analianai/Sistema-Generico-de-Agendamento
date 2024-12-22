<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['username'])) {
    // Redireciona para a página de login se não estiver logado
    header('Location: sing_in.php');
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

// Consulta para obter os dados do usuário
$query = "SELECT nome, sobrenome, celular, endereco FROM usuarios WHERE id = ?";
$stmt = $mysqli->prepare($query);

if (!$stmt) {
    die("Erro na preparação da consulta: " . $mysqli->error);
}

$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se o usuário foi encontrado
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Erro: Usuário não encontrado.";
    exit;
}

// Fecha a conexão
$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salão de Beleza Perfil Dashboard</title>
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
    </style>
</head>
<body>
    <!-- Inclui o menu seguro -->
    <?php include '../../componentes/menuSeguro.php'; ?>
    <section class="container">
        <div class="mt-5 d-flex justify-content-between">
            <h3 class="pt-5"><i class="bi bi-person-check-fill"></i> Meu Perfil</h3>
            <a href="user_dashboard.php" type="button" class="btn-close pt-5 mt-4" aria-label="Close"></a>
        </div>
        <hr>
    </section>
    <div class="container">
        <div class="row">
            <div class="col">
                <p><strong>Nome:</strong> <?php echo htmlspecialchars($user['nome'] . ' ' . $user['sobrenome']); ?></p>
                <p><strong>Celular (WhatsApp):</strong> <?php echo htmlspecialchars($user['celular']); ?></p>
                <p><strong>Endereço:</strong> <?php echo htmlspecialchars($user['endereco']); ?></p>
        
            </div>
        </div>
        <div class="container text-center mt-5 mb-5 ">
            <div class="row justify-content-end">
                <div class="col col-sm-4">
                    <button type="button" class="btn btn-outline-primary mb-3 tamanho" data-bs-toggle="modal" data-bs-target="#depoimentosModal"><i class="bi bi-key-fill"></i><br>Trocar Senha</button>
                </div>
                <div class="col col-sm-4">
                    <button type="button" class="btn btn-outline-danger mb-3 tamanho"><i class="bi bi-person-gear"></i><br>Atualizar Perfil</button>
                </div>
            </div>
        </div>
    </div>

    <?php include '../../componentes/footerSeguro.php'; ?>
</body>
</html>
