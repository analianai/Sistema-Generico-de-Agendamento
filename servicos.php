<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços - Salão de Beleza</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- css-->
    <link href="assets/css/styles.css" rel="stylesheet">
    <!-- Bootstrap css Icons-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <?php include './componentes/menu.php'; ?>

    <!-- Hero Section -->
    <section id="servico" class="py-5 bg-light mt-5">
        <div class="container text-center">
            <h1 class="sombra-simples">Serviços</h1>
            <p class="lead sombra-simples">Conheça todos os serviços que oferecemos para valorizar sua beleza.</p>
        </div>
    </section>
  
    <!-- Serviços Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="./assets/img/fotos.webp" height="275" class="card-img-top" alt="Corte de Cabelo">
                        <div class="card-body">
                            <h5 class="card-title">Corte de Cabelo</h5>
                            <p class="card-text">Cortes modernos e personalizados para realçar sua identidade.</p>
                            <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#modalCorteCabelo">Saiba mais</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="./assets/img/pintura.jpg" height="275" class="card-img-top" alt="Coloração">
                        <div class="card-body">
                            <h5 class="card-title">Coloração</h5>
                            <p class="card-text">Cores vibrantes e saudáveis para transformar seu visual.</p>
                            <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#modalColoracao">Saiba mais</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="./assets/img/manicure.webp" height="275" class="card-img-top" alt="Manicure e Pedicure">
                        <div class="card-body">
                            <h5 class="card-title">Manicure e Pedicure</h5>
                            <p class="card-text">Cuidado completo para suas unhas, com esmaltações perfeitas.</p>
                            <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#modalManicure">Saiba mais</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="./assets/img/luzes.png"  height="275" class="card-img-top" alt="Tratamento Capilar">
                        <div class="card-body">
                            <h5 class="card-title">Tratamento Capilar</h5>
                            <p class="card-text">Hidratações e tratamentos para manter seus cabelos saudáveis.</p>
                            <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#modalTratamentoCapilar">Saiba mais</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="./assets/img/makes.jpg"  height="275" class="card-img-top" alt="Maquiagem">
                        <div class="card-body">
                            <h5 class="card-title">Maquiagem</h5>
                            <p class="card-text">Makeup profissional para ocasiões especiais ou do dia a dia.</p>
                            <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#modalMaquiagem">Saiba mais</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="./assets/img/depilacao.webp"  height="275" class="card-img-top" alt="Depilação">
                        <div class="card-body">
                            <h5 class="card-title">Depilação</h5>
                            <p class="card-text">Técnicas modernas e eficazes para uma pele lisa e macia.</p>
                            <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#modalDepilacao">Saiba mais</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modals -->
    <div class="modal fade" id="modalCorteCabelo" tabindex="-1" aria-labelledby="modalCorteCabeloLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCorteCabeloLabel">Corte de Cabelo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Nosso corte de cabelo é realizado por profissionais altamente qualificados, utilizando técnicas modernas e equipamentos de última geração. Seja qual for o seu estilo, garantimos um corte que combine perfeitamente com sua personalidade e preferências.</p>
                    <ul>
                        <li>Cortes masculinos e femininos</li>
                        <li>Cortes infantis</li>
                        <li>Modelagem e finalização incluídas</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalColoracao" tabindex="-1" aria-labelledby="modalColoracaoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalColoracaoLabel">Coloração</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Nossos serviços de coloração oferecem tinturas de alta qualidade que mantêm seus cabelos saudáveis e brilhantes. Escolha entre uma ampla gama de cores e estilos.</p>
                    <ul>
                        <li>Coloração permanente e semi-permanente</li>
                        <li>Mechas, luzes e balayage</li>
                        <li>Correção de cor</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalManicure" tabindex="-1" aria-labelledby="modalManicureLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalManicureLabel">Manicure e Pedicure</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Oferecemos serviços de manicure e pedicure com os melhores produtos e técnicas. Deixe suas unhas lindas e bem cuidadas.</p>
                    <ul>
                        <li>Esmaltações tradicionais e em gel</li>
                        <li>Hidratação e esfoliação</li>
                        <li>Design de unhas personalizadas</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTratamentoCapilar" tabindex="-1" aria-labelledby="modalTratamentoCapilarLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTratamentoCapilarLabel">Tratamento Capilar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Tratamentos capilares personalizados para hidratar, fortalecer e revitalizar seus cabelos.</p>
                    <ul>
                        <li>Hidratação profunda</li>
                        <li>Reconstrução capilar</li>
                        <li>Tratamentos antiqueda</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalMaquiagem" tabindex="-1" aria-labelledby="modalMaquiagemLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMaquiagemLabel">Maquiagem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Realce sua beleza com maquiagens feitas por profissionais para qualquer ocasião.</p>
                    <ul>
                        <li>Maquiagem para festas e eventos</li>
                        <li>Maquiagem social</li>
                        <li>Contorno e iluminação profissionais</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDepilacao" tabindex="-1" aria-labelledby="modalDepilacaoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDepilacaoLabel">Depilação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Depilações rápidas e eficazes com técnicas avançadas para uma pele macia e lisa.</p>
                    <ul>
                        <li>Depilação com cera quente ou fria</li>
                        <li>Depilação a laser</li>
                        <li>Hidratação pós-depilação</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include './componentes/footer.php'; ?>    
</body>
</html>
