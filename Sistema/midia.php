<?php
session_start();

// Conexão com o banco de dados
$mysqli = new mysqli("localhost", "root", "", "salao");

// Verifica se houve erro na conexão
if ($mysqli->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $mysqli->connect_error);
}

//visualizar
// Fotos
$queryMidiaFotos = "
        SELECT 
        midia_id, tipo, caminho, descricao, data_upload 
        FROM 
        midia 
        WHERE
        tipo = 'foto'";
$resultMidiaFotos = $mysqli->query($queryMidiaFotos);

$midiasFotos = [];
while ($row = $resultMidiaFotos->fetch_assoc()) {
    $midiasFotos[] = $row;
}

// Fotos
$queryMidiaVideo = "
        SELECT 
        midia_id, tipo, caminho, descricao, data_upload 
        FROM 
        midia 
        WHERE
        tipo = 'video'";
$resultMidiaVideo = $mysqli->query($queryMidiaVideo);

$midiasVideos = [];
while ($row = $resultMidiaVideo->fetch_assoc()) {
    $midiasVideos[] = $row;
}

// Fotos
$queryMidiaYoutube = "
        SELECT 
        midia_id, tipo, caminho, descricao, data_upload 
        FROM 
        midia 
        WHERE
        tipo = 'youtube'";
$resultMidiaYoutube = $mysqli->query($queryMidiaYoutube);

$midiasYoutube = [];
while ($row = $resultMidiaYoutube->fetch_assoc()) {
    $midiasYoutube[] = $row;
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mídia - Salão de Beleza</title>
   <!-- Bootstrap css-->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
   
   <link href="assets/css/styles.css" rel="stylesheet">

   <!-- Bootstrap css Icons-->
   <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <?php include './componentes/menu.php'; ?>

    <!-- Hero Section -->
    <section id="midia" class="py-5 bg-light mt-5">
        <div class="container text-center">
            <h1 class="sombra-simples">Nossas Mídias</h1>
            <p class="lead sombra-simples">Descubra a história e a paixão por trás do Salão de Beleza.</p>
        </div>
    </section>

    <!-- Visualizar Fotos -->
    <section id="fotos" class="container">
        <div class="mt-2 mb-3 d-flex justify-content-between">
            <h3 class="pt-5"><i class="bi bi-images"></i> Fotos</h3>           
        </div>        
            <div class="row">
                <?php foreach ($midiasFotos as $midiasFoto): ?>
                    <div class="col-12 col-md-4 mb-3">
                        <div class="card">
                            <img src="areaSegura/admin/<?php echo $midiasFoto['caminho']; ?>" class="img-fluid">
                            <div class="card-body">
                                <p class="card-text"><?php echo htmlspecialchars($midiasFoto['descricao']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
    </section>

    <!-- Visualizar Vídeos -->
    <section id="videos" class="container">
        <div class="mt-2 mb-3 d-flex justify-content-between">
            <h3 class="pt-5"><i class="bi bi-camera-video"></i> Vídeos</h3>            
        </div>
        <div class="row">
            <?php foreach ($midiasVideos as $midiasVideo): ?>
                <div class="col-12 col-md-4 mb-3">
                    <div class="card">
                        <video width="100%" controls>
                            <source src="areaSegura/admin/<?php echo $midiasVideo['caminho']; ?>" type="video/mp4">
                            Seu navegador não suporta o elemento de vídeo.
                        </video>
                        <p><?php echo $midiasVideo['descricao']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Visualizar Vídeos do YouTube -->
    <section id="videosYoutube" class="container">
        <div class="mt-2 mb-3 d-flex justify-content-between">
            <h3 class="pt-5"><i class="bi bi-youtube"></i> Vídeos do YouTube</h3>            
        </div>
        <div class="row">
            <?php foreach ($midiasYoutube as $midiaYoutube): ?>
                <div class="col-12 col-md-4 mb-4">
                    <div class="card">
                        <div class="ratio ratio-16x9">
                            <iframe src="<?php echo htmlspecialchars($midiaYoutube['caminho']); ?>" title="Vídeo 1" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><?php echo htmlspecialchars($midiaYoutube['descricao']); ?></p>
                        </div>
                    </div>
                </div>
                
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Footer -->
    <?php include './componentes/footer.php'; ?>    
</body>
</html>
