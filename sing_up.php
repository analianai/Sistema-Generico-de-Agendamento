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
        body{
            background: rgb(230, 231, 230);
            }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top mb-5 bg-success bg-gradient">
        <div class="container">
            <a class="navbar-brand d-flex justify-content-start text-white" href="#">Salão de Beleza</a>
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
                </ul>
            </div>
        </div>
    </nav>

        <!-- Container principal -->
    <section class="container-fluid mt-5 mb-5">
        <div class="container vh-100 d-flex align-items-center justify-content-center">
            <div class="card shadow-lg ps-4 pe-4 pt-2 mt-5" style="width: 100%; max-width: 600px;">
                <h2 class="text-center mb-1">Salão de Beleza</h2>
                <p class="text-center mb-2 fs-5">Cadastre-se</p>
                <form id="cadastroForm" action="conexao/register.php" method="POST" class="needs-validation" novalidate>
                            <!-- Nome -->
                            <div class="mb-3">
                                <input type="text" name="nome" class="form-control" id="nome" placeholder="Nome" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <!-- Sobrenome -->
                            <div class="mb-3">
                                <input type="text" name="sobrenome" class="form-control" id="sobrenome" placeholder="Sobrenome" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <!-- Celular e WhatsApp -->
                            <div class="mb-3 d-flex justify-content-between">
                                <input type="text" name="celular" class="form-control me-2" id="celular" placeholder="Celular" pattern="\\d{11}" required>
                                <div class="invalid-feedback"></div>
                                <input type="text" name="whatsapp" class="form-control" id="whatsapp" placeholder="WhatsApp" pattern="\\d{11}">
                                <div class="invalid-feedback"></div>
                            </div>
                            <!-- Endereço -->
                            <div class="mb-3">
                                <input type="text" name="endereco" class="form-control" id="endereco" placeholder="Endereço" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <!-- Estado e Cidade -->
                            <div class="mb-3 d-flex justify-content-between">
                                <select name="estado" class="form-select me-2" required>
                                    <option value="" selected>Estado</option>
                                    <option value="AC">Acre</option>
                                    <option value="AL">Alagoas</option>
                                    <option value="AP">Amapá</option>
                                    <option value="AM">Amazonas</option>
                                    <option value="BA">Bahia</option>
                                    <option value="CE">Ceará</option>
                                    <option value="DF">Distrito Federal</option>
                                    <option value="ES">Espírito Santo</option>
                                    <option value="GO">Goiás</option>
                                    <option value="MA">Maranhão</option>
                                    <option value="MT">Mato Grosso</option>
                                    <option value="MS">Mato Grosso do Sul</option>
                                    <option value="MG">Minas Gerais</option>
                                    <option value="PA">Pará</option>
                                    <option value="PB">Paraíba</option>
                                    <option value="PR">Paraná</option>
                                    <option value="PE">Pernambuco</option>
                                    <option value="PI">Piauí</option>
                                    <option value="RJ">Rio de Janeiro</option>
                                    <option value="RN">Rio Grande do Norte</option>
                                    <option value="RS">Rio Grande do Sul</option>
                                    <option value="RO">Rondônia</option>
                                    <option value="RR">Roraima</option>
                                    <option value="SC">Santa Catarina</option>
                                    <option value="SP">São Paulo</option>
                                    <option value="SE">Sergipe</option>
                                    <option value="TO">Tocantins</option>
                                    <option value="EX">Estrangeiro</option>
                                </select>
                                <div class="invalid-feedback"></div>
                                <input type="text" name="cidade" class="form-control" id="cidade" placeholder="Cidade" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <!-- CPF e Data de Nascimento -->
                            <div class="mb-3 d-flex justify-content-between">
                                <input type="text" name="cpf" class="form-control me-2" id="cpf" placeholder="CPF" pattern="\\d{11}" required>
                                <div class="invalid-feedback"></div>
                                <input type="date" name="data_nascimento" class="form-control" id="dataNascimento" placeholder="Data de Nascimento" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <!-- Email -->
                            <div class="mb-3">
                                <input type="email" name="username" class="form-control" id="email" placeholder="Email" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <!-- Senha -->
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="password" name="senha" class="form-control" id="senha" placeholder="Senha" required>
                                    <button type="button" class="btn  border border-secondary-subtle rounded-end" onclick="togglePassword('senha')">
                                        <i class="bi bi-eye" id="senha-icon"></i>
                                    </button>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <!-- Confirmar Senha -->
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="password" name="confirmar_senha" class="form-control" id="confirmarSenha" placeholder="Confirme sua senha" required>
                                    <button type="button" class="btn border border-secondary-subtle rounded-end" onclick="togglePassword('confirmarSenha')">
                                        <i class="bi bi-eye" id="confirmarSenha-icon"></i>
                                    </button>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <!-- Alert de erro -->
                            <div id="alert" class="alert alert-danger d-none" role="alert">
                                <ul id="errorList" class="mb-0"></ul>
                            </div>
                            <!-- Botões -->
                            <div class="mb-3 d-flex justify-content-center">
                                <button type="reset" class="btn btn-danger me-4">Limpar</button>
                                <button type="submit" class="btn btn-success">Cadastrar</button>
                            </div>
                </form>
                <div class="mt-1 mb-4 text-center">
                        Se tem uma conta?
                        <a href="./sing_in.php" >Entre</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include './componentes/footer.php'; ?>  
</body>
</html>