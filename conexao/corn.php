<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mysqli = new mysqli("localhost", "root", "", "salao");

    if ($mysqli->connect_error) {
        die("Erro de conexão: " . $mysqli->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        header("Location: login.php?error=Preencha todos os campos");
        exit;
    }

    if ($stmt = $mysqli->prepare("SELECT password_hash, nivel_acesso FROM usuarios WHERE username = ?")) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($hashed_password, $nivel_acesso);
            $stmt->fetch();

            if ($password === $hashed_password) {
                // Armazena os dados do usuário na sessão
                $_SESSION['username'] = $username;
                $_SESSION['nivel_acesso'] = $nivel_acesso;

                // Redireciona com base no nível de acesso
                if ($nivel_acesso == 1) {
                    header("Location: ../areaSegura/admin_dashboard.php");
                } else if ($nivel_acesso == 0) {
                    header("Location: ../areaSegura/user_dashboard.php");
                }
                exit;
            } else {
                header("Location: login.php?error=Senha incorreta");
                exit;
            }
        } else {
            header("Location: login.php?error=Usuário não encontrado");
            exit;
        }
    } else {
        header("Location: login.php?error=Erro no banco de dados");
        exit;
    }
}
?>
