<?php
session_start();
require 'classes/usuarios.class.php';
require 'config.php';
require 'functions.php';
$user = new Usuarios($pdo);
if (isset($_SESSION['cLogin']) && !empty($_SESSION['cLogin'])) :
$nameUser = $user->GetUser($_SESSION['cLogin']);
endif;
?>
<html>
<head>
    <title>Classificados</title>
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <script type="text/javascript" src="./assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="./assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./assets/js/script.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="./" class="navbar-brand">Classificados</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <?php if (isset($_SESSION['cLogin']) && !empty($_SESSION['cLogin'])): ?>
                <li><a href="#"><?= $nameUser->nome ?></a></li>
                <li><a href="meus-anuncios.php">Meus Anúncios</a></li>
                <li><a href="sair.php">Sair</a></li>
            <?php else: ?>
                <li><a href="cadastro.php">Cadastre-se</a></li>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>

        </ul>
    </div>
</nav>