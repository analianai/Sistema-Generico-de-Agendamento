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
$result = $mysqli->query("SELECT * FROM carousel_slides");

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
                <button type="button" class="btn btn-outline-info mb-3 tamanho" data-bs-toggle="modal" data-bs-target="#carouselModal">
                    <i class="bi bi-person-fill-gear fs-2"></i><br> Carousel
                </button>
            </div>
            <div class="col">
                <button onclick="" type="button" class="btn btn-outline-lilas mb-3 tamanho"><i class="bi bi-camera-reels fs-2"></i><br> Midia</button>
            </div>
            <div class="col">
                <button onclick="window.location.href='admin_depoimentos.php'" type="button" class="btn btn-outline-primary mb-3 tamanho"><i class="bi bi-megaphone fs-2"></i> <br>Depoimentos</button>
            </div>
            <div class="col">
                <button onclick="window.location.href='admin_servicos.php'" type="button" class="btn btn-outline-secondary mb-3 tamanho"><i class="bi bi-house-gear-fill fs-2"></i><br>Serviços</button>
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
    <!-- Visualizar imagem do carousel -->
    <section id="visualizar" class="container">
        <div class="mt-5 d-flex justify-content-between">
            <h4 class="pt-5"><i class="bi bi-images"></i> Visualizar imagens do Slide</h4>                       
        </div>
        <hr>

        <div class="row d-flex justify-content-center">
            <?php while ($row = $result->fetch_assoc()): ?>
                <!-- Visualizar carousel -->
                <div class="col-md-3 mb-4">
                    <div class="card" id="card">
                        <img src="<?php echo $row['image_path']; ?>" class="card-img-top" alt="Imagem do Slide">
                        <div class="card-body d-flex flex-column align-items-center">
                            <h5 class="card-title text-center"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                            <p class="card-text"><small class="text-muted">Ação: <?php echo $row['active'] ? 'Primeiro Slide' : 'Inativo'; ?></small></p>
                            <div class="text-center">
                                <!-- Botão Atualizar -->
                                <a href="#" class="btn btn-outline-success btn-sm me-3" data-bs-toggle="modal" data-bs-target="#updateCarouselModal<?php echo $row['id']; ?>"><i class="bi bi-arrow-repeat"></i> Atualizar</a>
                                <!-- Botão Excluir -->
                                <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash"></i> Excluir</a>
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
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
    
    <?php include '../../componentes/footerSeguro.php'; ?>
</body>
</html>
