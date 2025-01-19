<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['nivel_acesso'] != 1) {
    header("Location: ../../sign_in.php?error=Acesso negado.");
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
            width: 10rem;
            height: 8rem;
            font-size: 1em;
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
        .btn-outline-verde{
            color:rgb(28, 229, 28);
            border-color: rgb(28, 229, 28);
        }
        .btn-outline-verde:hover{
            color: #fff;
            border-color: rgb(28, 229, 28);
            background-color: rgb(28, 229, 28);
        }
        #mensagem-sucesso, #mensagem-erro {
            position: fixed; /* Fixar a mensagem no topo da página */
            top: 20px; /* Distância do topo */
            left: 50%; /* Centraliza horizontalmente */
            transform: translateX(-50%); /* Ajusta a posição centralizada */
            z-index: 1050; /* Garante que a mensagem esteja acima de outros elementos */
            width: auto; /* Ajusta largura */
            max-width: 80%; /* Evita que a mensagem ocupe toda a tela */
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
                <button onclick="window.location.href='admin_gerenciar_site.php'" type="button" class="btn btn-outline-lilas mb-3 tamanho"><i class="bi bi-globe fs-2"></i><br>Gerenciar Site</button>
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
            <div class="col">
                <button onclick="window.location.href='admin_perfil.php'" type="button" class="btn btn-outline-danger mb-3 tamanho"><i class="bi bi-person-check-fill fs-2"></i><br>Meu Perfil</button>
            </div>
        </div>     
    </section>
    <!-- Historicos do agendamento-->
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
