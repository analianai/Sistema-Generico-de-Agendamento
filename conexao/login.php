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
</head>
<body class="bg-primary">

<!-- Container principal -->
<div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
    <h2 class="text-center mb-1">Salão de Beleza</h2>
      <p class="text-center mb-4 fs-5">Entre e agende seu horário</p>
      <!-- Formulário de Login -->
      <form id="loginForm" action="corn.php" method="POST" novalidate>                   
        <div class="mb-3">
            <input type="text" name="username" class="form-control" id="username" placeholder="Email" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" id="password" placeholder="Senha" required>
        </div>
        <!-- Alert de erro (invisível por padrão) -->
        <div id="alertContainer" class="alert alert-danger d-none" role="alert">
            <ul id="errorList" class="mb-0"></ul>
        </div>
        <div class="mb-3 d-flex justify-content-center">
            <button type="submit" class="btn btn-primary me-4">Entrar</button>
            <button type="reset" class="btn btn-success">Limpar</button>
        </div>
    </form>
    <div class="text-center"><span>OU</span></div>
    
    <div class="mt-1 mb-4 text-center">
        Não tem uma conta?
        <a href="#" data-bs-toggle="modal" data-bs-target="#cadastroModal" data-bs-dismiss="modal">Cadastre-se</a>
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
        <!-- Modal for Cadastro -->
        <div class="modal fade" id="cadastroModal" tabindex="-1" aria-labelledby="cadastroModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title w-100" id="cadastroModalLabel">Cadastre-se</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="nomeCompleto" placeholder="Nome Completo">
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <input type="text" class="form-control me-2" id="celular" placeholder="Celular">
                            <input type="text" class="form-control" id="whatsapp" placeholder="WhatsApp">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="endereco" placeholder="Endereço">
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <select class="form-select me-2" aria-label="Default select example" placeholder="Estado">
                                <option selected>Estado</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                              </select>
                            <input type="text" class="form-control" id="cidade" placeholder="Cidade">
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <input type="text" class="form-control me-2" id="cpf" placeholder="CPF">
                            <input type="date" class="form-control" id="dataNascimento" placeholder="Data de Aniversário" >
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" id="email" placeholder="Email">
                        </div>
                        <div class="mb-3">

                            <input type="password" class="form-control" id="senha" placeholder="Senha">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" id="confirmarSenha" placeholder="Confirme sua senha">
                        </div>
                        <div class="mb-3 d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary me-4">Cadastrar</button>
                            <button type="reset" class="btn btn-success">Limpar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/script.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>