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
$query = "SELECT nome, sobrenome, celular, whatsapp, endereco, estado, cidade, cpf, data_nascimento, username, password_hash FROM usuarios WHERE id = ?";
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

//Atualizar Perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'], $_POST['sobrenome'], $_POST['celular'], $_POST['whatsapp'], $_POST['endereco'], $_POST['estado'], $_POST['cidade'], $_POST['cpf'], $_POST['data_nascimento'], $_POST['username'])) {
    $nome = trim($_POST['nome']);
    $sobrenome = trim($_POST['sobrenome']);
    $celular = trim($_POST['celular']);
    $whatsapp = trim($_POST['whatsapp']);
    $endereco = trim($_POST['endereco']);
    $estado = trim($_POST['estado']);
    $cidade = trim($_POST['cidade']);
    $cpf = trim($_POST['cpf']);
    $data_nascimento = trim($_POST['data_nascimento']);
    $username = trim($_POST['username']);

    // Validações básicas
    if (empty($nome) || empty($sobrenome) || empty($celular) || empty($endereco) || empty($estado) || empty($cidade) || empty($cpf) || empty($data_nascimento) || empty($username)) {
        $_SESSION['mensagem_erro'] = 'Preencha todos os campos.';
        header('Location: ' . $_SERVER['PHP_SELF'] . '?modal=AtualizarPerfilModal');
        exit;
    }

    // Atualiza os dados do usuário no banco de dados
    $sql = "UPDATE usuarios SET nome = ?, sobrenome = ?, celular = ?, whatsapp = ?, endereco = ?, estado = ?, cidade = ?, cpf = ?, data_nascimento = ?, username = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        die("Erro ao preparar a consulta: " . $mysqli->error);
    }

    $stmt->bind_param('ssssssssssi', $nome, $sobrenome, $celular, $whatsapp, $endereco, $estado, $cidade, $cpf, $data_nascimento, $username, $user_id);
    if ($stmt->execute()) {
        $_SESSION['mensagem_sucesso'] = 'Perfil atualizado com sucesso.';
    } else {
        die("Erro ao executar a consulta: " . $stmt->error);
    }
    header("Location: user_perfil.php");
    exit;
}

// Excluir Perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_perfil'])) {
    // Exclui o usuário do banco de dados
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        die("Erro ao preparar a consulta: " . $mysqli->error);
    }

    $stmt->bind_param('i', $user_id);
    if ($stmt->execute()) {
        // Encerra a sessão e redireciona para a página de login
        session_destroy();
        header("Location: ../../sing_in.php?mensagem_sucesso=Perfil excluído com sucesso.");
    } else {
        die("Erro ao executar a consulta: " . $stmt->error);
    }
    header("Location: admin_perfil.php");
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
            <a href="user_dashboard.php" type="button" class="btn-close pt-5 mt-4" aria-label="Close"></a>
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
            <div class="col-md-4 d-flex justify-content-end">
                <div class="border border-2 border rounded p-4">
                    <img src="../../assets/uploads/20241001_115705.jpg" width="300" class="img-fluid rounded" alt="Imagem de perfil">  
                </div>    
            </div>
        </div>
    </section>
    <!-- Atualizar Perfil -->
    <section class="container">
        <h4><i class="bi bi-arrow-repeat"></i> Atualize seu perfil</h4>
        <hr>
        <div class="row mb-5 mt-4">
            <div class="col col-sm-4 d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-info mb-3 tamanho" data-bs-toggle="modal" data-bs-target="#trocarSenhaModal"><i class="bi bi-key-fill fs-1"></i><br>Trocar Senha</button>
            </div>
            <div class="col col-sm-4 d-flex justify-content-center">
                <button type="button" class="btn btn-outline-secondary mb-3 tamanho" data-bs-toggle="modal" data-bs-target="#AtualizarPerfilModal"><i class="bi bi-person-fill-gear fs-1"></i><br>Atualizar Perfil</button>
            </div>
            <div class="col col-sm-4 d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-danger mb-3 tamanho" data-bs-toggle="modal" data-bs-target="#excluirPerfilModal"><i class="bi bi-trash fs-1"></i><br>Excluir Perfil</button>
            </div>
        </div>
        <!-- Modal Trocar Senha -->
        <div class="modal fade" id="trocarSenhaModal" tabindex="-1" aria-labelledby="trocarSenhaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center bg-info bg-gradient text-white">
                        <h5 class="modal-title w-100" id="trocarSenhaModalLabel">Trocar Senha</h5>
                        <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg fs-5"></i></button>
                    </div>
                    <div class="modal-body">
                        <div id="alertaErro" class="alert alert-danger d-none" role="alert"></div>
                        <form action="" method="post" id="formTrocarSenha" novalidate>
                            <label for="senha_atual" class="form-label">Senha Atual</label>
                            <div class="input-group mb-1">      
                                <input type="password" class="form-control" id="senha_atual" name="senha_atual" required>
                                <button type="button" class="btn  border border-secondary-subtle rounded-end" onclick="togglePassword('senha_atual')">
                                    <i class="bi bi-eye" id="senha_atual-icon"></i>
                                </button>
                            </div>
                            <label for="nova_senha" class="form-label mt-2">Nova Senha</label>
                            <div class="input-group mb-1">
                                <input type="password" class="form-control" id="nova_senha" name="nova_senha" required>
                                <button type="button" class="btn  border border-secondary-subtle rounded-end" onclick="togglePassword('nova_senha')">
                                    <i class="bi bi-eye" id="nova_senha-icon"></i>
                                </button>
                            </div>
                            <label for="confirmar_senha" class="form-label mt-2">Confirmar Senha</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
                                <button type="button" class="btn  border border-secondary-subtle rounded-end" onclick="togglePassword('confirmar_senha')">
                                    <i class="bi bi-eye" id="confirmar_senha-icon"></i>
                                </button>
                            </div>
                            <div class="text-center mt-2">
                                <button type="button" class="btn btn-outline-danger me-2" data-bs-dismiss="modal"><i class="bi bi-x-octagon-fill"></i>  Cancelar</button>
                                <button type="submit" class="btn btn-outline-success" id="btnSalvarAlteracoes"><i class="bi bi-arrow-repeat"></i> Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Atualizar Perfil -->
        <div class="modal fade" id="AtualizarPerfilModal" tabindex="-1" aria-labelledby="AtualizarPerfilLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center bg-secondary bg-gradient text-white">
                <h5 class="modal-title w-100" id="AtualizarPerfilLabel">Atualizar Perfil</h5>
                <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg fs-5"></i></button>
                </div>
                <div class="modal-body">
                <div id="alertaErro" class="alert alert-danger d-none" role="alert"></div>
                <form action="" method="post" id="formAtualizarPerfil" novalidate>
                    <!-- Nome -->
                    <div class="mb-3">
                    <input type="text" name="nome" class="form-control" id="nome" placeholder="Nome" value="<?php echo htmlspecialchars($user['nome']); ?>" required>
                    <div class="invalid-feedback"></div>
                    </div>
                    <!-- Sobrenome -->
                    <div class="mb-3">
                    <input type="text" name="sobrenome" class="form-control" id="sobrenome" placeholder="Sobrenome" value="<?php echo htmlspecialchars($user['sobrenome']); ?>" required>
                    <div class="invalid-feedback"></div>
                    </div>
                    <!-- Celular e WhatsApp -->
                    <div class="mb-3 d-flex justify-content-between">
                    <input type="text" name="celular" class="form-control me-2" id="celular" placeholder="Celular" pattern="\\d{11}" value="<?php echo htmlspecialchars($user['celular']); ?>" required>
                    <div class="invalid-feedback"></div>
                    <input type="text" name="whatsapp" class="form-control" id="whatsapp" placeholder="WhatsApp" pattern="\\d{11}" value="<?php echo htmlspecialchars($user['whatsapp']); ?>">
                    <div class="invalid-feedback"></div>
                    </div>
                    <!-- Endereço -->
                    <div class="mb-3">
                    <input type="text" name="endereco" class="form-control" id="endereco" placeholder="Endereço" value="<?php echo htmlspecialchars($user['endereco']); ?>" required>
                    <div class="invalid-feedback"></div>
                    </div>
                    <!-- Estado e Cidade -->
                    <div class="mb-3 d-flex justify-content-between">
                    <select name="estado" class="form-select me-2" required>
                        <option value="" selected>Estado</option>
                        <option value="Acre" <?php echo $user['estado'] == 'Acre' ? 'selected' : ''; ?>>Acre</option>
                        <option value="Alagoas" <?php echo $user['estado'] == 'Alagoas' ? 'selected' : ''; ?>>Alagoas</option>
                        <option value="Amapá" <?php echo $user['estado'] == 'Amapá' ? 'selected' : ''; ?>>Amapá</option>
                        <option value="Amazonas" <?php echo $user['estado'] == 'Amazonas' ? 'selected' : ''; ?>>Amazonas</option>
                        <option value="Bahia" <?php echo $user['estado'] == 'Bahia' ? 'selected' : ''; ?>>Bahia</option>
                        <option value="Ceará" <?php echo $user['estado'] == 'Ceará' ? 'selected' : ''; ?>>Ceará</option>
                        <option value="Distrito Federal" <?php echo $user['estado'] == 'Distrito Federal' ? 'selected' : ''; ?>>Distrito Federal</option>
                        <option value="Espírito Santo" <?php echo $user['estado'] == 'Espírito Santo' ? 'selected' : ''; ?>>Espírito Santo</option>
                        <option value="Goiás" <?php echo $user['estado'] == 'Goiás' ? 'selected' : ''; ?>>Goiás</option>
                        <option value="Maranhão" <?php echo $user['estado'] == 'Maranhão' ? 'selected' : ''; ?>>Maranhão</option>
                        <option value="Mato Grosso" <?php echo $user['estado'] == 'Mato Grosso' ? 'selected' : ''; ?>>Mato Grosso</option>
                        <option value="Mato Grosso do Sul" <?php echo $user['estado'] == 'Mato Grosso do Sul' ? 'selected' : ''; ?>>Mato Grosso do Sul</option>
                        <option value="Minas Gerais" <?php echo $user['estado'] == 'Minas Gerais' ? 'selected' : ''; ?>>Minas Gerais</option>
                        <option value="Pará" <?php echo $user['estado'] == 'Pará' ? 'selected' : ''; ?>>Pará</option>
                        <option value="Paraíba" <?php echo $user['estado'] == 'Paraíba' ? 'selected' : ''; ?>>Paraíba</option>
                        <option value="Paraná" <?php echo $user['estado'] == 'Paraná' ? 'selected' : ''; ?>>Paraná</option>
                        <option value="Pernambuco" <?php echo $user['estado'] == 'Pernambuco' ? 'selected' : ''; ?>>Pernambuco</option>
                        <option value="Piauí" <?php echo $user['estado'] == 'Piauí' ? 'selected' : ''; ?>>Piauí</option>
                        <option value="Rio de Janeiro" <?php echo $user['estado'] == 'Rio de Janeiro' ? 'selected' : ''; ?>>Rio de Janeiro</option>
                        <option value="Rio Grande do Norte" <?php echo $user['estado'] == 'Rio Grande do Norte' ? 'selected' : ''; ?>>Rio Grande do Norte</option>
                        <option value="Rio Grande do Sul" <?php echo $user['estado'] == 'Rio Grande do Sul' ? 'selected' : ''; ?>>Rio Grande do Sul</option>
                        <option value="Rondônia" <?php echo $user['estado'] == 'Rondônia' ? 'selected' : ''; ?>>Rondônia</option>
                        <option value="Roraima" <?php echo $user['estado'] == 'Roraima' ? 'selected' : ''; ?>>Roraima</option>
                        <option value="Santa Catarina" <?php echo $user['estado'] == 'Santa Catarina' ? 'selected' : ''; ?>>Santa Catarina</option>
                        <option value="São Paulo" <?php echo $user['estado'] == 'São Paulo' ? 'selected' : ''; ?>>São Paulo</option>
                        <option value="Sergipe" <?php echo $user['estado'] == 'Sergipe' ? 'selected' : ''; ?>>Sergipe</option>
                        <option value="Tocantins" <?php echo $user['estado'] == 'Tocantins' ? 'selected' : ''; ?>>Tocantins</option>
                        <option value="Estrangeiro" <?php echo $user['estado'] == 'Estrangeiro' ? 'selected' : ''; ?>>Estrangeiro</option>
                    </select>
                    <div class="invalid-feedback"></div>
                    <input type="text" name="cidade" class="form-control" id="cidade" placeholder="Cidade" value="<?php echo htmlspecialchars($user['cidade']); ?>" required>
                    <div class="invalid-feedback"></div>
                    </div>
                    <!-- CPF e Data de Nascimento -->
                    <div class="mb-3 d-flex justify-content-between">
                    <input type="text" name="cpf" class="form-control me-2" id="cpf" placeholder="CPF" pattern="\\d{11}" value="<?php echo htmlspecialchars($user['cpf']); ?>" required>
                    <div class="invalid-feedback"></div>
                    <input type="date" name="data_nascimento" class="form-control" id="data_nascimento" placeholder="Data de Nascimento" value="<?php echo htmlspecialchars($user['data_nascimento']); ?>" required>
                    <div class="invalid-feedback"></div>
                    </div>
                    <!-- Email -->
                    <div class="mb-3">
                    <input type="email" name="username" class="form-control" id="email" placeholder="Email" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    <div class="invalid-feedback"></div>
                    </div>

                    <!-- Botões -->
                    <div class="mb-3 d-flex justify-content-center">
                        <button type="button" class="btn btn-outline-danger me-2" data-bs-dismiss="modal"><i class="bi bi-x-octagon-fill"></i> Cancelar </button>
                        <button type="submit" class="btn btn-outline-success"><i class="bi bi-arrow-repeat"></i> Salvar</button>
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>
        <!-- Modal excluir Perfil -->
        <div class="modal fade" id="ExcluirPerfilModal" tabindex="-1" aria-labelledby="ExcluirPerfilLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center bg-danger bg-gradient text-white">
                <h5 class="modal-title w-100" id="ExcluirPerfilLabel">Tem certeza que deseja excluir seu perfil?</h5>
                <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg fs-5"></i></button>
                </div>
                <div class="modal-body">
                <div id="alertaErro" class="alert alert-danger d-none" role="alert"></div>
                <form action="" method="post" id="formExcluirPerfil" novalidate>
                    <div class="mb-3">
                    <p><strong class="text-danger">Com a exclusão do perfil, todas as suas informações são apagadas do sistema e não poderão ser mais recuperadas.</strong></p>
                    </div>
                    <!-- Botões -->
                    <div class="mb-3 d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-success me-2" data-bs-dismiss="modal"><i class="bi bi-backspace-fill"></i> Voltar</button>
                    <button type="submit" class="btn btn-outline-danger" name="excluir_perfil"><i class="bi bi-trash"></i> Excluir</button>
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>
    </section>
    <?php include '../../componentes/footerSeguro.php'; ?>
    <script src="../../assets/js/scriptSeguro.js"></script>
</body>
</html>
