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
    <title>Serviços</title>
        <!-- Bootstrap css-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap css Icons-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>
    <!-- memu -->
    <?php include '../../componentes/menuSeguro.php'; ?>

    <section class="container">
        <div class="mt-5 d-flex justify-content-between">
            <h3 class="pt-5"><i class="bi bi-journal-text"></i> Agendamento</h3>
            <a href="user_dashboard.php" type="button" class="btn-close pt-5 mt-4" aria-label="Close"></a>
        </div>
        <hr>
    </section>

    <?php include '../../componentes/footerSeguro.php'; ?>
</body>
</html>