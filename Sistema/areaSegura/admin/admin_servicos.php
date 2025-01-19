<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['nivel_acesso'] != 1) {
    header("Location: ../../sign_in.php?error=Acesso negado.");
    exit;
}

// Conexão com o banco de dados
$mysqli = new mysqli("localhost", "root", "", "salao");

// Verificar conexão
if ($mysqli->connect_error) {
    die("Falha na conexão: " . $mysqli->connect_error);
}

?>
<?php include '../../componentes/adminphp_servicos.php'; ?>

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
    <style>
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
    <!-- Bootstrap script-->
    <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
</head>
<body>
    <!-- Mensagem de erro -->
    <?php include '../../componentes/erro.php'; ?>

    <!-- menu -->
    <?php include '../../componentes/menuSeguro.php'; ?>

    <!--Header-->
    <section class="container">
        <div class="mt-5 d-flex justify-content-between">
            <h3 class="pt-5"><i class="bi bi-house-gear-fill"></i> Serviços</h3>
            <a href="admin_dashboard.php" type="button" class="btn-close pt-5 mt-4" aria-label="Close"></a>
        </div>
        <hr>
        <!-- Button NOVA categoria, visualizar categoria e Serviço -->
         <div class="row">
            <div class="col-md-6">
                <button type="button" class="btn text-primary mb-2" data-bs-toggle="modal" data-bs-target="#NovaCategoriaModal">
                    <i class="bi bi-plus"></i> Nova Categoria
                </button>
                <button type="button" class="btn text-primary mb-2" data-bs-toggle="modal" data-bs-target="#NovoServico">
                    <i class="bi bi-plus"></i> Novo Serviço
                </button>
            </div>
            <div class="col-md-6 text-end">
                <button type="button" class="btn btn-outline-primary mb-2" data-bs-toggle="modal" data-bs-target="#NovoServico">
                    <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </div> 

        <!-- Nova Categoria Modal -->
        <div class="modal fade" id="NovaCategoriaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="NovaCategoriaModalLabel">Nova Categoria</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="actionCategoria" value="add">
                            <div class="mb-3">
                                <input type="text" class="form-control" id="nova_categoria" name="nova_categoria" placeholder="Insira o nome da nova categoria" required>
                            </div>
                            <div class="mb-3">
                                <label for="imagem_categoria" class="form-label">Imagem da Categoria</label>
                                <input type="file" class="form-control" id="imagem_categoria" name="imagem_categoria" accept="image/*">
                            </div>
                            <div class="mb-3 text-center">
                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="bi bi-x-octagon-fill"></i> Cancelar</button>
                                <button type="submit" class="btn btn-outline-success"><i class="bi bi-floppy"></i> Criar Categoria</button>
                            </div>
                        </form>
                    </div>
                    <?php if (isset($_SESSION['mensagem_sucesso'])): ?>
                        <div class="alert alert-success mt-4" role="alert">
                            <?= $_SESSION['mensagem_sucesso']; unset($_SESSION['mensagem_sucesso']); ?>
                        </div>
                    <?php elseif (isset($_SESSION['mensagem_erro'])): ?>
                        <div class="alert alert-danger mt-4" role="alert">
                            <?= $_SESSION['mensagem_erro']; unset($_SESSION['mensagem_erro']); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Modal NOVO Serviço -->
        <div class="modal fade" id="NovoServico" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header text-center">
                    <h1 class="modal-title w-100 fs-5" id="NovoServicoLabel">Novo Serviço</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body">
                        <form action="" method="POST" enctype="multipart/form-data" class="row g-3">
                            <input type="hidden" name="action" value="add">
                            <div class="col-md-12">
                                <label for="titulo" class="form-label ">Título:</label>
                                <input type="text" class="form-control" name="titulo" placeholder="Título" required>
                            </div>
                            <div class="col-md-4">
                                <label for="duracao" class="form-label">Duração (minutos):</label>
                                <input type="number" class="form-control" name="duracao" placeholder="0" required>
                            </div>
                            <div class="col-md-4">
                                <label for="valor" class="form-label">Valor (R$):</label>
                                <input type="number" step="0.01" class="form-control" name="valor" placeholder="0.00" required>
                            </div>
                            <div class="col-md-4">
                                <label for="codigo" class="form-label">Código do Serviço:</label>
                                <input type="text" class="form-control" name="codigo" placeholder="Ex: SRV123" required>
                            </div>
                            <div class="col-md-12">
                                <label for="categoria" class="form-label">Categoria:</label>
                                <select name="categoria_id" id="categoria" class="form-select" required>
                                    <option value="">Selecione uma categoria</option>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= $categoria['cat_id'] ?>"><?= htmlspecialchars($categoria['nome']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="imagem" class="form-label">Imagem:</label>
                                <input type="file" class="form-control" name="imagem" required>
                            </div>
                            <div class="col-md-12">
                                <label for="descricao" class="form-label">Descrição:</label>
                                <textarea class="form-control" name="descricao" rows="2" placeholder="Insira a Descrição" required></textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="observacao" class="form-label">Observação:</label>
                                <textarea class="form-control" name="observacao" rows="2" placeholder="Insira sua Observação"></textarea>
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="button" class="btn btn-outline-danger me-1" data-bs-dismiss="modal"><i class="bi bi-x-octagon-fill"></i> Cancelar</button>
                                <button type="submit" class="btn btn-outline-success"><i class="bi bi-backspace-reverse-fill"></i> Criar Serviço</button>  
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>                             
    </section>

    <section id="categoria" class="container">
        <div class="mt-1 d-flex justify-content-start">
            <h4 class="pt-5"><i class="bi bi-card-checklist"></i> Categorias</h4>
        </div>
        <hr>
        <div class="row">
            <?php foreach ($categorias as $index => $categoria): ?>
                <!--Consultar categoria-->
                <div class="col-12 col-sm-3 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                        <img src="uploads/categorias/<?= htmlspecialchars($categoria['imagem']) ?>" class="card-img-top" style="height:220px;" alt="Imagem da Categoria">
                        <p class="card-title"><b>Categoria: </b><?= htmlspecialchars($categoria['nome']) ?> </p>
                            <!-- botão Atualização categoria-->
                            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#atualizarCategoria<?= $categoria['cat_id'] ?>">
                                <i class="bi bi-arrow-repeat fs-5"></i>
                            </button>
                            <!-- botão Excluir categoria-->
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#excluir<?= $categoria['cat_id'] ?>">
                                <i class="bi bi-trash fs-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Modal Atualizar Categoria-->
                <div class="modal fade" id="atualizarCategoria<?= $categoria['cat_id'] ?>" tabindex="-1" aria-labelledby="atualizarLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white text-center">
                                <h4 class="modal-title w-100 fs-5" id="atualizarLabel">Atualize a categoria <?= htmlspecialchars($categoria['nome']) ?></h4>
                                <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg fs-5"></i></button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulário com enctype para upload de arquivos -->
                                <form method="POST" action="admin_servicos.php" enctype="multipart/form-data">
                                    <input type="hidden" name="actionUpdateCategoria" value="update_categoria">
                                    <input type="hidden" name="cat_id" value="<?= htmlspecialchars($categoria['cat_id']) ?>">

                                    <!-- Campo para Nome da Categoria -->
                                    <input type="text" name="cat_nome" class="form-control" placeholder="Novo Nome" value="<?= htmlspecialchars($categoria['nome']) ?>" required>

                                    <!-- Campo para Upload de Imagem -->
                                    <div class="mt-3">
                                        <label for="cat_imagem">Nova Imagem:</label>
                                        <input type="file" name="cat_imagem" class="form-control" id="cat_imagem">
                                    </div>

                                    <button type="button" class="btn btn-outline-danger mt-3 me-2" data-bs-dismiss="modal"><i class="bi bi-x-octagon-fill"></i> Cancelar</button>
                                    <button type="submit" class="btn btn-outline-success mt-3"><i class="bi bi-arrow-repeat"></i> Salvar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Excluir Categoria-->
                <div class="modal fade" id="excluir<?= $categoria['cat_id'] ?>" tabindex="-1" aria-labelledby="excluirLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white text-center">
                                <h5 class="modal-title w-100 fs-5" id="excluirLabel">Deseja excluir a categoria <?= htmlspecialchars($categoria['nome']) ?> ? </h5>
                                <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg fs-5"></i></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action1="" class="d-inline">
                                    <input type="hidden" name="actionDeleteCategoria" value="delete_categoria">
                                    <input type="hidden" name="cat_id" value="<?= htmlspecialchars($categoria['cat_id']) ?>">
                                    <button type="button" class="btn btn-outline-success me-2" data-bs-dismiss="modal"><i class="bi bi-backspace-fill"></i> Voltar</button>
                                    <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i> Excluir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?> 
        </div> 
    </section>

    <!--Serviços por categorias--> 
    <section id="admin_servicos" class="container pt-2 ">
        <?php 
        // Organizar serviços por categorias
        $categorias_servicos = [];
        foreach ($servicos as $servico) {
            $categoria_nome = $servico['categoria_nome'] ?? 'Sem categoria';
            $categorias_servicos[$categoria_nome][] = $servico;
        }
        ?>

        <?php foreach ($categorias_servicos as $categoria => $servicos): ?>
            <div class="mb-4">
                <h4 class="card-text"><i class="bi bi-bookmark-plus"></i> Categoria <?= htmlspecialchars($categoria) ?></h4>
                <hr class="mb-4">
                <div class="row mt-3">
                    <?php foreach ($servicos as $servico): ?>
                        <div class="col-md-3">
                            <div class="card mb-4 shadow-sm">
                                <img src="<?= htmlspecialchars($servico['imagem']) ?>" class="card-img-top" style="height:220px;" alt="Imagem do Serviço">
                                <div class="card-body">
                                    <h5 class="card-title text-center"><?= htmlspecialchars($servico['titulo']) ?></h5>
                                    <p class="card-text">Descrição: <?= htmlspecialchars($servico['descricao']) ?></p>
                                    <div class="d-flex justify-content-between">
                                        <p class="card-text">Código: <?= htmlspecialchars($servico['codigo']) ?></p>
                                        <p class="card-text">Duração: <?= $servico['duracao'] ?> minutos</p>
                                    </div>
                                    <p class="card-text">Valor: <strong class="fs-4">R$ <?= number_format($servico['valor'], 2, ',', '.') ?></strong></p>
                                    <p class="card-text">Observação: <?= htmlspecialchars($servico['observacao']) ?></p>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-outline-success me-3" data-bs-toggle="modal" data-bs-target="#AtualizarServico<?= $servico['id'] ?>">
                                            <i class="bi bi-arrow-repeat"></i> Atualizar
                                        </button>
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#DeletarServico<?= $servico['id'] ?>">
                                            <i class="bi bi-trash"></i> Deletar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal de Atualização Serviço-->
                        <div class="modal fade" id="AtualizarServico<?= $servico['id'] ?>" tabindex="-1" aria-labelledby="AtualizarServicoLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header text-center bg-success text-white">
                                        <h5 class="modal-title w-100" id="AtualizarServicoLabel">Atualizar Serviço</h5>
                                        <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg fs-5"></i></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="POST" enctype="multipart/form-data" class="row">
                                            <input type="hidden" name="actionUpdate" value="actionUpdate">
                                            <input type="hidden" name="id" value="<?= $servico['id'] ?>">
                                            <input type="hidden" name="existing_imagem" value="<?= htmlspecialchars($servico['imagem']) ?>">

                                            <!-- Campo de Título -->
                                            <div class="col-md-12">
                                                <label for="titulo" class="form-label">Título:</label>
                                                <input type="text" class="form-control" name="titulo" value="<?= htmlspecialchars($servico['titulo']) ?>" required>
                                            </div>

                                            <!-- Campo de Duração -->
                                            <div class="col-md-4">
                                                <label for="duracao" class="form-label">Duração (m):</label>
                                                <input type="number" class="form-control" name="duracao" value="<?= $servico['duracao'] ?>" required>
                                            </div>

                                            <!-- Campo de Valor -->
                                            <div class="col-md-4">
                                                <label for="valor" class="form-label">Valor (R$):</label>
                                                <input type="number" step="0.01" class="form-control" name="valor" value="<?= $servico['valor'] ?>" required>
                                            </div>

                                            <!-- Campo de Código -->
                                            <div class="col-md-4">
                                                <label for="codigo" class="form-label">Código do Serviço:</label>
                                                <input type="text" class="form-control" name="codigo" value="<?= htmlspecialchars($servico['codigo']) ?>" required>
                                            </div>

                                            <!-- Campo de Categoria -->
                                            <div class="col-md-12">
                                                <label for="categoria" class="form-label">Categoria:</label>
                                                <select name="categoria_id" id="categoria" class="form-select" required>
                                                    <option value="">Selecione uma categoria</option>
                                                    <?php foreach ($categorias as $categoria): ?>
                                                        <option value="<?= $categoria['cat_id'] ?>" <?= $servico['categoria_id'] == $categoria['cat_id'] ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($categoria['nome']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <!-- Campo de Imagem -->
                                            <div class="col-md-12">
                                                <label for="imagem" class="form-label">Nova Imagem:</label>
                                                <input type="file" class="form-control" name="imagem">
                                            </div>

                                            <!-- Campo de Descrição -->
                                            <div class="col-md-12">
                                                <label for="descricao" class="form-label">Descrição:</label>
                                                <textarea class="form-control" name="descricao" rows="2" required><?= htmlspecialchars($servico['descricao']) ?></textarea>
                                            </div>

                                            <!-- Campo de Observação -->
                                            <div class="col-md-12">
                                                <label for="observacao" class="form-label">Observação:</label>
                                                <textarea class="form-control" name="observacao" rows="1"><?= htmlspecialchars($servico['observacao']) ?></textarea>
                                            </div>

                                            <!-- Botões -->
                                            <div class="col-md-12 text-center mt-3 mb-3">
                                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="bi bi-x-octagon-fill"></i> Cancelar</button>
                                                <button type="submit" class="btn btn-outline-success me-3"><i class="bi bi-arrow-repeat"></i> Salvar</button> 
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal de Confirmação de Deleção Categoria-->
                        <div class="modal fade" id="DeletarServico<?= $servico['id'] ?>" tabindex="-1" aria-labelledby="DeletarServicoLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-center text-white">
                                        <h5 class="modal-title w-100" id="DeletarServicoLabel">
                                            Deseja excluir o serviço <strong><?= $servico['titulo'] ?></strong>?<br>
                                            <i class="fs-6">* O serviço será removido permanentemente.</i>
                                        </h5>
                                        <button type="button" class="btn text-white top-0" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg fs-5"></i></button>
                                    </div>
                                    <div class="modal-body text-center">                                   
                                        <button type="button" class="btn btn-outline-success mt-4 me-3" data-bs-dismiss="modal"><i class="bi bi-backspace-fill"></i> Voltar</button>
                                        <form action="" method="POST" style="display:inline;">
                                            <input type="hidden" name="actionDelete" value="actionDelete">
                                            <input type="hidden" name="id" value="<?= $servico['id'] ?>">
                                            <button type="submit" class="btn btn-outline-danger mt-4"><i class="bi bi-trash"></i> Sim</button>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </section>

    <!--Footer rodapé-->
    <?php include '../../componentes/footerSeguro.php'; ?>
</body>
</html>