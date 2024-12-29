<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['username'])) {
    // Redireciona para a página de login se não estiver logado
    header('Location: sing_in.php');
    exit;
}

if (!isset($_SESSION['user_id'])) {
    die('Erro: ID do usuário não definido na sessão.');
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
$query = "SELECT nome, sobrenome, celular, whatsapp, endereco, estado, cidade, cpf, password_hash FROM usuarios WHERE id = ?";
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

// Atualiza a senha do usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['senha_atual'], $_POST['nova_senha'], $_POST['confirmar_senha'])) {
    $senha_atual = trim($_POST['senha_atual']);
    $nova_senha = trim($_POST['nova_senha']);
    $confirmar_senha = trim($_POST['confirmar_senha']);

    // Validações básicas
    if (empty($senha_atual) || empty($nova_senha) || empty($confirmar_senha)) {
        $_SESSION['mensagem_erro'] = 'Preencha todos os campos.';
        header('Location: ' . $_SERVER['PHP_SELF'] . '?modal=trocarSenhaModal');
        exit;
    }

    if (!password_verify($senha_atual, $user['password_hash'])) {
        $_SESSION['mensagem_erro'] = 'A senha atual está incorreta.';
        header('Location: ' . $_SERVER['PHP_SELF'] . '?modal=trocarSenhaModal');
        exit;
    }

    if (strlen($nova_senha) < 8) {
        $_SESSION['mensagem_erro'] = 'A nova senha deve ter pelo menos 8 caracteres.';
        header('Location: ' . $_SERVER['PHP_SELF'] . '?modal=trocarSenhaModal');
        exit;
    }

    if ($nova_senha !== $confirmar_senha) {
        $_SESSION['mensagem_erro'] = 'As senhas não coincidem.';
        header('Location: ' . $_SERVER['PHP_SELF'] . '?modal=trocarSenhaModal');
        exit;
    }

    // Hash da nova senha
    $senha_hash = password_hash($nova_senha, PASSWORD_BCRYPT);

    // Atualiza a senha no banco de dados
    $sql = "UPDATE usuarios SET password_hash = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        die("Erro ao preparar a consulta: " . $mysqli->error);
    }

    $stmt->bind_param('si', $senha_hash, $user_id);
    if ($stmt->execute()) {
        $_SESSION['mensagem_sucesso'] = 'Senha atualizada com sucesso.';
    } else {
        die("Erro ao executar a consulta: " . $stmt->error);
    }

    $stmt->close();
    $mysqli->close();

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
} else {
    echo "Nenhum POST recebido.";
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
    <section class="container">
        <div class="mt-5 d-flex justify-content-between">
            <h3 class="pt-5"><i class="bi bi-person-check-fill"></i> Meu Perfil</h3>
            <a href="admin_dashboard.php" type="button" class="btn-close pt-5 mt-4" aria-label="Close"></a>
        </div>
        <hr>
    </section>
    <section class="container">
        <div class="row mb-5">
            <div class="col-md-8 p-4">
                <div class="col-md-7">
                    <p><strong>Nome:</strong> <?php echo htmlspecialchars($user['nome'] . ' ' . $user['sobrenome']); ?></p>
                </div>
                <div class="d-flex justify-content-between">
                    <p><strong>CPF:</strong> <?php echo htmlspecialchars($user['cpf']); ?></p>
                    <p><strong>Celular:</strong> <?php echo htmlspecialchars($user['celular']); ?></p>  
                    <p><strong>Whatsapp:</strong> <?php echo htmlspecialchars($user['whatsapp']); ?></p>
                </div> 
                <div class="d-flex justify-content-between">        
                    <p><strong>Endereço:</strong> <?php echo htmlspecialchars($user['endereco']); ?></p>
                    <p><strong>Cidade:</strong> <?php echo htmlspecialchars($user['cidade']); ?></p>  
                    <p><strong>Estado:</strong> <?php echo htmlspecialchars($user['estado']); ?></p>
                </div>
            </div>
            <div class="col-md-3 d-flex justify-content-end">
                <div class="border border-2 border rounded p-4">
                    <img src="../../assets/uploads/20241001_115705.jpg" class="img-fluid rounded" alt="Imagem de perfil">  
                </div>    
            </div>
        </div>
        <h4><i class="bi bi-arrow-repeat"></i> Atualize seu perfil</h4>
        <hr>
        <div class="row mb-5 mt-4">
            <div class="col col-sm-4 d-flex justify-content-end">
                    <button type="button" class="btn btn-outline-primary mb-3 tamanho" data-bs-toggle="modal" data-bs-target="#trocarSenhaModal"><i class="bi bi-key-fill"></i><br>Trocar Senha</button>
            </div>
            <div class="col col-sm-4 d-flex justify-content-center">
                <button type="button" class="btn btn-outline-secondary mb-3 tamanho"><i class="bi bi-person-fill-gear"></i><br>Atualizar Perfil</button>
            </div>
            <div class="col col-sm-4 d-flex justify-content-start">
                    <button type="button" class="btn btn-outline-warning mb-3 tamanho" data-bs-toggle="modal" data-bs-target="#depoimentosModal"><i class="bi bi-person-bounding-box"></i><br>Alterar foto</button>
            </div>
        </div>
        <!-- Modal Trocar Senha -->
        <div class="modal fade" id="trocarSenhaModal" tabindex="-1" aria-labelledby="trocarSenhaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h5 class="modal-title w-100" id="trocarSenhaModalLabel">Trocar Senha</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="alertaErro" class="alert alert-danger d-none" role="alert"></div>
                        <form action="" method="post" id="formTrocarSenha" novalidate>
                            <div class="mb-3">
                                <label for="senha_atual" class="form-label">Senha Atual</label>
                                <input type="password" class="form-control" id="senha_atual" name="senha_atual" required>
                            </div>
                            <div class="mb-3">
                                <label for="nova_senha" class="form-label">Nova Senha</label>
                                <input type="password" class="form-control" id="nova_senha" name="nova_senha" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirmar_senha" class="form-label">Confirmar Senha</label>
                                <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-outline-primary text-center" id="btnSalvarAlteracoes"><i class="bi bi-arrow-repeat"></i> Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Inclui o footer -->
    <?php include '../../componentes/footerSeguro.php'; ?>
    <script>
        // Validação do formulário de troca de senha
        document.getElementById('btnSalvarAlteracoes').addEventListener('click', function (event) {
        event.preventDefault(); // Previne o comportamento padrão de envio do formulário
        const senha_atual = document.getElementById('senha_atual').value.trim();
        const novaSenha = document.getElementById('nova_senha').value.trim();
        const confirmarSenha = document.getElementById('confirmar_senha').value.trim();
        const alertaErro = document.getElementById('alertaErro');

        alertaErro.classList.add('d-none'); // Esconde o alerta inicialmente

        if (!senha_atual || !novaSenha || !confirmarSenha) {
            alertaErro.textContent = 'Preencha todos os campos.';
            alertaErro.classList.remove('d-none');
            return;
        }

        if (novaSenha.length < 8) {
            alertaErro.textContent = 'A nova senha deve ter pelo menos 8 caracteres.';
            alertaErro.classList.remove('d-none');
            return;
        }

        if (novaSenha !== confirmarSenha) {
            alertaErro.textContent = 'As senhas não coincidem.';
            alertaErro.classList.remove('d-none');
            return;
        }

        // Se tudo estiver válido, submete o formulário
        document.getElementById('formTrocarSenha').submit();
    });
    document.addEventListener('DOMContentLoaded', function () {
        const url = new URL(window.location.href);

        // Verifica e remove o parâmetro específico após o carregamento da página
        if (url.searchParams.has('modal')) {
            url.searchParams.delete('modal'); // Remove o parâmetro modal
            window.history.replaceState({}, document.title, url.pathname); // Atualiza a URL sem recarregar a página
        }
    });

    </script>
</body>
</html>
