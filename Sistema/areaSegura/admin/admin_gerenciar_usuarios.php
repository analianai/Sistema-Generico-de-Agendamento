<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['username']) || $_SESSION['nivel_acesso'] != 1) {
    header("Location: ../../sing_in.php?error=Acesso negado.");
    exit;
}

// Conexão com o banco de dados
$mysqli = new mysqli("localhost", "root", "", "salao");

// Verifica se houve erro na conexão
if ($mysqli->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $mysqli->connect_error);
}

// Obtenha o ID do usuário logado
$user_id = $_SESSION['user_id'];

// Consulta para buscar usuários cadastrados
$query = "SELECT id, nome, sobrenome, username, celular, whatsapp, endereco, estado, cidade, cpf, data_nascimento, nivel_acesso FROM usuarios ORDER BY nome ASC";
$result = $mysqli->query($query);

if (!$result) {
    die('Erro ao executar a consulta: ' . $mysqli->error);
}

//deletar usuario
if (isset($_POST['deletar'])) {
    $id = $_POST['id'];

    if ($id > 1){
        $query = "DELETE FROM usuarios WHERE id = $id";
        $result = $mysqli->query($query);
        if (!$result) {
            die('Erro ao executar a consulta: ' . $mysqli->error);
        }
        header("Location: admin_gerenciar_usuarios.php");
        exit;
    } else{
        $_SESSION['mensagem_erro'] = 'Esse usuário não pode ser excluido.';
    }
    header("Location: admin_gerenciar_usuarios.php");
    exit;
}

//atualizar usuario
if (isset($_POST['atualizar'])) {
    $id = intval($_POST['id']);
    $novo_nivel = intval($_POST['nivel_acesso']);
    $username = $_POST['username'];
     if($id > 1){
        $query = "UPDATE usuarios SET username = ? , nivel_acesso = ? WHERE id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('sii', $username,$novo_nivel, $id);

        if ($stmt->execute()) {
            $_SESSION['mensagem_sucesso'] = "Nível e ou Email de acesso atualizado com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao atualizar nível de acesso e ou Email: " . $stmt->error;
        }
        header("Location: admin_gerenciar_usuarios.php");
        exit;
     } else{
        $_SESSION['mensagem_erro'] = 'Esse usuário não pode ser Atualizado.';
    }
    header("Location: admin_gerenciar_usuarios.php");
    exit; 
}

$cont = 0;
// Fecha a conexão com o banco de dados
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários</title>
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
</head>
<body>
    <!-- Inclui o mensagem de erro -->
    <?php include '../../componentes/erro.php'; ?>
    <!-- memu -->
    <?php include '../../componentes/menuSeguro.php'; ?>
    <!-- cabeçalho -->
    <section id="cabecalho" class="container">
        <div class="mt-5 d-flex justify-content-between">
            <h3 class="pt-5"><i class="bi bi-person-fill-gear"></i> Gerenciar Usuários</h3>
            <a href="admin_dashboard.php" type="button" class="btn-close pt-5 mt-4" aria-label="Close"></a>           
        </div>
        <hr>
    </section>
    <!-- Usuarios inseridos no sistema -->
<section id="usuarios" class="container">
    <div class="mt-5">
        <h4><i class="bi bi-people-fill"></i> Usuários</h4>
        <hr>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Nível de Acesso</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $result->fetch_assoc()) : ?>
                    <tr>
                        <th scope="row"><?= $cont= $cont + 1 ?></th>
                        <td><?php echo htmlspecialchars($user['nome'] . ' ' . $user['sobrenome']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td>
                            <?php 
                                if ($user['nivel_acesso'] == 0) {
                                    echo "Usuário Comum";
                                } elseif ($user['nivel_acesso'] == 1) {
                                    echo "Administrador";
                                } else {
                                    echo "Desconhecido";
                                }
                            ?>
                        </td>
                        <td>
                        
                            <!-- Botão Visualizar usuário -->
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalvisualizar<?php echo $user['id']; ?>">
                                <i class="bi bi-eye"></i>
                            </button>
                            <!--Modal Visualizar usuario -->
                            <div class="modal modal-lg" id="modalvisualizar<?php echo $user['id']; ?>" tabindex="-1" aria-labelledby="modalvisualizarLabel<?php echo $user['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white text-center">
                                            <h5 class="modal-title  w-100" id="modalvisualizarLabel<?php echo $user['id']; ?>"> <?php echo htmlspecialchars($user['nome'] . ' ' . $user['sobrenome']); ?></h5>
                                            <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg fs-5"></i></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p><strong>CPF:</strong> <?php echo htmlspecialchars($user['cpf']); ?></p> 
                                                </div>
                                                <div class="col-md-4">
                                                    <p><strong>Data Nascimento:</strong> <?php echo htmlspecialchars(date("d-m-Y", strtotime($user['data_nascimento']))); ?></p> 
                                                </div>
                                                <div class="col-md-4">
                                                <p><strong>Nível de Acesso: </strong> <?php 
                                                        if ($user['nivel_acesso'] == 0) {
                                                            echo "Usuário Comum";
                                                        } elseif ($user['nivel_acesso'] == 1) {
                                                            echo "Administrador";
                                                        } else {
                                                            echo "Desconhecido";
                                                        }
                                                    ?></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p><strong>Celular:</strong> <?php echo htmlspecialchars($user['celular']); ?></p>  
                                                </div>
                                                <div class="col-md-4">
                                                    <p><strong>Whatsapp:</strong> <?php echo htmlspecialchars($user['whatsapp']); ?></p>
                                                </div> 
                                                <div class="col-md-12">        
                                                    <p><strong>Endereço:</strong> <?php echo htmlspecialchars($user['endereco']); ?></p>
                                                </div>
                                                <div class="col-md-6">    
                                                    <p><strong>Cidade:</strong> <?php echo htmlspecialchars($user['cidade']); ?></p>  
                                                </div>
                                                <div class="col-md-6">     
                                                    <p><strong>Estado:</strong> <?php echo htmlspecialchars($user['estado']); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botão ATUALIZAR usuário -->
                            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalAtualizar<?php echo $user['id']; ?>">
                            <i class="bi bi-arrow-repeat"></i>
                            </button>
                            <!-- Modal ATUALIZAR usuário -->
                            <div class="modal" id="modalAtualizar<?php echo $user['id']; ?>" tabindex="-1" aria-labelledby="modalAtualizarLabel<?php echo $user['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success text-white text-center">
                                            <h5 class="modal-title  w-100" id="modalAtualizarLabel<?php echo $user['id']; ?>"> Atualize o nível de acesso e ou o email do usuário</h5>
                                            <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg fs-5"></i></button>
                                        </div>
                                        <div class="modal-body">
                                        <form action="admin_gerenciar_usuarios.php" method="post">
                                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                            <label for="username">Email:</label>
                                            <input type="email" name="username" class="form-control" id="username" placeholder="Email" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                                            <label for="nivel_acesso">Nível de Acesso:</label>
                                            <select name="nivel_acesso" id="nivel_acesso" class="form-select" >
                                                <option value="" selected>Nível de Acesso</option>
                                                <option value="0" <?php echo $user['nivel_acesso'] == '0' ? 'selected' : 'Usuário Comum'; ?>>Usuário Comum</option>
                                                <option value="1" <?php echo $user['nivel_acesso'] == '1' ? 'selected' : 'Administrador'; ?>>Administrador</option>
                                            </select>
                                            <div class="text-center">
                                                <button type="button" class="btn btn-outline-danger me-2" data-bs-dismiss="modal"><i class="bi bi-x-octagon-fill"></i> Cancelar</button>
                                                <button type="submit" name="atualizar" class="btn btn-outline-success"><i class="bi bi-arrow-repeat"></i> Salvar</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botão DELETAR usuário -->
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalDeletar<?php echo $user['id']; ?>">
                                <i class="bi bi-trash"></i>
                            </button>
                            <!-- Modal Deletar -->
                            <div class="modal" id="modalDeletar<?php echo $user['id']; ?>" tabindex="-1" aria-labelledby="modalDeletarLabel<?php echo $user['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content text-center">
                                        <div class="modal-header bg-danger text-white text-center">
                                            <h5 class="modal-title  w-100" id="modalDeletarLabel<?php echo $user['id']; ?>"> Tem certeza que deseja deletar o usuário?</h5>
                                            <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg fs-5"></i></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="admin_gerenciar_usuarios.php" method="post">
                                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                                <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal"><i class="bi bi-backspace-fill"></i> Voltar</button>
                                                <button type="submit" name="deletar" class="btn btn-outline-danger"><i class="bi bi-trash"></i> Excluir</button>
                                            </form>    
                                        </div>
                                    </div>
                                </div>
                            </div>                       
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</section>
 
    <!-- Inclui o footer -->
    <?php include '../../componentes/footerSeguro.php'; ?>
</body>
</html>