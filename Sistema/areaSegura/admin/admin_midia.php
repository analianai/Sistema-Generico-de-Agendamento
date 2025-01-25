<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['username']) || $_SESSION['nivel_acesso'] != 1) {
    header("Location: ../../sign_in.php?error=Acesso negado.");
    exit;
}

// Conexão com o banco de dados
$mysqli = new mysqli("localhost", "root", "", "salao");

// Verifica se houve erro na conexão
if ($mysqli->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $mysqli->connect_error);
}

// Inserir mídia
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['inserirMidia'])) {
    $tipo_midia = $_POST['tipo_midia'];
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
    $caminho = '';

    if ($tipo_midia === 'foto') {
        if (isset($_FILES['foto_file']) && $_FILES['foto_file']['error'] == 0) {
            $foto_nome = basename($_FILES['foto_file']['name']);
            $upload_dir = "uploads/midia/";
            $caminho = $upload_dir . uniqid() . "_" . $foto_nome;

            if (move_uploaded_file($_FILES['foto_file']['tmp_name'], $caminho)) {
                $tipo = 'foto';
            } else {
                $_SESSION['mensagem_erro'] = "Erro ao fazer upload da foto.";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
        } else {
            $_SESSION['mensagem_erro'] = "Nenhuma foto enviada ou erro no envio.";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    } elseif ($tipo_midia === 'video') {
        if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] == 0) {
            $video_nome = basename($_FILES['video_file']['name']);
            $upload_dir = "uploads/midia/";
            $caminho = $upload_dir . uniqid() . "_" . $video_nome;

            if (move_uploaded_file($_FILES['video_file']['tmp_name'], $caminho)) {
                $tipo = 'video';
            } else {
                $_SESSION['mensagem_erro'] = "Erro ao fazer upload do vídeo.";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
        } else {
            $_SESSION['mensagem_erro'] = "Nenhum vídeo enviado ou erro no envio.";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    } elseif ($tipo_midia === 'youtube') {
        if (!empty($_POST['youtube_url'])) {
            $caminho = trim($_POST['youtube_url']);
            $tipo = 'youtube';
        } else {
            $_SESSION['mensagem_erro'] = "URL do YouTube não informada.";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    } else {
        $_SESSION['mensagem_erro'] = "Tipo de mídia inválido.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // Insere no banco de dados
    $stmt = $mysqli->prepare("INSERT INTO midia (tipo, caminho, descricao, data_upload) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $tipo, $caminho, $descricao); // Tipo como string, caminho como string, descrição como string

    if ($stmt->execute()) {
        $_SESSION['mensagem_sucesso'] = "Mídia inserida com sucesso!";
    } else {
        $_SESSION['mensagem_erro'] = "Erro ao inserir mídia: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}


//ATUALIZAR
//Atualizar Fotos e video
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateMidia'])) {
    $midia_id = intval($_POST['midia_id']);
    $descricao = $mysqli->real_escape_string($_POST['descricao']);

    // Inicializa a query de atualização
    $queryUpdate = "UPDATE midia SET descricao = '$descricao' WHERE midia_id = $midia_id ";

    // Verifica se um novo de fotoarquivo foi enviado
    if (!empty($_FILES['foto_file']['name'])) {
        $midiaNome = basename($_FILES['foto_file']['name']);
        $midiaTemp = $_FILES['foto_file']['tmp_name'];
        $midiaCaminho = "uploads/midia/" . $midiaNome;

        // Move o arquivo para o diretório de uploads
        if (move_uploaded_file($midiaTemp, $midiaCaminho)) {
            $midiaCaminho = $mysqli->real_escape_string($midiaCaminho);
            $queryUpdate = "UPDATE midia SET caminho = '$midiaCaminho', descricao = '$descricao' WHERE midia_id = $midia_id and tipo = 'foto'";
        } else {
            $_SESSION['mensagem_erro'] = 'Erro ao enviar a foto.';
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    // Verifica se um novo de video arquivo foi enviado
    if (!empty($_FILES['video_file']['name'])) {
        $midiaNome = basename($_FILES['video_file']['name']);
        $midiaTemp = $_FILES['video_file']['tmp_name'];
        $midiaCaminho = "uploads/midia/" . $midiaNome;

        // Move o arquivo para o diretório de uploads
        if (move_uploaded_file($midiaTemp, $midiaCaminho)) {
            $midiaCaminho = $mysqli->real_escape_string($midiaCaminho);
            $queryUpdate = "UPDATE midia SET caminho = '$midiaCaminho', descricao = '$descricao' WHERE midia_id = $midia_id and tipo = 'video'";
        } else {
            $_SESSION['mensagem_erro'] = 'Erro ao enviar o video.';
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    if ($mysqli->query($queryUpdate)) {
        $_SESSION['mensagem_sucesso'] = 'Video atualizada com sucesso!';
    } else {
        $_SESSION['mensagem_erro'] = 'Erro ao atualizar a Video: ' . $mysqli->error;
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

//EXCLUIR
// Excluir Midia
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteMidia'])) {
    $midia_id = intval($_POST['midia_id']);

    // Obtém o caminho do arquivo para excluir fisicamente
    $queryGetPath = "SELECT caminho FROM midia WHERE midia_id = $midia_id";
    $result = $mysqli->query($queryGetPath);
    $row = $result->fetch_assoc();
    $midiaCaminho = $row['caminho'];

    if (unlink($midiaCaminho)) {  // Remove a midia do servidor
        $queryDelete = "DELETE FROM midia WHERE midia_id = $midia_id";
        if ($mysqli->query($queryDelete)) {
            echo "Midia excluída com sucesso!";
        } else {
            echo "Erro ao excluir a Mídia: " . $mysqli->error;
        }
    } else {
        echo "Erro ao excluir a mídia do servidor.";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}


//visualizar
// Fotos
$queryMidiaFotos = "
        SELECT 
        midia_id, tipo, caminho, descricao, data_upload 
        FROM 
        midia 
        WHERE
        tipo = 'foto'";
$resultMidiaFotos = $mysqli->query($queryMidiaFotos);

$midiasFotos = [];
while ($row = $resultMidiaFotos->fetch_assoc()) {
    $midiasFotos[] = $row;
}

// Fotos
$queryMidiaVideo = "
        SELECT 
        midia_id, tipo, caminho, descricao, data_upload 
        FROM 
        midia 
        WHERE
        tipo = 'video'";
$resultMidiaVideo = $mysqli->query($queryMidiaVideo);

$midiasVideos = [];
while ($row = $resultMidiaVideo->fetch_assoc()) {
    $midiasVideos[] = $row;
}

// Fotos
$queryMidiaYoutube = "
        SELECT 
        midia_id, tipo, caminho, descricao, data_upload 
        FROM 
        midia 
        WHERE
        tipo = 'youtube'";
$resultMidiaYoutube = $mysqli->query($queryMidiaYoutube);

$midiasYoutube = [];
while ($row = $resultMidiaYoutube->fetch_assoc()) {
    $midiasYoutube[] = $row;
}

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
        .img-card{
            height: 260px;
        }
    </style>
</head>
<body>
    <!-- Inclui o mensagem de erro -->
    <?php include '../../componentes/erro.php'; ?>
    <!-- memu -->
    <?php include '../../componentes/menuSeguro.php'; ?>
    
    <!-- cabeçalho inclusir midia -->
    <section id="cabecalho" class="container">
        <div class="mt-5 d-flex justify-content-between">
            <h3 class="pt-5"><i class="bi bi-camera-reels fs-2"></i> Mídia</h3>
            <a href="admin_dashboard.php" type="button" class="btn-close pt-5 mt-4" aria-label="Close"></a>           
        </div>
        <hr>

        <!-- Button midia -->
        <div class="row">
            <div class="col-md-12 col-12">
                <!-- Novas Fotos ou videos  -->
                <button type="button" class="btn text-primary" data-bs-toggle="modal" data-bs-target="#FotosVideosModal">
                    <i class="bi bi-plus"></i> Inserir Fotos ou videos
                </button>
            </div>
        </div> 

        <!-- Modal para Inserir Foto ou Vídeo -->
        <div class="modal fade" id="FotosVideosModal" tabindex="-1" aria-labelledby="FotosVideosModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center bg-info">
                        <h1 class="modal-title fs-5 w-100" id="FotosVideosModalLabel">Inserir Nova Mídia</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="inserirMidia" value="inserirMidia">

                            <div class="mb-3">
                                <label class="form-label">Escolha o tipo de mídia:</label>
                                <select class="form-select form-control" id="tipo_midia" name="tipo_midia" required>
                                    <option selected>Escolha o tipo de mídia</option>
                                    <option value="foto">Foto</option>
                                    <option value="video">Upload de Vídeo</option>
                                    <option value="youtube">Link do YouTube</option>
                                </select>
                            </div>

                            <div id="foto_upload" class="mb-3">
                                <label for="foto_file" class="form-label">Envie sua foto:</label>
                                <input type="file" class="form-control" name="foto_file" accept="image/*">
                            </div>

                            <div id="upload_video" class="mb-3" style="display:none;">
                                <label for="video_file" class="form-label">Envie seu vídeo:</label>
                                <input type="file" class="form-control" name="video_file" accept="video/*">
                            </div>

                            <div id="youtube_link" class="mb-3" style="display:none;">
                                <label for="youtube_url" class="form-label">Link do YouTube:</label>
                                <input type="url" class="form-control" name="youtube_url" placeholder="https://youtube.com/..." pattern="https?://.*" />
                            </div>

                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição:</label>
                                <input type="text" class="form-control" name="descricao">
                            </div>

                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-outline-success mt-4"><i class="bi bi-upload"></i> Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visualizar Fotos -->
    <section id="fotos" class="container">
        <div class="mt-2 d-flex justify-content-between">
            <h4 class="pt-5"><i class="bi bi-images"></i> Fotos</h4>           
        </div>
        <hr>
        <div class="row">
            <?php foreach ($midiasFotos as $midiasFoto): ?>
                <div class="col-12 col-md-4 mb-3">
                    <div class="card">
                        <img src="<?php echo $midiasFoto['caminho']; ?>" class="img-card card-img-top img-fluid">
                        <div class="card-body">
                            <p class="card-text"><strong>Descrição: </strong><?php echo htmlspecialchars($midiasFoto['descricao']); ?></p>
                        
                            <div class="d-flex justify-content-center mb-2">
                                <!-- Botão Atualizar localização -->
                                <a href="#" 
                                class="btn btn-outline-success me-2" 
                                data-bs-toggle="modal" 
                                data-bs-target="#updateFotosModal_<?php echo $midiasFoto['midia_id']; ?>">
                                    <i class="bi bi-arrow-repeat"></i> Atualizar
                                </a>

                                <!-- Botão Excluir localização -->
                                <a href="#" 
                                class="btn btn-outline-danger" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteFotosModal_<?php echo $midiasFoto['midia_id']; ?>">
                                    <i class="bi bi-trash"></i> Excluir
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Atualizar Foto --> 
                <div class="modal fade" id="updateFotosModal_<?php echo $midiasFoto['midia_id']; ?>" tabindex="-1" aria-labelledby="updateFotosModalLabel_<?php echo $midiasFoto['midia_id']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center bg-success">
                                <h1 class="modal-title fs-5 w-100 text-white" id="updateFotosModalLabel_<?php echo $midiasFoto['midia_id']; ?>">
                                    Atualizar Foto
                                </h1>
                                <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="bi bi-x-lg fs-5"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <!-- Campo oculto para identificar a ação -->
                                    <input type="hidden" name="updateMidia" value="1">
                                    <input type="hidden" name="midia_id" value="<?php echo $midiasFoto['midia_id']; ?>">

                                    <div class="mb-3">
                                        <label class="form-label">Tipo:</label>
                                        <input class="form-control" type="text" value="<?php echo htmlspecialchars($midiasFoto['tipo']); ?>" disabled>
                                    </div>

                                    <div id="foto_upload" class="mb-3">
                                        <label for="foto_file_<?php echo $midiasFoto['midia_id']; ?>" class="form-label">Envie sua foto:</label>
                                        <input type="file" class="form-control" name="foto_file" id="foto_file_<?php echo $midiasFoto['midia_id']; ?>" accept="image/*">
                                    </div>

                                    <div class="mb-3">
                                        <label for="descricao_<?php echo $midiasFoto['midia_id']; ?>" class="form-label">Descrição:</label>
                                        <input type="text" class="form-control" name="descricao" id="descricao_<?php echo $midiasFoto['midia_id']; ?>" value="<?php echo htmlspecialchars($midiasFoto['descricao']); ?>">
                                    </div>

                                    <div class="mb-3 text-center">
                                        <button type="button" class="btn btn-outline-danger mt-4 me-2" data-bs-dismiss="modal">
                                            <i class="bi bi-x-octagon-fill"></i> Cancelar
                                        </button>
                                        <button type="submit" class="btn btn-outline-success mt-4">
                                            <i class="bi bi-arrow-repeat"></i> Atualizar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Excluir Foto -->
                <div class="modal fade" id="deleteFotosModal_<?php echo $midiasFoto['midia_id']; ?>" tabindex="-1" aria-labelledby="deleteFotosModalLabel_<?php echo $midiasFoto['midia_id']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center bg-danger">
                                <h1 class="modal-title fs-5 w-100 text-white" id="deleteFotosModalLabel_<?php echo $midiasFoto['midia_id']; ?>">Deseja deletar a Foto?</h1>
                                <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="bi bi-x-lg fs-5"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="POST">
                                    <input type="hidden" name="deleteMidia" value="deleteMidia">
                                    <input type="hidden" name="midia_id" value="<?php echo $midiasFoto['midia_id']; ?>">

                                    <div class="mb-3 text-center">
                                        <button type="button" class="btn btn-outline-success mt-2 me-2" data-bs-dismiss="modal">
                                            <i class="bi bi-x-octagon-fill"></i> Não
                                        </button>
                                        <button type="submit" class="btn btn-outline-danger mt-2">
                                            <i class="bi bi-trash"></i> Sim
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>        
    </section>

    <!-- Visualizar Vídeos -->
    <section id="videos" class="container">
        <div class="mt-2 d-flex justify-content-between">
            <h4 class="pt-5"><i class="bi bi-camera-video"></i> Vídeos</h4>            
        </div>
        <hr>    
            <div class="row">
                <?php foreach ($midiasVideos as $midiasVideo): ?>
                    <div class="col-12 col-md-4 mb-3">
                        <div class="card">
                            <video width="100%" controls>
                                <source src="<?php echo $midiasVideo['caminho']; ?>" type="video/mp4">
                                Seu navegador não suporta o elemento de vídeo.
                            </video>
                            <div class="card-body">
                                <p class="card-text"><strong>Descrição: </strong><?php echo $midiasVideo['descricao']; ?></p>
                                <div class="d-flex justify-content-center mb-2">
                                    <!-- Botão Atualizar localização -->
                                    <a href="#" 
                                    class="btn btn-outline-success me-2" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateVideosModal_<?php echo $midiasVideo['midia_id']; ?>">
                                        <i class="bi bi-arrow-repeat"></i> Atualizar
                                    </a>

                                    <!-- Botão Excluir localização -->
                                    <a href="#" 
                                    class="btn btn-outline-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteVideosModal_<?php echo $midiasVideo['midia_id']; ?>">
                                        <i class="bi bi-trash"></i> Excluir
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Atualizar Video --> 
                    <div class="modal fade" id="updateVideosModal_<?php echo $midiasVideo['midia_id']; ?>" tabindex="-1" aria-labelledby="updateVideosModalLabel_<?php echo $midiasVideo['midia_id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-center bg-success">
                                    <h1 class="modal-title fs-5 w-100 text-white" id="updateVideosModalLabel_<?php echo $midiasVideo['midia_id']; ?>">
                                        Atualizar Video
                                    </h1>
                                    <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="bi bi-x-lg fs-5"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <!-- Campo oculto para identificar a ação -->
                                        <input type="hidden" name="updateMidia" value="1">
                                        <input type="hidden" name="midia_id" value="<?php echo $midiasVideo['midia_id']; ?>">

                                        <div class="mb-3">
                                            <label class="form-label">Tipo:</label>
                                            <input class="form-control" type="text" value="<?php echo htmlspecialchars($midiasVideo['tipo']); ?>" disabled>
                                        </div>
                                        <div id="upload_video" class="mb-3">
                                            <label for="video_file_<?php echo $midiasVideo['midia_id']; ?>" class="form-label">Envie seu vídeo:</label>
                                            <input type="file" class="form-control" name="video_file" id="foto_video_<?php echo $midiasvideo['midia_id']; ?>" accept="video/*">
                                        </div>
                                        <div class="mb-3">
                                            <label for="descricao_<?php echo $midiasVideo['midia_id']; ?>" class="form-label">Descrição:</label>
                                            <input type="text" class="form-control" name="descricao" id="descricao_<?php echo $midiasVideo['midia_id']; ?>" value="<?php echo htmlspecialchars($midiasVideo['descricao']); ?>">
                                        </div>

                                        <div class="mb-3 text-center">
                                            <button type="button" class="btn btn-outline-danger mt-4 me-2" data-bs-dismiss="modal">
                                                <i class="bi bi-x-octagon-fill"></i> Cancelar
                                            </button>
                                            <button type="submit" class="btn btn-outline-success mt-4">
                                                <i class="bi bi-arrow-repeat"></i> Atualizar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Excluir video -->
                    <div class="modal fade" id="deleteVideosModal_<?php echo $midiasVideo['midia_id']; ?>" tabindex="-1" aria-labelledby="deleteVideosModalLabel_<?php echo $midiasVideo['midia_id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-center bg-danger">
                                    <h1 class="modal-title fs-5 w-100 text-white" id="deleteVideosModalLabel_<?php echo $midiasVideo['midia_id']; ?>">Deseja deletar o vídeo?</h1>
                                    <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="bi bi-x-lg fs-5"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST">
                                        <input type="hidden" name="deleteMidia" value="deleteMidia">
                                        <input type="hidden" name="midia_id" value="<?php echo $midiasVideo['midia_id']; ?>">

                                        <div class="mb-3 text-center">
                                            <button type="button" class="btn btn-outline-success mt-2 me-2" data-bs-dismiss="modal">
                                                <i class="bi bi-x-octagon-fill"></i> Não
                                            </button>
                                            <button type="submit" class="btn btn-outline-danger mt-2">
                                                <i class="bi bi-trash"></i> Sim
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
    </section>

    <!-- Visualizar Vídeos do YouTube -->
    <section id="videosYoutube" class="container">
        <div class="mt-2 d-flex justify-content-between">
            <h4 class="pt-5"><i class="bi bi-youtube"></i> Vídeos do YouTube</h4>            
        </div>
        <hr>

        <div class="row">
            <?php foreach ($midiasYoutube as $midiaYoutube): ?>
                <div class="col-12 col-md-4 mb-4">
                    <div class="card">
                        <div class="ratio ratio-16x9">
                            <iframe src="<?php echo htmlspecialchars($midiaYoutube['caminho']); ?>" title="Vídeo 1" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><strong>Descrição: </strong><?php echo $midiaYoutube['descricao']; ?></p>
                            <div class="d-flex justify-content-center mb-2">
                                <!-- Botão Atualizar localização -->
                                <a href="#" 
                                class="btn btn-outline-success me-2" 
                                data-bs-toggle="modal" 
                                data-bs-target="#updateYoutubeModal_<?php echo $midiaYoutube['midia_id']; ?>">
                                    <i class="bi bi-arrow-repeat"></i> Atualizar
                                </a>

                                <!-- Botão Excluir localização -->
                                <a href="#" 
                                class="btn btn-outline-danger" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteYoutubeModal_<?php echo $midiaYoutube['midia_id']; ?>">
                                    <i class="bi bi-trash"></i> Excluir
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Excluir Youtube -->
                <div class="modal fade" id="deleteYoutubeModal_<?php echo $midiaYoutube['midia_id']; ?>" tabindex="-1" aria-labelledby="deleteYoutubeModalLabel_<?php echo $midiaYoutube['midia_id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-center bg-danger">
                                    <h1 class="modal-title fs-5 w-100 text-white" id="deleteYoutubeModalLabel_<?php echo $midiaYoutube['midia_id']; ?>">Deseja deletar a Foto? id=<?php echo $midiaYoutube['midia_id']; ?></h1>
                                    <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="bi bi-x-lg fs-5"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST">
                                        <input type="hidden" name="deleteMidia" value="deleteMidia">
                                        <input type="hidden" name="midia_id" value="<?php echo $midiaYoutube['midia_id']; ?>">

                                        <div class="mb-3 text-center">
                                            <button type="button" class="btn btn-outline-success mt-2 me-2" data-bs-dismiss="modal">
                                                <i class="bi bi-x-octagon-fill"></i> Não
                                            </button>
                                            <button type="submit" class="btn btn-outline-danger mt-2">
                                                <i class="bi bi-trash"></i> Sim
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                
            <?php endforeach; ?>
        </div>
    </section>
    
    <script>
        document.getElementById('tipo_midia').addEventListener('change', function() {
            document.getElementById('foto_upload').style.display = this.value === 'foto' ? 'block' : 'none';
            document.getElementById('upload_video').style.display = this.value === 'video' ? 'block' : 'none';
            document.getElementById('youtube_link').style.display = this.value === 'youtube' ? 'block' : 'none';
        });
    </script>
    <!-- Inclui o footer -->
    <?php include '../../componentes/footerSeguro.php'; ?>
</body>
</html>