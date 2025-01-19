<?php
session_start();

// conexão ao banco de dados
$mysqli = new mysqli("localhost", "root", "", "salao");

// Consultar categorias e serviços
$query_categorias = "SELECT cat_id, nome FROM categorias ORDER BY nome ASC";
$result_categorias = $mysqli->query($query_categorias);

?>
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
    <section class="container">
    <?php while ($categoria = $result_categorias->fetch_assoc()) { 
            $categoria_id = $categoria['cat_id'];
            $query_servicos = "SELECT titulo, descricao, codigo, duracao, valor, observacao, imagem FROM servicos WHERE categoria_id = $categoria_id";
            $result_servicos = $mysqli->query($query_servicos);
        ?>
        <h4 class="mt-4 mb-4"><i class="bi bi-bookmark"></i> <?php echo htmlspecialchars($categoria['nome']); ?></h4>
        <div class="row">
            <?php while ($servico = $result_servicos->fetch_assoc()) { ?>
            <div class="col-md-3">
                <div class="card mb-2 shadow-sm">
                    <img src="areaSegura/admin/<?php echo htmlspecialchars($servico['imagem']); ?>" class="card-img-top" style="height:220px;" alt="Imagem do Serviço">
                    <div class="card-body" style="height:250px;">
                        <h5 class="card-title text-center"><?php echo htmlspecialchars($servico['titulo']); ?></h5>
                        <p class="card-text">
                            <b>Descrição:</b> <?php echo htmlspecialchars($servico['descricao']); ?>
                        </p>
                        <p class="card-text d-flex justify-content-start">
                            <b>Duração: </b><?php echo htmlspecialchars($servico['duracao']); ?> minutos
                        </p>
                        <p class="card-text text-center">            
                            <a href="#" class="text-primary text-decoration-none" data-bs-toggle="modal" data-bs-target="#agendamentoModal" data-bs-dismiss="modal">Entre</a>
                            ou 
                            <a href="#" class="text-primary text-decoration-none" data-bs-toggle="modal" data-bs-target="#cadastroModal" data-bs-dismiss="modal">Cadastre-se</a>
                             <br> Para agendar seu atendimento.
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
 
    <!-- Footer -->
    <?php include './componentes/footer.php'; ?>    
</body>
</html>
