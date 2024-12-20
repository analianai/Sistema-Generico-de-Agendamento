    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top bg-success bg-gradient">
        <div class="container">
            <a class="navbar-brand d-flex justify-content-start text-white" href="#">Salão de Beleza</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
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
                        <a class="nav-link text-white" data-bs-toggle="modal" data-bs-target="#agendamentoModal" href="#">Agendamento</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Modal for Agendamento -->
    <div class="modal fade" id="agendamentoModal" tabindex="-1" aria-labelledby="agendamentoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title w-100" id="agendamentoModalLabel">Entre e agende seu horário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm" action="conexao/corn.php" method="POST" novalidate>                   
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
                            <button type="submit" class="btn btn-success me-4">Entrar</button>
                            <button type="reset" class="btn btn-danger">Limpar</button>
                        </div>
                    </form>
                    <div class="text-center"><span>OU</span></div>
                    
                    <div class="mt-1 mb-4 text-center">
                        Não tem uma conta?
                        <a href="#" class="text-primary text-decoration-none" data-bs-toggle="modal" data-bs-target="#cadastroModal" data-bs-dismiss="modal">Cadastre-se</a>
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
                            <button type="submit" class="btn btn-success me-4">Cadastrar</button>
                            <button type="reset" class="btn btn-danger">Limpar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>