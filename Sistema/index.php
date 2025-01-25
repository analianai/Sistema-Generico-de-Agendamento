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

// CAROUSEL

$carousel = [];
while ($row = $resultCategorias->fetch_assoc()) {
    $carousel[] = $row;
}

//Carousel
$resultCarousel = $mysqli->query("SELECT * FROM carousel_slides");

//LOCALIZAÇÃO

// Busca os dados de localização
$queryLocalizacao = "
        SELECT 
        telefone,
        email,
        endereco, 
        mapa 
        FROM 
        localizacao 
        ORDER BY local_id DESC
        LIMIT 1";
$resultLocalizacao = $mysqli->query($queryLocalizacao);

$localizacao = [];
while ($row = $resultLocalizacao->fetch_assoc()) {
    $localizacao[] = $row;
}

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
    <!-- carousel Section -->
    <?php include './componentes/carrousel.php'; ?>
    
    <!-- Sobre Section -->
    <section id="sobreNos" class="container py-5">
        <div class="d-flex justify-content-between mb-3">
            <h2>Sobre Nós</h2>
            <a href="sobre.php" class="text-success text-decoration-none">Saiba mais</a>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <p>     
                    Nossa missão é proporcionar bem-estar e satisfação, utilizando as melhores técnicas, produtos de alta qualidade e um atendimento humanizado que faz toda a diferença. Seja para uma mudança de visual, um cuidado especial ou um momento de relaxamento, nosso espaço foi pensado para ser acolhedor, moderno e acessível.
                </p>
                <p>
                    Valorizamos a inovação, o respeito e o compromisso com a qualidade em tudo o que fazemos. Cada cliente é único, e estamos aqui para ajudar você a refletir a melhor versão de si mesmo.
                </p>
                <p>
                    Visite-nos e descubra como pequenos detalhes podem fazer grandes diferenças. No Salão "Seu Estilo", a sua beleza é nossa maior inspiração.
                    Conheça a história e a missão do nosso salão. Oferecemos serviços personalizados para destacar sua beleza natural.
                </p>
                <p>
                    Visite-nos e descubra como pequenos detalhes podem fazer grandes diferenças. No Salão "Seu Estilo", a sua beleza é nossa maior inspiração.
                    Conheça a história e a missão do nosso salão. Oferecemos serviços personalizados para destacar sua beleza natural.
                </p>
               
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <img src="assets/img/sobre.jpg" class="img-fluid" alt="Sobre Nós">
            </div>
        </div>
    </section>

    <!-- Mídia Section -->
    <section id="midiaIndex" class="container py-5">
        <div class="d-flex justify-content-between mb-3">
            <h2>Mídia</h2>
            <a href="midia.html" class="text-success text-decoration-none">Saiba Mais</a>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-3">
                <iframe src="https://www.youtube.com/embed/aH4jY6J4kvE" class="card-img-top" title="Vídeo 1" width="300" height="260" allowfullscreen></iframe>
                    <div class="card-body">
                        <p class="card-text">TUDO O QUE VOCÊ PRECISA SABER PARA TER CABELOS MAIS SAUDÁVEIS.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <img src="./assets/img/fotos.webp" width="300" height="260" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">
                            Cada clique conta uma história. Explore nossa galeria de fotos.    
                            <a href="midia.php" class="text-success text-decoration-none" >Saiba mais</a>
                        </p>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <img src="assets/img/videos.jpg" width="300" height="260" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text"> Auto cuidado com das tendências mais modernas aos cuidados tradicionais. <a href="midia.php" class="text-success text-decoration-none" >Acesse nosso Videos</a> </p>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Depoimentos Section -->
    <section id="comentarios" class="container-fluid py-5">
        <div class="container">
            <div class="d-flex justify-content-between mb-3">
                <h2>Depoimentos</h2>
            </div>
            <div class="row">
                <?php foreach ($depoimentos as $depoimento): ?>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <p class="card-text">"<?= htmlspecialchars($depoimento['comentario']); ?>"</p>
                                <h5 class="card-title">- <?= htmlspecialchars($depoimento['nome']); ?></h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Serviços Section -->
    <section id="servicos" class="container mt-3">
        <div class="d-flex justify-content-between mb-3">
            <h2>Serviços</h2>
            <a href="servicos.php" class="text-success text-decoration-none">Saiba Mais</a>
        </div>
        <div class="row">
            <?php foreach ($categorias as $categoria): ?>
                    <div class="col-md-4">
                    <a href="servicos.php" class="text-decoration-none">
                        <div class="card mb-3">
                            <img src="areaSegura/admin/uploads/categorias/<?= htmlspecialchars($categoria['imagem']); ?>" width="300" height="280" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h3 class="text-center"><?= htmlspecialchars($categoria['nome']); ?></h3>
                                
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        
    </section>

    <!-- Localização Section -->
    <section id="localizacao" class="container mt-5 mb-5">
        <div>
            <h2>Localização</h2>
            <div class="row mt-5 pt-4">
                
                <?php foreach ($localizacao as $local): ?>
                    <div class="col-md-4">
                        <div class="card p-3">
                            <div class="">
                                <h5 class="text-center mb-3 lead fs-3"><strong>Entre em Contato</strong></h5>
                                <p class="lead"><strong>Telefone: </strong><?= htmlspecialchars($local['telefone']); ?></p>
                                <p class="lead"><strong>Email: </strong><?= htmlspecialchars($local['email']); ?></p>
                                <p class="lead"><strong>Endereço: </strong><?= htmlspecialchars($local['endereco']); ?></p>  
                            </div>
                            <div class="d-none d-lg-block text-center mb-1 mt-3">
                                <span>Conecte-se conosco nas redes sociais: </span>
                            </div>
                            <div class="d-none d-lg-block text-center fs-3">
                                <a href="#" class="me-4 text-reset"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="me-4 text-reset"><i class="bi bi-instagram"></i></a>
                                <a href="#" class="me-4 text-reset"><i class="bi bi-youtube"></i></a>
                                <a href="#" class="me-4 text-reset"><i class="bi bi-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="map-responsive">
                            <iframe src="<?= htmlspecialchars($local['mapa']); ?>" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <?php include './componentes/footer.php'; ?>
</body>
</html>
