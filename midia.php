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

    <!-- Section: Fotos -->
    <section id="fotos" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Fotos</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="./assets/img/escova.jpeg" height="280" class="card-img-top" alt="Foto 1">
                        <div class="card-body">
                            <p class="card-text">Descrição da foto 1.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="./assets/img/makes.jpg" height="280" class="card-img-top" alt="Foto 2">
                        <div class="card-body">
                            <p class="card-text">Descrição da foto 2.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="./assets/img/manicure.webp" height="280" class="card-img-top" alt="Foto 3">
                        <div class="card-body">
                            <p class="card-text">Descrição da foto 3.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Vídeos -->
    <section id="videos" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Vídeos</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Vídeo 1" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Descrição do vídeo 1.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Vídeo 2" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Descrição do vídeo 2.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Vídeo 3" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Descrição do vídeo 3.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include './componentes/footer.php'; ?>    
                            
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
