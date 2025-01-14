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
            background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('assets/img/depilacao.webp') no-repeat center center fixed;
        }
        .mensagem-erro-cadastro {
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
<!-- Erro -->
<?php if (isset($_GET['erro']) && !empty($_GET['erro'])): ?>
        <div id="mensagem-erro" class="alert alert-danger mt-5 d-flex justify-content-between mensagem-erro-cadastro" >
            <?= htmlspecialchars($_GET['erro']) ?>
            <button type="button" class="btn-close" aria-label="Close" onclick="this.parentElement.style.display='none';">
                <span aria-hidden="true"></span>
            </button>
        </div>
<?php endif; ?>
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
                                <option value="Acre">Acre</option>
                                <option value="Alagoas">Alagoas</option>
                                <option value="Amapá">Amapá</option>
                                <option value="Amazonas">Amazonas</option>
                                <option value="Bahia">Bahia</option>
                                <option value="Ceará">Ceará</option>
                                <option value="Distrito Federal">Distrito Federal</option>
                                <option value="Espírito Santo">Espírito Santo</option>
                                <option value="Goiás">Goiás</option>
                                <option value="Maranhão">Maranhão</option>
                                <option value="Mato Grosso">Mato Grosso</option>
                                <option value="Mato Grosso do Sul">Mato Grosso do Sul</option>
                                <option value="Minas Gerais">Minas Gerais</option>
                                <option value="Pará">Pará</option>
                                <option value="Paraíba">Paraíba</option>
                                <option value="Paraná">Paraná</option>
                                <option value="Pernambuco">Pernambuco</option>
                                <option value="Piauí">Piauí</option>
                                <option value="Rio de Janeiro">Rio de Janeiro</option>
                                <option value="Rio Grande do Norte">Rio Grande do Norte</option>
                                <option value="Rio Grande do Sul">Rio Grande do Sul</option>
                                <option value="Rondônia">Rondônia</option>
                                <option value="Roraima">Roraima</option>
                                <option value="Santa Catarina">Santa Catarina</option>
                                <option value="São Paulo">São Paulo</option>
                                <option value="Sergipe">Sergipe</option>
                                <option value="Tocantins">Tocantins</option>
                                <option value="Estrangeiro">Estrangeiro</option>
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
    <!-- Script para ocultar a mensagem após 4 segundos -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mensagemErro = document.getElementById('mensagem-erro');
            if (mensagemErro) {
                setTimeout(() => {
                    mensagemErro.style.transition = 'opacity 0.5s';
                    mensagemErro.style.opacity = '0';
                    setTimeout(() => mensagemErro.remove(), 500); // Remove o elemento após a animação
                }, 4000); // Tempo de exibição: 4 segundos
            }
        });
    </script>

</body>
</html>