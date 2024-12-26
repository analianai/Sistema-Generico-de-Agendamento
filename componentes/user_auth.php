<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['nivel_acesso'] != 0) {
    header("Location: ../../sing_in.php?error=Acesso negado.");
    exit;
}

?>