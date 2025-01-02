<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['nivel_acesso'] != 1) {
    header("Location: ../../sing_in.php?error=Acesso negado.");
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salão de Beleza Admin Dashboard</title>
    <!-- Bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap css Icons-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .tamanho{
            width: 15rem;
            height: 13rem;
            font-size: 1.5em;
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
    <?php include '../../componentes/menuSeguro.php'; ?>
    <!-- cabeçalho -->
    <section id="cabecalho" class="container">
        <div class="mt-5">
            <h3 class="pt-5"><i class="bi bi-house-check-fill"></i> Home</h3>
            <hr>
        </div>
    </section>
    <!-- buttons  -->
     <section id="buttons" class="container">
        <div class="row align-items-start text-center">
            <div class="col">
                <button onclick="window.location.href='admin_servicos.php'" type="button" class="btn btn-outline-lilas mb-3 tamanho"><i class="bi bi-house-gear-fill fs-2"></i><br>Serviços</button>
            </div>
            <div class="col">
                <button onclick="window.location.href='admin_relatorio.php'" type="button" class="btn btn-outline-primary mb-3 tamanho"><i class="bi bi-graph-up-arrow fs-2"></i><br>Relatórios</button>
            </div>
            <div class="col">
                <button  onclick="window.location.href='admin_gerenciar_usuarios.php'" type="button" class="btn btn-outline-info mb-3 tamanho"><i class="bi bi-person-fill-gear fs-2"></i><br>Gerenciar Usuários</button>
            </div>
            <div class="col">
                <button onclick="window.location.href='admin_agendamento.php'" type="button" class="btn btn-outline-secondary mb-3 tamanho"><i class="bi bi-person-lines-fill fs-2"></i><br>Agendamento</button>
            </div>
        </div>     
    </section>
    <!-- Historicos do agendamento dos ultimos 7 dias-->
         <!-- Historico de Agendamento-->
    <section id="Hitorico">
        <div class="container mt-3 mb-5">
            <div class="mt-2 mb-4">
                <h4><i class="bi bi-person-lines-fill"></i> Histórico de Agendamento</h4>
            </div>
            <div class="container-sm">
                <div class="table-responsive">
                    <table class="table mt-3 border-primary table-hover ">
                        <thead>
                        <thead class="table-primary text-center">
                            <th scope="col">#</th> 
                            <th scope="col">Nome</th>
                            <th scope="col">Data</th>
                            <th scope="col">Horário</th>
                            <th scope="col">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th class="text-center" scope="row">1</th>
                            <td>Mark</td>
                            <td class="text-center">31/01/2024</td>
                            <td class="text-center">16:00</td>
                            <td class="text-center">
                                <i class="bi bi-eye text-primary fs-5"></i>
                                <i class="bi bi-arrow-repeat text-success fs-5"></i>
                                <i class="bi bi-trash3 text-danger fs-5"></i>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center" scope="row">2</th>
                            <td>Jacob</td>
                            <td class="text-center">31/01/2024</td>
                            <td class="text-center">16:00</td>
                            <td class="text-center">
                                <i class="bi bi-eye text-primary fs-5"></i>
                                <i class="bi bi-arrow-repeat text-success fs-5"></i>
                                <i class="bi bi-trash3 text-danger fs-5"></i>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center" scope="row">3</th>
                            <td>Joana</td>
                            <td class="text-center">31/01/2024</td>
                            <td class="text-center">16:00</td>
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
