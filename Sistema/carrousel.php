<?php
// Conexão com o banco de dados
$mysqli = new mysqli("localhost", "root", "", "salao");

// Verifica se houve erro na conexão
if ($mysqli->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $mysqli->connect_error);
}

//VISUALIZAR DEPOIMENTOS

// Consulta para pegar os 6 últimos depoimentos aprovados (ordenados pela data de aprovação)
$queryDepoimentos = "
    SELECT usuarios.nome, depoimentos.comentario
    FROM depoimentos
    INNER JOIN usuarios ON depoimentos.user_id = usuarios.id
    WHERE depoimentos.aprovacao = 1
    ORDER BY depoimentos.data_aprovacao DESC  -- Ordenando pela data de criação
    LIMIT 6
";

$result = $mysqli->query($queryDepoimentos);

if (!$result) {
    die("Erro ao executar a consulta: " . $mysqli->error);
}

$depoimentos = [];
while ($row = $result->fetch_assoc()) {
    $depoimentos[] = $row;
}


//VISUALIZAR CATEGORIAS
// Consulta para pegar a 3 últimos categorias
$queryCategorias = "
    SELECT 
    cat_id, nome,imagem 
    FROM categorias
    ORDER BY nome ASC
    LIMIT 3 
";

$resultCategorias = $mysqli->query($queryCategorias);

if (!$resultCategorias) {
    die("Erro ao executar a consulta: " . $mysqli->error);
}

$categorias = [];
while ($row = $resultCategorias->fetch_assoc()) {
    $categorias[] = $row;
}

$carousel = [];
while ($row = $resultCategorias->fetch_assoc()) {
    $carousel[] = $row;
}

//Carousel
$resultCarousel = $mysqli->query("SELECT * FROM carousel_slides");

// Fecha a conexão com o banco de dados
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salão de Beleza</title>
    <!-- Bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- css-->
     <link href="assets/css/styles.css" rel="stylesheet">
    <!-- Bootstrap css Icons-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <?php include './componentes/menu.php'; ?>

<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <?php for ($i = 0; $i < $resultCarousel->num_rows; $i++): ?>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?= $i ?>" class="<?= $i === 0 ? 'active' : '' ?>" aria-current="<?= $i === 0 ? 'true' : '' ?>" aria-label="Slide <?= $i + 1 ?>"></button>
        <?php endfor; ?>
    </div>
    <div class="carousel-inner">
        <?php $i = 0; while ($slide = $resultCarousel->fetch_assoc()): ?>
            <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                <img src="areaSegura/admin/<?= $slide['image_path'] ?>" class="d-block w-100" alt="<?= $slide['title'] ?>">
                <div class="carousel-caption d-none d-md-block">
                    <h1><?= $slide['title'] ?></h1>
                    <p><?= $slide['description'] ?></p>
                </div>
            </div>
            <?php $i++; endwhile; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
   <!-- Footer -->
   <?php include './componentes/footer.php'; ?>
</body>
</html>