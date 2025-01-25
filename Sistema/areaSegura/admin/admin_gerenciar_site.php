<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['username']) || $_SESSION['nivel_acesso'] != 1) {
    header("Location: ../../sign_in.php?error=Acesso negado.");
    exit;
}

// Conexão com o banco de dados
$mysqli = new mysqli("localhost", "root", "", "salao");

// Verifica se houve erro na conexão
if ($mysqli->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $mysqli->connect_error);
}

// Adicionar novo slide
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actionCarousel'])) {
    $action = $_POST['actionCarousel'];

    if ($action === 'add') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $active = isset($_POST['active']) ? 1 : 0;

        // Upload de imagem
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = 'uploads/carousel/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);

            $sql = "INSERT INTO carousel_slides (image_path, title, description, active) VALUES ('$imagePath', '$title', '$description', '$active')";
            $mysqli->query($sql);
        }
        header("Location: admin_gerenciar_site.php"); // Redireciona para a página de gerenciar site
        exit;
    }
}

// Atualizar slide
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actionUpdateCarousel'])) {
    $action = $_POST['actionUpdateCarousel'] ?? '';

    if ($action === 'update_carousel') {
        $id = intval($_POST['carousel_id']);
        $title = trim($_POST['carousel_nome'] ?? '');
        $description = trim($_POST['carousel_descricao'] ?? '');
        $imagem = $_FILES['carousel_imagem'] ?? null;

        if ($id > 0 && !empty($title)) {
            // Preparar a query de atualização
            $updateQuery = "UPDATE carousel_slides SET title = ?, description = ?";

            // Verificar se há uma nova imagem
            if ($imagem && $imagem['error'] === UPLOAD_ERR_OK) {
                // Definir o diretório de upload e gerar o nome da imagem
                $target_dir = "uploads/carousel/";
                $image_name = uniqid("carousel_") . basename($imagem["name"]);
                $target_file = $target_dir . $image_name;
                
                // Mover o arquivo para o diretório de upload
                if (move_uploaded_file($imagem["tmp_name"], $target_file)) {
                    // Se o upload da imagem for bem-sucedido, adicionar a imagem à query
                    $updateQuery .= ", image_path = ?";
                } else {
                    $_SESSION['mensagem_erro'] = "Erro ao fazer upload da imagem.";
                    header("Location: admin_gerenciar_site.php");
                    exit;
                }
            }

            // Finalizar a query
            $updateQuery .= " WHERE id = ?";

            // Preparar a execução da query
            if ($imagem && $imagem['error'] === UPLOAD_ERR_OK) {
                $stmt = $mysqli->prepare($updateQuery);
                $stmt->bind_param('ssss', $title, $description, $target_file, $id); // Caminho completo da imagem
            } else {
                $stmt = $mysqli->prepare($updateQuery);
                $stmt->bind_param('ssi', $title, $description, $id); // Caso não haja imagem
            }

            // Executar a query
            if ($stmt->execute()) {
                $_SESSION['mensagem_sucesso'] = "Slide atualizado com sucesso!";
            } else {
                $_SESSION['mensagem_erro'] = "Erro ao atualizar o slide: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $_SESSION['mensagem_erro'] = "Dados inválidos para atualização.";
        }
        header("Location: admin_gerenciar_site.php");
        exit;
    }
}

// Excluir slide
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM carousel_slides WHERE id = $id");

    header("Location: admin_gerenciar_site.php"); // Redireciona para a página de gerenciar site
    exit;
}

// Recuperar slides
$resultCarousel = $mysqli->query("SELECT * FROM carousel_slides");

//LOCALIZAÇÃO  

// Inserir nova localização
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actionlocal']) && $_POST['actionlocal'] == 'add') {
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $mapa = $_POST['mapa'];

    // Query para inserir a nova localização
    $stmt = $mysqli->prepare("INSERT INTO localizacao (telefone, email, endereco, mapa) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $telefone, $email, $endereco, $mapa);

    if ($stmt->execute()) {
        $_SESSION['mensagem_sucesso'] = 'Localização adicionada com sucesso!';
    } else {
        $_SESSION['mensagem_erro'] = 'Erro ao adicionar a localização!';
    }

    // Redirecionar para evitar reenvio do formulário
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// visualizar os dados de localização
$queryLocalizacao = "
    SELECT 
        local_id, telefone, email, endereco, mapa 
    FROM 
        localizacao 
    ORDER BY 
    local_id DESC";

$resultLocalizacao = $mysqli->query($queryLocalizacao);

$localizacao = [];
while ($row = $resultLocalizacao->fetch_assoc()) {
    $localizacao[] = $row;
}

// Recuperar categorias existentes
$localizacao = $mysqli->query("SELECT local_id, telefone, email, endereco, mapa FROM localizacao ORDER BY local_id DESC")->fetch_all(MYSQLI_ASSOC);


// Atualizar localização
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateLocal'])) {
    $id_local = $_POST['local_id'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $mapa = $_POST['mapa'];

    // Query para atualizar os dados da localização
    $stmt = $mysqli->prepare("UPDATE localizacao SET telefone = ?, email = ?, endereco = ?, mapa = ? WHERE local_id = ?");
    $stmt->bind_param('ssssi', $telefone, $email, $endereco, $mapa, $id_local);
    
    if ($stmt->execute()) {
        $_SESSION['mensagem_sucesso'] = 'Localização atualizada com sucesso!';
    } else {
        $_SESSION['mensagem_erro'] = 'Erro ao atualizar a localização!';
    }

    // Redirecionar para evitar reenvio do formulário
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Excluir localização
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteLocal'])) {
    $action = $_POST['deleteLocal'];
    // deletar localização
    if ($action === 'deleteLocal') {
        $id_local = $_POST['local_id'];

        // Deletar do BD
        $stmt = $mysqli->prepare("DELETE FROM localizacao WHERE local_id = ?");
        $stmt->bind_param('i', $id_local);
        $stmt->execute();

        $_SESSION['mensagem_sucesso'] = 'Localização deletada com sucesso!';

    } else {
        $_SESSION['mensagem_erro'] = 'Erro ao deletar a localização!';
    }

    // Redirecionar para evitar reenvio do formulário
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}


// Recuperar localização
$resultlocal = $mysqli->query("SELECT * FROM localizacao");

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Sites</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .tamanho {
            width: 10rem;
            height: 8rem;
            font-size: 1em;
        }
        .btn-outline-lilas {
            color: #6f42c1;
            border-color: #6f42c1;
        }
        .btn-outline-lilas:hover {
            color: #fff;
            border-color: #6f42c1;
            background-color: #6f42c1;
        }
        .btn-outline-verde{
            color:rgb(28, 229, 28);
            border-color: rgb(28, 229, 28);
        }
        .btn-outline-verde:hover{
            color: #fff;
            border-color: rgb(28, 229, 28);
            background-color: rgb(28, 229, 28);
        }
        .bg-lilas{
            color: #fff;
            background-color: #6f42c1;
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        #card{
            height: 420px;
        }
        #card img{
            height: 200px;
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

    <section id="cabecalho" class="container">
        <div class="mt-5 d-flex justify-content-between">
            <h3 class="pt-5"><i class="bi bi-globe"></i> Gerenciar Site</h3>
            <a href="admin_dashboard.php" type="button" class="btn-close pt-5 mt-4" aria-label="Close"></a>           
        </div>
        <hr>

        <div class="row align-items-start text-center">
            <div class="col">
                <button type="button" class="btn btn-outline-verde mb-3 tamanho" data-bs-toggle="modal" data-bs-target="#carouselModal">
                    <i class="bi bi-person-fill-gear fs-2"></i><br> Carousel
                </button>
            </div>
            <div class="col">
                <button type="button" class="btn btn-outline-lilas mb-3 tamanho"  data-bs-toggle="modal" data-bs-target="#NovoLocalaModal">
                    <i class="bi bi-person-fill-gear fs-2"></i><br> localização
                </button>
            </div>
            <div class="col">
                <button onclick="window.location.href='admin_midia.php'" type="button" class="btn btn-outline-primary mb-3 tamanho">
                    <i class="bi bi-camera-reels fs-2"></i><br> Mídia
                </button>
            </div>
 
            <div class="col">
                <button onclick="window.location.href='admin_depoimentos.php'" type="button" class="btn btn-outline-info mb-3 tamanho">
                    <i class="bi bi-megaphone fs-2"></i> <br>Depoimentos
                </button>
            </div>
            <div class="col">
                <button onclick="window.location.href='admin_servicos.php'" type="button" class="btn btn-outline-secondary mb-3 tamanho">
                    <i class="bi bi-house-gear-fill fs-2"></i><br>Serviços
                </button>
            </div>
        </div> 

        <!-- Modal para adicionar novo slide -->
        <div class="modal fade" id="carouselModal" tabindex="-1" aria-labelledby="carouselModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center bg-info">
                        <h1 class="modal-title fs-5 w-100" id="carouselModalLabel">Adicionar Slide ao Carrossel</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulário de Adição de Slide -->
                        <form action="" method="post" enctype="multipart/form-data" class="p-4 rounded shadow-sm">
                            <input type="hidden" name="actionCarousel" value="add">
                            <div class="mb-3">
                                <label for="image" class="form-label">Imagem:</label>
                                <input type="file" name="image" id="image" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Título:</label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Mensagem:</label>
                                <textarea name="description" id="description" class="form-control" rows="2" required></textarea>
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" name="active" id="active" class="form-check-input">
                                <label for="active" class="form-check-label">Primeiro Slide</label>
                            </div>
                            <button type="submit" class="btn btn-outline-success"><i class="bi bi-download"></i> Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Carousel -->
    <section id="visualizar_carousel" class="container">
        <div class="mt-3 d-flex justify-content-between">
            <h4 class="pt-2"><i class="bi bi-images"></i> Visualizar imagens do Slide</h4>                       
        </div>
        <hr>

        <div class="row d-flex justify-content-center">
            <?php while ($row = $resultCarousel->fetch_assoc()): ?>
                <!-- Visualizar carousel -->
                <div class="col-md-3 mb-4">
                    <div class="card" id="card">
                        <img src="<?php echo $row['image_path']; ?>" class="card-img-top" alt="Imagem do Slide">
                        <div class="card-body d-flex flex-column align-items-center">
                            <h5 class="card-title text-center"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                            <p class="card-text"><small class="text-muted">Ação: <?php echo $row['active'] ? 'Primeiro Slide' : 'Inativo'; ?></small></p>
                            <div class="text-center position-absolute bottom-0 mb-2">
                                <!-- Botão Atualizar -->
                                <a href="#" class="btn btn-outline-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#updateCarouselModal<?php echo $row['id']; ?>"><i class="bi bi-arrow-repeat"></i> Atualizar</a>
                                <!-- Botão Excluir -->
                                <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-outline-danger btn-sm " data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash"></i> Excluir</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Atualizar Carousel (específico para cada slide) -->
                <div class="modal fade" id="updateCarouselModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="updateCarouselLabel<?php echo $row['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white text-center">
                                <h4 class="modal-title w-100 fs-5" id="updateCarouselLabel<?php echo $row['id']; ?>">Atualize o Slide: <?php echo htmlspecialchars($row['title']); ?></h4>
                                <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg fs-5"></i></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="" enctype="multipart/form-data">
                                    <input type="hidden" name="actionUpdateCarousel" value="update_carousel">
                                    <input type="hidden" name="carousel_id" value="<?php echo $row['id']; ?>">

                                    <!-- Campo para Nome do Slide -->
                                    <div class="mb-3">
                                        <input type="text" name="carousel_nome" class="form-control" placeholder="Novo Nome do Slide" value="<?php echo htmlspecialchars($row['title']); ?>" required>
                                    </div>

                                    <!-- Campo para Descrição -->
                                    <div class="mb-3">
                                        <input type="text" name="carousel_descricao" class="form-control" placeholder="Descrição do Slide" value="<?php echo htmlspecialchars($row['description']); ?>" required>
                                    </div>

                                    <!-- Campo para Upload de Imagem -->
                                    <div class="mb-3">
                                        <label for="carousel_imagem" class="form-label">Nova Imagem do Slide</label>
                                        <input type="file" name="carousel_imagem" class="form-control" id="carousel_imagem" accept="image/*">
                                    </div>

                                    <!-- Botões para Cancelar ou Submeter -->
                                    <div class="mb-3 text-center">
                                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="bi bi-x-octagon-fill"></i> Cancelar</button>
                                        <button type="submit" class="btn btn-outline-success"><i class="bi bi-arrow-repeat"></i> Atualizar Slide</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal de DELEÇÃO -->
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center bg-danger text-white">
                                <h3 class="modal-title fs-5 w-100" id="deleteModalLabel">Deseja deletar imagem do slide?</h3>
                                <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg fs-5"></i></button>
                            </div>
                            <div class="modal-body text-center">
                                <p class="text-danger">*Ao excluir a imagem será definitivo</p>
                                <a type="button" class="btn btn-outline-success me-2" data-bs-dismiss="modal"><i class="bi bi-x-octagon-fill"></i> Cancelar</a>
                                <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-outline-danger"><i class="bi bi-trash"></i> Excluir</a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>
        </div>
    </section>
    <!--localização-->
    <section id="localizacao" class="container mb-5">
        <div class="mt-3 d-flex justify-content-between">
            <h4 class="pt-2"><i class="bi bi-geo-alt"></i> Visualizar Localização</h4>                       
        </div>
        <hr>
        <!-- Button new localização -->
        <div class="row">
            <div class="col-md-6">
                <button type="button" class="btn text-primary mb-2" data-bs-toggle="modal" data-bs-target="#NovoLocalaModal">
                    <i class="bi bi-plus"></i> Nova localização
                </button>
            </div>
            <div class="col-md-6 text-end">
                <button type="button" class="btn btn-outline-primary mb-2" data-bs-toggle="modal" data-bs-target="#NovoLocalaModal">
                    <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </div> 

        <!-- Nova localização Modal -->
        <div class="modal fade" id="NovoLocalaModal" tabindex="-1" aria-labelledby="NovoLocalaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center bg-lilas">
                        <h1 class="modal-title fs-5 w-100" id="NovoLocalaModalLabel">Nova Localização</h1>
                        <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg fs-5"></i></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="actionlocal" value="add">
                            <div class="mb-3">
                                <label for="telefone" class="form-label">Telefone:</label>
                                <input type="text" class="form-control" name="telefone" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="endereco" class="form-label">Endereço:</label>
                                <input type="text" class="form-control" name="endereco" required>
                            </div>

                            <div class="mb-3">
                                <label for="mapa" class="form-label">URL do Google Maps:</label>
                                <input type="text" class="form-control" name="mapa" required>
                            </div>
                            <div class="mb-3 text-center">
                                <button type="button" class="btn btn-outline-danger mt-4 me-2" data-bs-dismiss="modal"><i class="bi bi-x-octagon-fill"></i> Cancelar</button>
                                <button type="submit" class="btn btn-outline-success mt-4"><i class="bi bi-save"></i> Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5 pt-4">
            <?php foreach ($localizacao as $index => $local): ?>
                <div class="col-md-4">
                    <div class="card p-2">
                    <div class="map-responsive">
                        <iframe src="<?= htmlspecialchars($local['mapa']); ?>" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                        <h5 class="text-center m-2 card-title"><strong>Endereço e Localização</strong></h5>
                        <p class="lead"><strong>Telefone: </strong><?= htmlspecialchars($local['telefone']); ?></p>
                        <p class="lead"><strong>Email: </strong><?= htmlspecialchars($local['email']); ?></p>
                        <p class="lead"><strong>Endereço: </strong><?= htmlspecialchars($local['endereco']); ?></p>  
                        <div class="text-center mt-3 mb-3">
                            <!-- Botão Atualizar localização -->
                            <a href="#" 
                            class="btn btn-outline-success me-2" 
                            data-bs-toggle="modal" 
                            data-bs-target="<?php echo '#updateLocalModal' . $local['local_id']; ?>">
                            <i class="bi bi-arrow-repeat"></i> Atualizar
                            </a>

                            <!-- Botão Excluir localização -->
                            <a href="#" 
                            class="btn btn-outline-danger" 
                            data-bs-toggle="modal" 
                            data-bs-target="<?php echo '#deletelocalModal' . $local['local_id']; ?>">
                            <i class="bi bi-trash"></i> Excluir
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Modal Excluir Localização -->
                <div class="modal fade" id="deletelocalModal<?= $local['local_id'] ?>" tabindex="-1" aria-labelledby="deletelocalModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center bg-danger text-white">
                                <h3 class="modal-title fs-5 w-100" id="deletelocalModalLabel">Deseja deletar dados de localização?</h3>
                                <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg fs-5"></i></button>
                            </div>
                            <div class="modal-body text-center">
                                <p class="text-danger">*Ao excluir os dados será definitivo, não poderá recuperar!</p>
                                <form action="" method="POST" style="display:inline;">
                                    <input type="hidden" name="deleteLocal" value="deleteLocal">
                                    <input type="hidden" name="local_id" value="<?= $local['local_id'] ?>">
                                    <button type="button" class="btn btn-outline-success mt-2 me-2" data-bs-dismiss="modal"><i class="bi bi-x-octagon-fill"></i> Não</button>
                                    <button type="submit" class="btn btn-outline-danger mt-2"><i class="bi bi-trash"></i> Sim</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Atualizar Localização -->
                <div class="modal fade" id="updateLocalModal<?= $local['local_id'] ?>" tabindex="-1" aria-labelledby="updateLocalModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h3 class="modal-title w-100 text-center" id="updateLocalModalLabel">Atualizar Localização</h3>
                                <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg fs-5"></i></button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="POST">
                                    <input type="hidden" name="updateLocal" value="updateLocal">
                                    <input type="hidden" name="local_id" value="<?= $local['local_id'] ?>">

                                    <div class="mb-3">
                                        <label for="telefone" class="form-label">Telefone:</label>
                                        <input type="text" class="form-control" name="telefone" value="<?= htmlspecialchars($local['telefone']); ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email:</label>
                                        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($local['email']); ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="endereco" class="form-label">Endereço:</label>
                                        <input type="text" class="form-control" name="endereco" value="<?= htmlspecialchars($local['endereco']); ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mapa" class="form-label">URL do Google Maps:</label>
                                        <input type="text" class="form-control" name="mapa" value="<?= htmlspecialchars($local['mapa']); ?>" required>
                                    </div>
                                    <div class="mb-3 text-center">
                                        <button type="button" class="btn btn-outline-danger mt-4 me-2" data-bs-dismiss="modal"><i class="bi bi-x-octagon-fill"></i> Cancelar</button>
                                        <button type="submit" class="btn btn-outline-success mt-4"><i class="bi bi-save"></i> Atualizar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </section>

    <?php include '../../componentes/footerSeguro.php'; ?>
</body>
</html>
