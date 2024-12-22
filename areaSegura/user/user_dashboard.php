<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['nivel_acesso'] != 0) {
    header("Location: ../sing_in.php?error=Acesso negado.");
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salão de Beleza User Dashboard</title>
    <!-- Bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap css Icons-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .tamanho{
            width: 15rem;
            height: 15rem;
            font-size: 2em;
        }
    </style>
</head>
<body>
    
    <!-- memu -->
    <?php include '../../componentes/menuSeguro.php'; ?>
    <section class="container">
        <div class="mt-5">
            <h3 class="pt-5">
                <a class="link-offset-2 link-underline link-underline-opacity-0 text-dark" href="user_dashboard.php">
                    <i class="bi bi-house-check-fill"></i> Home
                </a>
            </h3>
            <hr class="mt-3">
        </div>
    </section>

    <section id="user_servicos">
    <!--Buttons -->
        <div class="container text-center">
            <div class="row align-items-start">
                <div class="col">
                    <button type="button" class="btn btn-outline-warning mb-3 tamanho" data-bs-toggle="modal" data-bs-target="#depoimentosModal"><i class="bi bi-megaphone-fill"></i><br>Depoimentos</button>
                </div>
                <div class="col">
                    <button onclick="window.location.href='user_agendamento.php'" type="button" class="btn btn-outline-primary mb-3 tamanho"><i class="bi bi-journal-text"></i><br>Agendamento</button>
                </div>
                <div class="col">
                    <button onclick="window.location.href='user_servicos.php'" type="button" class="btn btn-outline-secondary mb-3 tamanho"><i class="bi bi-house-gear-fill"></i><br>Serviços</button>
                </div>
                <div class="col ">
                    <button onclick="window.location.href='user_perfil.php'" type="button" class="btn btn-outline-danger mb-3 tamanho"><i class="bi bi-person-check-fill"></i><br>Meu Perfil</button>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade modal-xl" id="depoimentosModal" tabindex="-1" aria-labelledby="depoimentosModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h1 class="modal-title fs-3 w-100" id="depoimentosModalLabel"> Meus Depoimentos</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
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
                                        <h5 class="card-title">Deixe seu Depoimento</h5>
                                        <form>
                                            <div class="mb-3">
                                                <label for="nome" class="form-label">Nome</label>
                                                <input type="text" class="form-control" id="nomeDepoimento" placeholder="Digite seu nome">
                                            </div>
                                            <div class="mb-3">
                                                <label for="Depoimento" class="form-label">Depoimento</label>
                                                <textarea class="form-control" id="comentario" rows="3" placeholder="Escreva seu comentário"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-success w-100">Enviar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                    
                    </div>
                </div>
            </div>
        </div>        
    </section>

    <section id="Hitorico">
        <div class="container mt-3 mb-5">
            <div class="mt-2 mb-4">
                <h4><i class="bi bi-journal-check"></i> Historico de Agendamento</h4>
            </div>
            <div class="container-sm">
                <div class="table-responsive">
                    <table class="table mt-3 border-primary table-hover ">
                        <thead>
                        <thead class="table-primary text-center">
                            <th scope="col">#</th> 
                            <th scope="col">Nome</th>
                            <th scope="col">Horario</th>
                            <th scope="col">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th class="text-center" scope="row">1</th>
                            <td>Mark</td>
                            <td class="text-center">Otto</td>
                            <td class="text-center">
                                <i class="bi bi-eye text-primary fs-5"></i>
                                <i class="bi bi-arrow-repeat text-success fs-5"></i>
                                <i class="bi bi-trash3 text-danger fs-5"></i>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center" scope="row">2</th>
                            <td>Jacob</td>
                            <td class="text-center" >Thornton</td>
                            <td class="text-center">
                                <i class="bi bi-eye text-primary fs-5"></i>
                                <i class="bi bi-arrow-repeat text-success fs-5"></i>
                                <i class="bi bi-trash3 text-danger fs-5"></i>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center" scope="row">3</th>
                            <td>@twitter</td>
                            <td class="text-center">@mdo</td>
                            <td class="text-center">
                                <i class="bi bi-eye text-primary fs-5"></i>
                                <i class="bi bi-arrow-repeat text-success fs-5"></i>
                                <i class="bi bi-trash3 text-danger fs-5"></i>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <?php include '../../componentes/footerSeguro.php'; ?>
</body>
</html>