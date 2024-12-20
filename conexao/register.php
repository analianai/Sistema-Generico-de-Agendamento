<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $nivel_acesso = 0; // Usuário comum por padrão.

    $stmt = $mysqli->prepare("INSERT INTO usuarios (username, password_hash, nivel_acesso) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $username, $password, $nivel_acesso);

    if ($stmt->execute()) {
        echo "Usuário registrado com sucesso!";
    } else {
        echo "Erro ao registrar: " . $stmt->error;
    }
    $stmt->close();
}
?>
