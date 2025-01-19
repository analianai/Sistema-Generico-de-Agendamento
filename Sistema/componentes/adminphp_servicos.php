<?php
//SERVIÇOS

// Lógica de inserção de serviços
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'add') {
        $codigo_servico = $_POST['codigo'];
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $observacao = $_POST['observacao'];
        $duracao = $_POST['duracao'];
        $valor = $_POST['valor'];
        $categoria_id = $_POST['categoria_id'];
    
        // Verificar se a categoria é válida
        $stmt = $mysqli->prepare("SELECT COUNT(*) FROM categorias WHERE cat_id = ?");
        $stmt->bind_param('i', $categoria_id);
        $stmt->execute();
        $stmt->bind_result($categoria_valida);
        $stmt->fetch();
        $stmt->close();
    
        if ($categoria_valida == 0) {
            $_SESSION['mensagem_erro'] = 'A categoria selecionada não é válida!';
        } else {
            // Upload da imagem
            $imagem = '';
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
                $uploadDir = 'uploads/servicos/ ';
                $imagem = $uploadDir. basename($_FILES['imagem']['name']);
                move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem);
            }
    
            // Inserir no BD
            $stmt = $mysqli->prepare("INSERT INTO servicos (codigo, imagem, titulo, descricao, observacao, duracao, valor, categoria_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sssssidi', $codigo_servico, $imagem, $titulo, $descricao, $observacao, $duracao, $valor, $categoria_id);
            $stmt->execute();
    
            $_SESSION['mensagem_sucesso'] = 'Serviço cadastrado com sucesso!';
        }
        header("Location: admin_servicos.php");
        exit;
    } else {
        $_SESSION['mensagem_erro'] = 'Erro ao cadastrar o serviço!';
    }
}

//atualizar Serviços
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actionUpdate'])) {
    $action = $_POST['actionUpdate'];
    //atualizar
    if ($action === 'actionUpdate') {
        $id = $_POST['id'];
        $codigo_servico = $_POST['codigo'];
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $observacao = $_POST['observacao'];
        $duracao = $_POST['duracao'];
        $valor = $_POST['valor'];
        $categoria_id = $_POST['categoria_id'];
    
        // Atualizar imagem se necessário
        $imagem = $_POST['existing_imagem'];
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
            $uploadDir = 'uploads/servicos/';
            $imagem = $uploadDir . basename($_FILES['imagem']['name']);
            move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem);
        }
    
        // Atualizar no BD
        $stmt = $mysqli->prepare("
                        UPDATE servicos 
                        SET codigo = ?, imagem = ?, titulo = ?, descricao = ?, observacao = ?, duracao = ?, valor = ?, categoria_id = ?
                        WHERE id = ?");
        $stmt->bind_param('sssssidii', $codigo_servico, $imagem, $titulo, $descricao, $observacao, $duracao, $valor, $categoria_id, $id);
        $stmt->execute();

        $_SESSION['mensagem_sucesso'] = 'Serviço atualizado com sucesso!';
    } else {
        $_SESSION['mensagem_erro'] = 'Erro ao atualizar o serviço!';
    }

}

// deletar serviços
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actionDelete'])) {
    $action = $_POST['actionDelete'];
    // deletar serviços
    if ($action === 'actionDelete') {
        $id = $_POST['id'];

        // Deletar do BD
        $stmt = $mysqli->prepare("DELETE FROM servicos WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $_SESSION['mensagem_sucesso'] = 'Serviço Deletado com sucesso!';

    } else {
        $_SESSION['mensagem_erro'] = 'Erro ao deletar o serviço!';
    }

    // Redirecionar para evitar reenvio do formulário
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Recuperar serviços
$servicos = $mysqli->query("SELECT s.*, c.nome AS categoria_nome 
                            FROM servicos s 
                            LEFT JOIN categorias c ON s.categoria_id = c.cat_id 
                            ORDER BY c.nome ASC")->fetch_all(MYSQLI_ASSOC);

//CATEGORIAS

// Lógica de inserção de categorias
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actionCategoria'])) {
    $action = $_POST['actionCategoria'];

    if (isset($_POST['nova_categoria']) && !empty($_POST['nova_categoria'])) {
        $nova_categoria = trim($_POST['nova_categoria']); // Remover espaços extras
        $imagem_categoria = isset($_FILES['imagem_categoria']) ? $_FILES['imagem_categoria'] : null;

        // Verificar se a categoria já existe
        $stmt = $mysqli->prepare("SELECT COUNT(*) FROM categorias WHERE nome = ?");
        $stmt->bind_param('s', $nova_categoria);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            // Categoria já existe
            $_SESSION['mensagem_erro'] = 'A categoria já está cadastrada!';
        } else {
            // Upload da imagem
            $upload_diretorio = 'uploads/categorias/';
            if (!is_dir($upload_diretorio)) {
                mkdir($upload_diretorio, 0777, true);
            }

            $imagem_nome = '';
            if ($imagem_categoria && $imagem_categoria['error'] === UPLOAD_ERR_OK) {
                $extensao = pathinfo($imagem_categoria['name'], PATHINFO_EXTENSION);
                $imagem_nome = uniqid('cat_', true) . '.' . $extensao;
                move_uploaded_file($imagem_categoria['tmp_name'], $upload_diretorio . $imagem_nome);
            }

            // Inserir a nova categoria no banco de dados
            $stmt = $mysqli->prepare("INSERT INTO categorias (nome, imagem) VALUES (?, ?)");
            $stmt->bind_param('ss', $nova_categoria, $imagem_nome);
            $stmt->execute();
            $stmt->close();

            // Define a mensagem de sucesso na sessão
            $_SESSION['mensagem_sucesso'] = 'Categoria criada com sucesso!';
        }

        // Redirecionar para evitar reenvio do formulário
        header("Location: admin_servicos.php");
        exit;
    }
}


// Atualizar categoria
if ($_SERVER['REQUEST_METHOD'] === 'POST'  && isset($_POST['actionUpdateCategoria'])) {
    $action1 = $_POST['actionUpdateCategoria'] ?? '';

    if ($action1 === 'update_categoria') {
        $id = intval($_POST['cat_id']);
        $nome = trim($_POST['cat_nome'] ?? '');
        $imagem = $_FILES['cat_imagem'] ?? null;

        if ($id > 0 && !empty($nome)) {
            // Preparar a query de atualização
            $updateQuery = "UPDATE categorias SET nome = ?";

            // Verificar se há uma nova imagem
            if ($imagem && $imagem['error'] === UPLOAD_ERR_OK) {
                // Definir o diretório de upload e gerar o nome da imagem
                $target_dir = "uploads/categorias/";
                $image_name = uniqid("cat_") . basename($imagem["name"]);
                $target_file = $target_dir . $image_name;
                
                // Mover o arquivo para o diretório de upload
                if (move_uploaded_file($imagem["tmp_name"], $target_file)) {
                    // Se o upload da imagem for bem-sucedido, adicionar a imagem à query
                    $updateQuery .= ", imagem = ?";
                } else {
                    $_SESSION['mensagem_erro'] = "Erro ao fazer upload da imagem.";
                    header("Location: admin_servicos.php");
                    exit;
                }
            }

            // Finalizar a query
            $updateQuery .= " WHERE cat_id = ?";
            
            // Preparar a execução da query
            $stmt = $mysqli->prepare($updateQuery);
            if ($imagem && $imagem['error'] === UPLOAD_ERR_OK) {
                $stmt->bind_param('ssi', $nome, $image_name, $id);
            } else {
                $stmt->bind_param('si', $nome, $id);
            }

            // Executar a query
            if ($stmt->execute()) {
                $_SESSION['mensagem_sucesso'] = "Categoria atualizada com sucesso!";
            } else {
                $_SESSION['mensagem_erro'] = "Erro ao atualizar a categoria: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $_SESSION['mensagem_erro'] = "Dados inválidos para atualização.";
        }
        header("Location: admin_servicos.php");
        exit;
    }
    header("Location: admin_servicos.php");
    exit;
}

// Deletar categoria
if ($_SERVER['REQUEST_METHOD'] === 'POST'   && isset($_POST['actionDeleteCategoria'])) {
    $action1 = $_POST['actionDeleteCategoria'] ?? '';

    // Ação de deletar categoria
    if ($action1 === 'delete_categoria') {
        $id = intval($_POST['cat_id']);
        if ($id > 0) {
            // Verificar dependências na tabela de serviços
            $query = "SELECT COUNT(*) FROM servicos WHERE categoria_id = ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->bind_result($servicosCount);
            $stmt->fetch();
            $stmt->close();

            if ($servicosCount > 0) {
                $_SESSION['mensagem_erro'] = "Não é possível excluir a categoria. Existem $servicosCount serviços associados. Exclua ou atualize o serviço para outra categoria antes de excluir";
            } else {
                // Executar exclusão
                $deleteQuery = "DELETE FROM categorias WHERE cat_id = ?";
                $stmt = $mysqli->prepare($deleteQuery);
                $stmt->bind_param('i', $id);
                if ($stmt->execute()) {
                    $_SESSION['mensagem_sucesso'] = "Categoria excluída com sucesso!";
                } else {
                    $_SESSION['mensagem_erro'] = "Erro ao excluir a categoria: " . $stmt->error;
                }
                $stmt->close();
            }
        } else {
            $_SESSION['mensagem_erro'] = "ID inválido.";
        }
        header("Location: admin_servicos.php");
        exit;
    }
    header("Location: admin_servicos.php");
    exit;
}

// Consultar categorias para exibição
$categorias = [];
$result = $mysqli->query("SELECT * FROM categorias ORDER BY nome ASC");
if ($result) {
    $categorias = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
}

// Recuperar categorias existentes
$categorias = $mysqli->query("SELECT cat_id, nome,imagem FROM categorias ORDER BY nome ASC")->fetch_all(MYSQLI_ASSOC);

?>