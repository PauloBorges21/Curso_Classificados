<?php
session_start();
require 'classes/anuncios.class.php';
require 'config.php';
if (isset($_SESSION['cLogin']) && !empty($_SESSION['cLogin'])) {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $idDescode = base64_decode($_GET['id']);
       // echo $idDescode;
        $a = new Anuncios($pdo);
        $excluir = $a->desativarAnuncio($idDescode);
        //$excluir = $a->excluirAnuncio(base64_decode($_GET['id']));

        header('Location: meus-anuncios.php');
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}

