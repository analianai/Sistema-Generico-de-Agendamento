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
    <?php include './componentes/menu.php'; ?>
    <!-- carousel Section -->
    <div class="container-fluid p-0">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/img/01.jpg" class="d-block w-100 filter-darken" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h1 class="sombra-simples">Bem-vindo ao Salão de Beleza</h1>
                        <p>Cuidamos de você com amor e dedicação!</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="assets/img/02.webp" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h1 class="sombra-simples">Transforme-se</h1>
                        <p>Com os melhores profissionais e serviços.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="assets/img/03.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h1 class="sombra-simples">Seu estilo, nossa paixão</h1>
                        <p>Visite-nos e confira!</p>
                    </div>
                </div>
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
    </div>
    
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
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <p class="card-text">"A experiência foi maravilhosa! Ótimo atendimento e ambiente acolhedor."</p>
                            <h5 class="card-title">- Ana Maria</h5>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <p class="card-text">"Equipe muito profissional e atenciosa. Recomendo a todos!"</p>
                            <h5 class="card-title">- João Silva</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <p class="card-text">"Equipe muito profissional e atenciosa. Recomendo a todos!"</p>
                            <h5 class="card-title">- João Silva</h5>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <p class="card-text">"Equipe muito profissional e atenciosa. Recomendo a todos!"</p>
                            <h5 class="card-title">- João Silva</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <p class="card-text">"Equipe muito profissional e atenciosa. Recomendo a todos!"</p>
                            <h5 class="card-title">- João Silva</h5>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <p class="card-text">"Equipe muito profissional e atenciosa. Recomendo a todos!"</p>
                            <h5 class="card-title">- João Silva</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Serviços Section -->
    <section id="servicos" class="container py-5">
        <div class="d-flex justify-content-between mb-3">
            <h2>Serviços</h2>
            <a href="servicos.php" class="text-success text-decoration-none">Saiba Mais</a>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-3">
                    <img src="./assets/img/escova.jpeg" width="300" height="280" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h3 class="text-center">Escova</h3>
                        <p class="card-text">Uma escova para cada tipo de cabelo.</p>
                        <a href="servicos.php"  class="btn btn-success w-100">Saiba mais</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <img src="assets/img/manicure.webp" width="300" height="280" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h3 class="text-center">Manicure e Pedicure</h3>
                        <p class="card-text">Detalhes sobre serviços exclusivos.</p>
                        <a href="servicos.php" class="btn btn-success w-100">Saiba mais</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <img src="assets/img/makes.jpg" width="300" height="280" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h3 class="text-center">Makes</h3>
                        <p class="card-text">Detalhes sobre serviços exclusivos.</p>
                        <button class="btn btn-success w-100">Saiba mais</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Localização Section -->
    <section id="localizacao" class="container py-5">
        <h2>Localização</h2>
        <p>Estamos localizados no coração da cidade, com fácil acesso para todos. Venha nos visitar!</p>
        <div class="map-responsive">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.8354345097745!2d-122.42169828468128!3d37.77492927975871!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80858064e8f71053%3A0xa7c6f2b5af3a9025!2sSal%C3%A3o%20de%20Beleza!5e0!3m2!1sen!2sbr!4v1686849389846!5m2!1sen!2sbr" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
    <!-- Footer -->
    <?php include './componentes/footer.php'; ?>
</body>
</html>
