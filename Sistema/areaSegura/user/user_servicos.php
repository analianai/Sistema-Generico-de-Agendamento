<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['nivel_acesso'] != 0) {
    header("Location: ../sign_in.php?error=Acesso negado.");
    exit;
}

// conexão ao banco de dados
$mysqli = new mysqli("localhost", "root", "", "salao");

// Consultar categorias e serviços
$query_categorias = "SELECT cat_id, nome FROM categorias";
$result_categorias = $mysqli->query($query_categorias);

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
    <!-- Inclui o mensagem de erro -->
    <?php include '../../componentes/erro.php'; ?>
    <!-- memu -->
    <?php include '../../componentes/menuSeguro.php'; ?>

    <section class="container">
        <div class="mt-5 d-flex justify-content-between">
            <h3 class="pt-5"><i class="bi bi-house-gear-fill"></i> Serviços</h3>
            <a href="user_dashboard.php" type="button" class="btn-close pt-5 mt-4" aria-label="Close"></a>
        </div>
        <hr>
    </section>

    <section class="container">
    <?php while ($categoria = $result_categorias->fetch_assoc()) { 
            $categoria_id = $categoria['cat_id'];
            $query_servicos = "SELECT titulo, descricao, codigo, duracao, valor, observacao, imagem FROM servicos WHERE categoria_id = $categoria_id";
            $result_servicos = $mysqli->query($query_servicos);
        ?>
        <h4 class="mt-4 mb-4"><i class="bi bi-bookmark"></i> De <?php echo htmlspecialchars($categoria['nome']); ?></h4>
        <div class="row">
            <?php while ($servico = $result_servicos->fetch_assoc()) { ?>
            <div class="col-md-3">
                <div class="card mb-3 shadow-sm">
                    <img src="<?php echo htmlspecialchars($servico['imagem']); ?>" class="card-img-top" style="height:220px;" alt="Imagem do Serviço">
                    <div class="card-body" style="height:200px;">
                        <h5 class="card-title text-center"><?php echo htmlspecialchars($servico['titulo']); ?></h5>
                        <p class="card-text">
                            <b>Descrição:</b> <?php echo htmlspecialchars($servico['descricao']); ?>
                        </p>
                        <p class="card-text d-flex justify-content-between">
                            <b>Código:</b> <?php echo htmlspecialchars($servico['codigo']); ?>
                            <b>Duração:</b> <?php echo htmlspecialchars($servico['duracao']); ?> minutos
                        </p>
                        <p class="card-text text-center">
                            <b>Valor: </b><strong class="fs-5">R$ <?php echo htmlspecialchars($servico['valor']); ?></strong>
                        </p>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if ($result_servicos->num_rows == 0) { ?>
            <div class="col-12">
                <p>Nenhum serviço disponível nesta categoria.</p>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
    </section>
 
    <?php include '../../componentes/footerSeguro.php'; ?>
</body>
</html>