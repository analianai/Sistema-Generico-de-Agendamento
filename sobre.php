<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre - Salão de Beleza</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="assets/css/styles.css" rel="stylesheet">

    <!-- Bootstrap css Icons-->
   <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <?php include './componentes/menu.php'; ?>

    <!-- Hero Section -->
    <section id="sobre" class="py-5 bg-light mt-5">
        <div class="container text-center">
            <h1 class="sombra-simples">Sobre Nós</h1>
            <p class="lead sombra-simples">Porque você merece ser cuidada e mimada de vez em quando!</p>
        </div>
    </section>

    <!-- Sobre Section -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2>Quem Somos</h2>
                    <p>O Salão de Beleza nasceu com a missão de oferecer experiências únicas de cuidado e transformação. Com anos de experiência no mercado, nossa equipe é formada pelos melhores profissionais, sempre prontos para valorizar a sua beleza natural.</p>
                    <p>Nosso compromisso é proporcionar um ambiente acolhedor e serviços de altísima qualidade, utilizando produtos das melhores marcas do mercado.</p>
                </div>
                <div class="col-md-6">
                    <img src="./assets/img/sobre.jpg" class="img-fluid rounded" alt="Sobre Nós">
                </div>
            </div>
        </div>
    </section>

    <!-- Missão, Visão e Valores -->
    <section id="sobreMeio" class="py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4">
                    <h3>Missão</h3>
                    <p>Promover bem-estar e autoestima através de serviços de excelência no ramo da beleza.</p>
                </div>
                <div class="col-md-4">
                    <h3>Visão</h3>
                    <p>Ser reconhecido como referência no mercado de beleza pela qualidade e inovação.</p>
                </div>
                <div class="col-md-4">
                    <h3>Valores</h3>
                    <p>Compromisso, excelência, respeito e dedicação a cada cliente.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Depoimentos -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">O que nossos clientes dizem</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <p class="card-text">"A experiência foi maravilhosa! Ótimo atendimento e ambiente acolhedor."</p>
                            <h5 class="card-title">- Ana Maria</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <p class="card-text">"A melhor experiência que já tive. Senti-me renovado!"</p>
                            <h5 class="card-title">João Silva</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <p class="card-text">"Serviços impecáveis e atendimento excelente."</p>
                            <h5 class="card-title">Maria Clara</h5>
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
