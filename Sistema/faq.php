<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Salão de Beleza</title>
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

    <!-- FAQ-->
    <section id="faq" class="py-5 bg-light mt-5">
        <div class="container text-center">
            <h1 class="sombra-simples" >FAQ</h1>
            <p class="lead sombra-simples">Confie no processo e saia daqui como uma princesa.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-5 bg-light mt-5">
        <div class="container">
            
            <div class="row text-center">
                <div class=" col-12 col-md-5">
                <h2 class="text-center mb-4">Contato</h2>
                    <h5>Telefone</h5>
                    <p>(11) 1234-5678</p>
                    <h5>Email</h5>
                    <p>contato@salaodebeleza.com</p>
                    <h5>Endereço</h5>
                    <p>Rua Exemplo, 123 - São Paulo, SP</p>
                </div>
                <div class="col-12 col-md-7">
                    <div class="container">
                <h2 class="text-center mb-4">Perguntas Frequentes</h2>
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button bg-success text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Quais são os horários de funcionamento?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Nosso salão funciona de segunda a sábado, das 9h às 20h. Aos domingos, estamos fechados.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed bg-success text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Preciso agendar um horário com antecedência?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Sim, recomendamos que você agende seu horário com antecedência para garantir o atendimento no momento desejado.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed bg-success text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Quais métodos de pagamento são aceitos?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Aceitamos pagamentos em dinheiro, cartões de crédito e débito, além de PIX.
                            </div>
                        </div>
                    </div>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5">

    </section>

    <!-- Footer --> 
    <?php include './componentes/footer.php'; ?>
</body>
</html>