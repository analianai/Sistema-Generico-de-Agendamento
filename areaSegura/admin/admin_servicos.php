<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['nivel_acesso'] != 1) {
    header("Location: ../../sing_in.php?error=Acesso negado.");
    exit;
}

$mysqli = new mysqli("localhost", "root", "", "salao");

// Lógica de inserção de serviços
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'add') {
        $codigo_servico = $_POST['codigo'];
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $observacao = $_POST['observacao'];
        $duracao = $_POST['duracao'];
        $valor = $_POST['valor'];
        $categoria_id = $_POST['categoria_id'];
    
        // Verificar se a categoria é válida
        $stmt = $mysqli->prepare("SELECT COUNT(*) FROM categorias WHERE id = ?");
        $stmt->bind_param('i', $categoria_id);
        $stmt->execute();
        $stmt->bind_result($categoria_valida);
        $stmt->fetch();
        $stmt->close();
    
        if ($categoria_valida == 0) {
            $_SESSION['mensagem_erro'] = 'A categoria selecionada não é válida!';
        } else {
            // Upload da imagem
            $imagem = '';
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
                $uploadDir = '../../assets/uploads/';
                $imagem = $uploadDir . basename($_FILES['imagem']['name']);
                move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem);
            }
    
            // Inserir no BD
            $stmt = $mysqli->prepare("INSERT INTO servicos (codigo, imagem, titulo, descricao, observacao, duracao, valor, categoria_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sssssidi', $codigo_servico, $imagem, $titulo, $descricao, $observacao, $duracao, $valor, $categoria_id);
            $stmt->execute();
    
            $_SESSION['mensagem_sucesso'] = 'Serviço cadastrado com sucesso!';
        }
        header("Location: admin_servicos.php");
        exit;
    }
    
    if ($action === 'update') {
        $id = $_POST['id'];
        $codigo_servico = $_POST['codigo'];
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $observacao = $_POST['observacao'];
        $duracao = $_POST['duracao'];
        $valor = $_POST['valor'];

        // Atualizar imagem se necessário
        $imagem = $_POST['existing_imagem'];
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
            $uploadDir = '../../assets/uploads/';
            $imagem = $uploadDir . basename($_FILES['imagem']['name']);
            move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem);
        }

        // Atualizar no BD
        $stmt = $mysqli->prepare("UPDATE servicos SET codigo = ?, imagem = ?, titulo = ?, descricao = ?, observacao = ?, duracao = ?, valor = ? WHERE id = ?");
        $stmt->bind_param('sssssidi', $codigo_servico, $imagem, $titulo, $descricao, $observacao, $duracao, $valor, $id);
        $stmt->execute();
    }

    if ($action === 'delete') {
        $id = $_POST['id'];

        // Deletar do BD
        $stmt = $mysqli->prepare("DELETE FROM servicos WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }

    // Redirecionar para evitar reenvio do formulário
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Recuperar serviços
$servicos = $mysqli->query("SELECT s.*, c.nome AS categoria_nome FROM servicos s LEFT JOIN categorias c ON s.categoria_id = c.id")->fetch_all(MYSQLI_ASSOC);

// Lógica de categorias
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nova_categoria']) && !empty($_POST['nova_categoria'])) {
        $nova_categoria = trim($_POST['nova_categoria']); // Remover espaços extras

        // Verificar se a categoria já existe
        $stmt = $mysqli->prepare("SELECT COUNT(*) FROM categorias WHERE nome = ?");
        $stmt->bind_param('s', $nova_categoria);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            // Categoria já existe
            $_SESSION['mensagem_erro'] = 'A categoria já está cadastrada!';
        } else {
            // Inserir a nova categoria no banco de dados
            $stmt = $mysqli->prepare("INSERT INTO categorias (nome) VALUES (?)");
            $stmt->bind_param('s', $nova_categoria);
            $stmt->execute();
            $stmt->close();

            // Define a mensagem de sucesso na sessão
            $_SESSION['mensagem_sucesso'] = 'Categoria criada com sucesso!';
        }

        // Redirecionar para evitar reenvio do formulário
        header("Location: admin_servicos.php");
        exit;
    }
}

// Recuperar categorias existentes
$categorias = $mysqli->query("SELECT * FROM categorias ORDER BY nome ASC")->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços</title>
    <!-- Bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap css Icons-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .btn-success {
            background-color:rgb(115, 255, 112);
            color: black;
            border-color: rgb(77, 255, 85);
        }
        .rosa{
            background-color: rgb(251, 246, 246);
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
    <!-- Mensagem de erro -->
    <?php if (isset($_SESSION['mensagem_erro'])): ?>
        <div id="mensagem-erro" class="alert alert-danger mt-4" role="alert">
            <?= $_SESSION['mensagem_erro'] ?>
        </div>
        <?php unset($_SESSION['mensagem_erro']); ?>
    <?php endif; ?>
    <!-- Mensagem de sucesso -->
    <?php if (isset($_SESSION['mensagem_sucesso'])): ?>
        <div id="mensagem-sucesso" class="alert alert-success mt-4" role="alert">
            <?= $_SESSION['mensagem_sucesso'] ?>
        </div>
        <?php unset($_SESSION['mensagem_sucesso']); ?>
    <?php endif; ?>

    <!-- menu -->
    <?php include '../../componentes/menuSeguro.php'; ?>

    <section class="container">
        <div class="mt-5 d-flex justify-content-between">
            <h3 class="pt-5"><i class="bi bi-house-gear-fill"></i> Serviços</h3>
            <a href="admin_dashboard.php" type="button" class="btn-close pt-5 mt-4" aria-label="Close"></a>
        </div>
        <hr>
        <!-- Button NOVA categoria e Serviço -->
         <div class="row">
            <div class="col-md-6">
                <button type="button" class="btn text-primary mb-4" data-bs-toggle="modal" data-bs-target="#NovaCategoriaModal">
                    <i class="bi bi-plus"></i> Nova Categoria
                </button>
                <button type="button" class="btn text-primary mb-4" data-bs-toggle="modal" data-bs-target="#NovoServico">
                    <i class="bi bi-plus"></i> Novo Serviço
                </button>
            </div>
            <div class="col-md-6 text-end">
                <button type="button" class="btn btn-outline-primary mb-4" data-bs-toggle="modal" data-bs-target="#NovoServico">
                    <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </div>
        <!-- Nova Categoria Modal -->
        <div class="modal fade" id="NovaCategoriaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="NovaCategoriaModalLabel">Nova Categoria</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="nova_categoria" name="nova_categoria" placeholder="Insira o nome da nova categoria">
                    </div>
                    <div class="mb-3 text-center">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="bi bi-x-octagon-fill"></i> Cancelar</button>
                        <button type="submit" class="btn btn-outline-success pe-3"><i class="bi bi-floppy"><i class="bi bi-backspace-reverse-fill"></i> Criar Categoria</button>
                    </div>
                </form>
                </div>
                <?php if (isset($_GET['categoria_criada']) && $_GET['categoria_criada'] === 'true'): ?>
                <div class="alert alert-success mt-4" role="alert">
                    Categoria criada com sucesso!
                </div>
                <?php endif; ?>
            </div>
            </div>
        </div>
          <!-- Modal NOVO Serviço -->
        <div class="modal fade" id="NovoServico" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header text-center">
                    <h1 class="modal-title w-100 fs-5" id="NovoServicoLabel">Novo Serviço</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body">
                        <form action="" method="POST" enctype="multipart/form-data" class="row g-3">
                            <input type="hidden" name="action" value="add">
                            <div class="col-md-12">
                                <label for="titulo" class="form-label ">Título:</label>
                                <input type="text" class="form-control" name="titulo" placeholder="Título" required>
                            </div>
                            <div class="col-md-4">
                                <label for="duracao" class="form-label">Duração (minutos):</label>
                                <input type="number" class="form-control" name="duracao" placeholder="0" required>
                            </div>
                            <div class="col-md-4">
                                <label for="valor" class="form-label">Valor (R$):</label>
                                <input type="number" step="0.01" class="form-control" name="valor" placeholder="0.00" required>
                            </div>
                            <div class="col-md-4">
                                <label for="codigo" class="form-label">Código do Serviço:</label>
                                <input type="text" class="form-control" name="codigo" placeholder="Ex: SRV123" required>
                            </div>
                            <div class="col-md-12">
                                <label for="categoria" class="form-label">Categoria:</label>
                                <select name="categoria_id" id="categoria" class="form-select" required>
                                    <option value="">Selecione uma categoria</option>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= $categoria['id'] ?>"><?= htmlspecialchars($categoria['nome']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="imagem" class="form-label">Imagem:</label>
                                <input type="file" class="form-control" name="imagem" required>
                            </div>
                            <div class="col-md-12">
                                <label for="descricao" class="form-label">Descrição:</label>
                                <textarea class="form-control" name="descricao" rows="2" placeholder="Insira a Descrição" required></textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="observacao" class="form-label">Observação:</label>
                                <textarea class="form-control" name="observacao" rows="2" placeholder="Insira sua Observação"></textarea>
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="button" class="btn btn-outline-danger me-1" data-bs-dismiss="modal"><i class="bi bi-x-octagon-fill"></i> Cancelar</button>
                                <button type="submit" class="btn btn-outline-success"><i class="bi bi-backspace-reverse-fill"></i> Criar Serviço</button>  
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="admin_servicos" class="container">
    <h4 class="card-text"><i class="bi bi-bookmark-plus"></i> Categoria: <?= isset($servico['categoria_nome']) ? $servico['categoria_nome'] : 'Sem categoria' ?></h4>

    <hr>
    <div class="row">
        <?php foreach ($servicos as $servico): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="<?= $servico['imagem'] ?>" class="card-img-top" alt="Imagem do Serviço">
                    <div class="card-body">
                        <h4 class="card-title text-center"><?= $servico['titulo'] ?></h4>
                        <p class="card-text">Descrição: <?= $servico['descricao'] ?></p>
                        <div class="d-flex justify-content-between">
                            <p class="card-text">
                                Código: <?= $servico['codigo'] ?>
                            </p>
                            <p class="card-text">
                                Duração: <?= $servico['duracao'] ?> minutos
                            </p>
                        </div>
                        <p class="card-text">Valor: <strong class="fs-4">R$ <?= number_format($servico['valor'], 2, ',', '.') ?></strong></p>
                        
                        <p class="card-text">Observação: <?= $servico['observacao'] ?></p>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-outline-success me-3" data-bs-toggle="modal" data-bs-target="#AtualizarServico<?= $servico['id'] ?>">
                            <i class="bi bi-arrow-repeat"></i> Atualizar
                            </button>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#DeletarServico<?= $servico['id'] ?>">
                            <i class="bi bi-trash"></i> Deletar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        
        <?php include '../../componentes/adminServicosModals.php'; ?> 
        <?php endforeach; ?>
    </div>
    </section>

    <?php include '../../componentes/footerSeguro.php'; ?>

    <script>
    // Ocultar a mensagem de sucesso após 3 segundos
    document.addEventListener('DOMContentLoaded', function () {
        const mensagemSucesso = document.getElementById('mensagem-sucesso');
        if (mensagemSucesso) {
            setTimeout(() => {
                mensagemSucesso.style.transition = 'opacity 0.5s';
                mensagemSucesso.style.opacity = '0';
                setTimeout(() => mensagemSucesso.remove(), 500); // Remove completamente o elemento
            }, 3000); // 3000 ms = 3 segundos
        }
    });
</script>

</body>
</html>