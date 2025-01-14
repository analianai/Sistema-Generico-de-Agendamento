<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salão de Beleza</title>
    <!-- Bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap css Icons-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('assets/img/makes.jpg');
        }
    </style>
</head>
<body>

<!-- Erro -->
    <?php include './componentes/erro.php'; ?>
<!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-md-top bg-success bg-gradient">
        <div class="container">
            <a class="navbar-brand d-flex justify-content-start text-white" href="index.php">Salão de Beleza</a>
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon text-white"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <a class="nav-link text-white" href="index.php">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="sobre.php">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="midia.php">Mídia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="servicos.php">Serviços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="faq.php">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a type="button" href="sign_in.php" class="btn btn-outline-light ms-3"><i class="bi bi-box-arrow-in-right"></i> Entrar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<!-- Container principal -->
    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
            <h2 class="text-center mb-1">Salão de Beleza</h2>
            <p class="text-center mb-4 fs-5">Entre e agende seu horário</p>
            <!-- Formulário de Login -->
            <form id="loginForm" action="./conexao/login.php" method="POST" novalidate>                  
                            <div class="mb-3">
                                <input type="text" name="username" class="form-control" id="username" placeholder="Email" required>
                            </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" id="password" placeholder="Senha" required>
                                <button type="button" class="btn  border border-secondary-subtle rounded-end" onclick="togglePassword('password')">
                                    <i class="bi bi-eye" id="password-icon"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Alert de erro (invisível por padrão) -->
                        <div id="alertContainer" class="alert alert-danger d-none" role="alert">
                            <ul id="errorList" class="mb-0"></ul>
                        </div>
                        <div class="mb-3 d-flex justify-content-center">
                            <button type="reset" class="btn btn-danger me-4">Limpar</button>
                            <button type="submit" class="btn btn-success">Entrar</button>  
                        </div>
                    </form>
            <div class="text-center"><span>OU</span></div>
            
            <div class="mt-1 mb-4 text-center">
                Não tem uma conta?
                <a href="./sign_up.php">Cadastre-se</a>
            </div>
            <div class="d-flex align-items-center mt-3">
                <hr class="flex-grow-1" />
                <button type="button"
                class="btn btn-light px-3 mx-2 d-flex align-items-center justify-content-center">
                <img class="border-opacity-10" src="https://developers.google.com/identity/images/g-logo.png"
                    alt="Google" width="30px">
                </button>
            <hr class="flex-grow-1" />
            </div>
        </div>
    </div>
    
     <!-- Footer -->
    <?php include './componentes/footer.php'; ?> 
</body>
</html>