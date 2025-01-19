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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    </style>
</head>
<body>
    <!-- memu -->
    <?php include '../../componentes/menuSeguro.php'; ?>
    <!-- cabecalho -->
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
                <button  onclick="window.location.href='admin_depoimentos.php'" type="button" class="btn btn-outline-primary mb-3 tamanho"><i class="bi bi-megaphone fs-2"></i> <br>Depoimentos</button>
            </div>
            <div class="col">
                <button onclick="window.location.href='admin_servicos.php'" type="button" class="btn btn-outline-secondary mb-3 tamanho"><i class="bi bi-house-gear-fill fs-2"></i><br>Serviços</button>
            </div>
        </div> 

        <!--Modal inserir carousel-->
        <div class="modal fade" id="carouselModal" tabindex="-1" aria-labelledby="carouselModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center bg-info">
                        <h1 class="modal-title fs-5 w-100" id="carouselModalLabel">Atualizar Carousel de Slides</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulário de Adição de Slide -->
                        <form action="" method="post" enctype="multipart/form-data" class="p-4 rounded shadow-sm">
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
                                <label for="active" class="form-check-label">Ativo</label>
                            </div>
                            <button type="submit" class="btn btn-outline-success"><i class="bi bi-download"></i> Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
     <!-- Carousel -->
    <section id="carousel" class="container">
        <div class="mt-5 d-flex justify-content-between align-items-center">
            <h4 class="pt-3"><i class="bi bi-images"></i> Slides Atuais do Carrossel</h4>
        </div>
        <hr>
        <!-- Lista de Slides -->
        <ul class="list-group">
            <?php while ($slide = $result->fetch_assoc()): ?>
                <li class="list-group-item d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <img src="<?= $slide['image_path'] ?>" alt="Imagem" width="100" class="me-3">
                        <div>
                            <strong>Título: <?= htmlspecialchars($slide['title']) ?></strong>
                            <p class="mb-0"><b>Mensagem: </b><?= htmlspecialchars($slide['description']) ?></p>
                        </div>
                    </div>
                    <a href="?delete=<?= $slide['id'] ?>" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i> Excluir</a>
                </li>
            <?php endwhile; ?>
        </ul>
    </section>


    <script src="../assets/js/script.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



    

