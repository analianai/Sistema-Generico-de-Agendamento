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
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include './componentes/menu.php'; ?>

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
                            <input type="password" name="senha_up" class="form-control" id="senha_up" placeholder="Senha" required>
                            <button type="button" class="btn  border border-secondary-subtle rounded-end" onclick="togglePassword('senha_up')">
                                <i class="bi bi-eye" id="senha_up-icon"></i>
                            </button>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <!-- Confirmar Senha -->
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="password" name="confirmar_senha_up" class="form-control" id="confirmarSenha_up" placeholder="Confirme sua senha" required>
                            <button type="button" class="btn border border-secondary-subtle rounded-end" onclick="togglePassword('confirmarSenha_up')">
                                <i class="bi bi-eye" id="confirmarSenha_up-icon"></i>
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